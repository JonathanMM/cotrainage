<?php
session_start();
if(!isset($_GET['id']) || intval($_GET['id']) < 1)
    header('location: index.php');
//Vérifier aussi qu'il a le droit sur ce prise_train

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
require_once('config.inc.php');
$id = intval($_GET['id']);
//On vérifie qu'on a le droit de modif
$requete = mysql_query('SELECT * FROM '.$bdd_prefixe.'prise_train WHERE id = '.$id);
if(!($requete === false))
{
	$donnees = mysql_fetch_array($requete);
	if($donnees['id_user'] != $_SESSION['id'])
		header('location: index.php');
} else
	header('location: index.php');

include('haut.php'); ?>
<h2>Modifier</h2>
<?php include('bas.php'); ?>