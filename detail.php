<?php
if(!isset($_GET['id']) || intval($_GET['id']) < 1)
    header('location: index.php');
/*Copyright (C) 2012 Magano Jonathan

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.*/
include('haut.php');
$id = intval($_GET['id']);
?>
<h2>Détail d'un train</h2>
<?php $requete = mysql_query('SELECT * FROM '.$bdd_prefixe.'train WHERE id = '.$id);
$donnees = mysql_fetch_array($requete);
    echo '<p>';
    if($donnees['type'] == 'ter')
	    echo 'ter';
    elseif($donnees['type'] == 'TGV')
	    echo 'TGV';
    elseif($donnees['type'] == 'car')
	    echo 'Car';
    echo ' '.$donnees['numero'].'<br />Date : '.$donnees['date'].'</p>';
?>
<table>
<?php $requete = mysql_query('SELECT nom, heure FROM '.$bdd_prefixe.'desserte d
LEFT JOIN '.$bdd_prefixe.'gare g ON g.id = d.gare
WHERE id_train = '.$id);
while($donnees = mysql_fetch_array($requete))
{
	echo '<tr><td>'.$donnees['nom'].'</td><td>'.$donnees['heure'].'</td></tr>';
}
?>
</table>

<p>Personnes qui prennent ce train</p>
<ul>
<?php $requete = mysql_query('SELECT pseudo, a.nom AS nom_gare_arrive, d.nom AS nom_gare_depart, place, voiture
FROM '.$bdd_prefixe.'prise_train p
LEFT JOIN '.$bdd_prefixe.'user u ON u.id = p.id_user
LEFT JOIN '.$bdd_prefixe.'gare a ON a.id = p.gare_arrive
LEFT JOIN '.$bdd_prefixe.'gare d ON d.id = p.gare_depart
WHERE id_train = '.$id);
while($donnees = mysql_fetch_array($requete))
{
	echo '<li>'.$donnees['pseudo'].', '.$donnees['nom_gare_depart'].' → '.$donnees['nom_gare_arrive'];
	if($donnees['voiture'] != 0)
		echo ', voiture '.$donnees['voiture'].', place '.$donnees['place'];
	echo '</li>';
}
?>
</ul>
<?php include('bas.php'); ?>