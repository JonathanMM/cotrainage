<?php
session_start();
if(!isset($_POST['envoi']) || $_POST['envoi'] != 'Envoyer')
    header('location: index.php');

$numero = intval($_POST['numero']);
$date_string = htmlspecialchars($_POST['date']);
$type = htmlspecialchars($_POST['type']);
if(isset($_POST['voiture']))
	$voiture = intval($_POST['voiture']);
else
	$voiture = 0;
if(isset($_POST['place']))
	$place = intval($_POST['place']);
else
	$place = 0;
	
if(isset($_POST['notif']) && $_POST['notif'] == 1)
  $notif = 1;
else
  $notif = 0;

//On va récupérer les horaires sur infolignes
//Cas spécial : TER
if(($numero >= 50000 && $numero < 60000) && $type == 'ter')
	$num = '8'.$numero;
else
	$num = $numero;
//On regarde la date
$date = date_create_from_format('Y-m-d', $date_string);
$date_haute = date_create(time() + 86400 * 4);
$liste_date = array(date_format(date_create('yesterday'), 'Y|m|d'), date_format(date_create('today'), 'Y|m|d'), date_format(date_create('today +1day'), 'Y|m|d'),
		    date_format(date_create('today +2days'), 'Y|m|d'), date_format(date_create('today +3days'), 'Y|m|d'), date_format(date_create('today +4days'), 'Y|m|d'));
$array_recherche = array();
if($date > $date_haute) //Hors intervalle
{
	if($num != $numero)
	{
		foreach($liste_date as $d)
		{
			$array_recherche[] = $num.'&date_num_train='.$d;
			$array_recherche[] = $numero.'&date_num_train='.$d;
		}
	} else {
		foreach($liste_date as $d)
			$array_recherche[] = $numero.'&date_num_train='.$d;
	}
} else {
	if($num != $numero)
	{
		$array_recherche[] = $num.'&date_num_train='.date_format($date, 'Y|m|d');
		$array_recherche[] = $numero.'&date_num_train='.date_format($date, 'Y|m|d');
	} else
		$array_recherche[] = $numero.'&date_num_train='.date_format($date, 'Y|m|d');
}

$erreur = true;
$i = 0;
$gare = array();
include('haut.php');
while($erreur && $i < count($array_recherche))
{
	$in_erreur = false;
	$file = new DOMDocument();
	@$file->loadHTMLFile('http://www.infolignes.com/recherche.php?num_train='.$array_recherche[$i]);
	//On cherche l'erreur
	$div = $file->getElementsByTagName("div");
	foreach($div as $table)
	{
	    if($table->hasAttribute("class") && $table->getAttribute("class") == 'erreur')
		$in_erreur = true;
	}
	if(!$in_erreur)
	{
		//On est bon :)
		$tableau = $file->getElementsByTagName("tbody")->item(0);
		$tr = $tableau->getElementsByTagName("tr");
		for($j = 0; $j < $tr->length; $j++)
		{
			$td = $tr->item($j)->getElementsByTagName("td");
			$nom_gare = utf8_decode(trim($td->item(0)->nodeValue));
			//On cherche la gare dans la BDD
			$requete = mysql_query('SELECT id FROM '.$bdd_prefixe.'gare WHERE nom = "'.$nom_gare.'"');
			if(!($requete === false))
			{
				$donnees = mysql_fetch_array($requete);
				if(isset($donnees['id']))
					$id_gare = $donnees['id'];
				else
				{
					mysql_query('INSERT INTO '.$bdd_prefixe.'gare (nom) VALUES ("'.$nom_gare.'")');
					$id_gare = mysql_insert_id();
				}
			} else
			{
				mysql_query('INSERT INTO '.$bdd_prefixe.'gare (nom) VALUES ("'.$nom_gare.'")');
				$id_gare = mysql_insert_id();
			}
			$gare[] = array($nom_gare, substr(trim($td->item(1)->nodeValue), 6), $id_gare);
		}
		$erreur = false;
	}
	$i++;
}
if($erreur)
	echo '<p>Votre train n\'a pas été trouvé :(</p>';
else
{
	//echo 'Trouvé :)';
	$deja_train = false;
	$requete = mysql_query('SELECT id FROM '.$bdd_prefixe.'train WHERE numero = "'.$numero.'" AND date = "'.$date_string.'"');
	if(!($requete === false))
	{
		$donnees = mysql_fetch_array($requete);
		if(isset($donnees['id']))
		{
			$id_train = $donnees['id'];
			$deja_train = true;
		} else
		{
			mysql_query('INSERT INTO '.$bdd_prefixe.'train (numero, date, type) VALUES ('.$numero.', "'.$date_string.'", "'.$type.'")');
			$id_train = mysql_insert_id();
		}
	} else
	{
		mysql_query('INSERT INTO '.$bdd_prefixe.'train (numero, date, type) VALUES ('.$numero.', "'.$date_string.'", "'.$type.'")');
		$id_train = mysql_insert_id();
	}
?>
<h2>Ajouter la desserte du train</h2>
<form action="valider_train.php" method="post">
<p>
<table>
<tr><th>Gare</th><th>Heure</th><th>Départ</th><th>Arrivée</th></tr>
<?php
foreach($gare as $g)
{
	if(!$deja_train)
	{
		$e = explode('h', $g[1]);
		mysql_query('INSERT INTO '.$bdd_prefixe.'desserte (id_train, gare, heure) VALUES ('.$id_train.', '.$g[2].', "'.$e[0].':'.$e[1].':00")');
	}
	echo '<tr><td>'.$g[0].'</td><td>'.$g[1].'</td><td><input type="radio" name="depart" value="'.$g[2].'" /></td><td><input type="radio" name="arrive" value="'.$g[2].'" /></td></tr>';
}
?>
</table>
<input type="hidden" name="id_train" value="<?php echo $id_train; ?>" />
<input type="hidden" name="place" value="<?php echo $place; ?>" />
<input type="hidden" name="voiture" value="<?php echo $voiture; ?>" />
<input type="hidden" name="notif" value="<?php echo $notif; ?>" />
<input type="submit" name="envoi" value="Envoyer" />
</p>
</form>
<?php
}
include('bas.php'); ?>