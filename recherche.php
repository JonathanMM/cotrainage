<?php
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
if(isset($_POST['envoi']) && $_POST['envoi'] == 'Rechercher')
{
	$date = htmlspecialchars($_POST['date']);
	if(isset($_POST['numero']))
		$numero = intval($_POST['numero']);
	else
		$numero = 0;

	$depart = intval($_POST['depart']);
	$arrive = intval($_POST['arrive']);
	if($numero > 0)
		$requete = mysql_query('SELECT id, numero, type FROM '.$bdd_prefixe.'train WHERE date = "'.$date.'" AND numero = "'.$numero.'"') or die(mysql_error());
	else
		$requete = mysql_query('SELECT t.id, numero, type FROM '.$bdd_prefixe.'train t LEFT JOIN '.$bdd_prefixe.'desserte a ON a.id_train = t.id
		LEFT JOIN '.$bdd_prefixe.'desserte d ON d.id_train = t.id WHERE date = "'.$date.'" AND d.gare = '.$depart.' AND a.gare = '.$arrive) or die(mysql_error());
	$resultat = true;
} else {
	$requete = mysql_query('SELECT id, nom FROM '.$bdd_prefixe.'gare ORDER BY nom ASC');
	$resultat = false;
} ?>
<h2>Rechercher</h2>
<?php if($resultat) { ?>
<table>
<tr><th>Train</th><th></th></tr>
<?php while(!($requete === false) && $donnees = mysql_fetch_array($requete))
{
	echo '<tr><td>';
    if($donnees['type'] == 'ter')
	    echo 'ter';
    elseif($donnees['type'] == 'tgv')
	    echo 'TGV';
    elseif($donnees['type'] == 'car')
	    echo 'Car';
    echo ' '.$donnees['numero'].'</td><td><a href="detail.php?id='.$donnees['id'].'">Detail</a></td></tr>';
}
?>
</table>
<?php } else { ?>
<form action="recherche.php" method="post">
<p>
Date : <input name="date" type="date" /> (Format : AAAA-MM-JJ)<br />
Numéro du train : <input name="numero" /><br />
OU<br />
Gare de départ : <select name="depart">
<?php
while(!($requete === false) && $donnees = mysql_fetch_array($requete))
	echo '<option value="'.$donnees['id'].'">'.$donnees['nom'].'</option>';
?>
</select><br />
Gare d'arrivée : <select name="arrive">
<?php
mysql_data_seek($requete, 0); //remettre à zéro les résultats de $requete
while(!($requete === false) && $donnees = mysql_fetch_array($requete))
	echo '<option value="'.$donnees['id'].'">'.$donnees['nom'].'</option>';
?>
</select><br />
<em>Si votre gare n'est pas listé, personne ne prend un train la desservant :'(</em><br />
<input type="submit" name="envoi" value="Rechercher" />
</p></form>
<?php } include('bas.php'); ?>