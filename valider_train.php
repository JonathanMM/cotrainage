<?php
session_start();
if(!isset($_POST['envoi']) || $_POST['envoi'] != 'Envoyer')
    header('location: index.php');
include('haut.php');

$place = intval($_POST['place']);
$voiture = intval($_POST['voiture']);
$depart = intval($_POST['depart']);
$arrive = intval($_POST['arrive']);
$id_train = intval($_POST['id_train']);
$notif = intval($_POST['notif']);

//On cherche les autres passagers du train :)
$requete = mysql_query('SELECT pseudo, numero, type, date, a.nom AS nom_gare_arrive, d.nom AS nom_gare_depart, place, voiture, notif FROM '.$bdd_prefixe.'prise_train p
LEFT JOIN '.$bdd_prefixe.'user u ON u.id = p.id_user
LEFT JOIN '.$bdd_prefixe.'gare d ON d.id = p.gare_depart
LEFT JOIN '.$bdd_prefixe.'gare a ON a.id = p.gare_arrive
INNER JOIN '.$bdd_prefixe.'train t ON t.id = p.id_train
WHERE p.id_train = '.$id_train);
$resultat = false;
$autres = '';
if(!($requete === false))
{
    $requete2 = mysql_query('SELECT nom FROM '.$bdd_prefixe.'gare WHERE id = '.$depart);
    $donnees2 = mysql_fetch_array($requete2);
    $requete3 = mysql_query('SELECT nom FROM '.$bdd_prefixe.'gare WHERE id = '.$arrive);
    $donnees3 = mysql_fetch_array($requete3);
	while($donnees = mysql_fetch_array($requete))
	{
		$resultat = true;
		$autres .= '<li>'.$donnees['pseudo'].', '.$donnees['nom_gare_depart'].' → '.$donnees['nom_gare_arrive'];
		if($donnees['voiture'] != 0)
			$autres .= ', voiture '.$donnees['voiture'].', place '.$donnees['place'];
		$autres .= '</li>';
		if($donnees['notif'] == 1)
		{
		    $message = "Bonjour,\n
\n
Je suis le site de cotrainage et je viens vous informer par ce courriel que quelqu'un vient de s'ajouter dans un train que vous allez prendre prochaînement !\n
Il s'agit de ".$_SESSION['pseudo'].", dans le train ".$donnees['type']." ".$donnees['numero']." du ".$donnees['date'].", entre ".$donnees2['nom']." et ".$donnees3['nom']."\n";
		    if($voiture != 0)
			  $message .= "Vous le trouverez voiture ".$voiture.", place ".$place."\n";
		    $message .= "\n
En vous espérant un bon voyage,\n
http://cotrainage.nocle.fr\n
\n
Note : En vertu de la loi n° 78-17 du 6 janvier 1978 modifiée, vous disposez d'un droit d'accès et de rectification relativement aux informations qui vous concernent. Pour l'exercer, envoyez un courriel à jmagano@enssat.fr";
		    mail($donnees['pseudo'].'@enssat.fr', "Nouveau passager dans votre train", wordwrap(utf8_decode($message), 70));
		}
	}
}
mysql_query('INSERT INTO '.$bdd_prefixe.'prise_train (id_user, id_train, gare_depart, gare_arrive, place, voiture, notif) VALUES ('.$_SESSION['id'].', '.$id_train.', '.$depart.', '.$arrive.', '.$place.', '.$voiture.', '.$notif.')') or die(mysql_error());
?>
<p>Votre train a été ajouté avec succès :)<br />
<?php if($resultat) { ?>
Et vous aurez même de la compagnie !</p>
<ul><?php echo $autres; ?></ul>
<p>
<?php } ?>
<a href="index.php">Retour à l'accueil</a></p>
<?php
include('bas.php');
?>