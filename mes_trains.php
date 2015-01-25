<?php include('haut.php'); ?>
<h2>Mes trains</h2>
<table>
<tr><th>Train</th><th>Date</th><th>Départ</th><th>Arrivée</th><th>Emplacement</th><th>Action</th></tr>
<?php $requete = mysql_query('SELECT p.id, numero, date, type, dg.nom AS nom_gare_depart, ag.nom AS nom_gare_arrive, voiture, place, dd.heure AS heure_depart, ad.heure AS heure_arrive
FROM '.$bdd_prefixe.'prise_train p
LEFT JOIN '.$bdd_prefixe.'train t ON t.id = p.id_train
LEFT JOIN '.$bdd_prefixe.'gare dg ON dg.id = p.gare_depart
LEFT JOIN '.$bdd_prefixe.'gare ag ON ag.id = p.gare_arrive
LEFT JOIN '.$bdd_prefixe.'desserte dd ON dd.id_train = p.id_train AND dd.gare = p.gare_depart
LEFT JOIN '.$bdd_prefixe.'desserte ad ON ad.id_train = p.id_train AND ad.gare = p.gare_arrive
WHERE p.id_user = '.$_SESSION['id']) or die(mysql_error());
while(!($requete === false) && $donnees = mysql_fetch_array($requete))
{ 
    echo '<tr><td>';
    if($donnees['type'] == 'ter')
	    echo 'ter';
    elseif($donnees['type'] == 'tgv')
	    echo 'TGV';
    elseif($donnees['type'] == 'car')
	    echo 'Car';
    echo ' '.$donnees['numero'].'</td><td>'.$donnees['date'].'</td><td>'.$donnees['nom_gare_depart'].' '.$donnees['heure_depart'].'</td>';
    echo '<td>'.$donnees['nom_gare_arrive'].' '.$donnees['heure_arrive'].'</td><td>';
    if($donnees['voiture'] != 0)
	    echo 'Voiture '.$donnees['voiture'].', place '.$donnees['place'];
    echo '</td><td><a href="supprimer.php?id='.$donnees['id'].'">Supprimer</a></td></tr>';
    //<a href="modifier.php?id='.$donnees['id'].'">Modifier</a>
}
?>
</table>
<?php include('bas.php'); ?>