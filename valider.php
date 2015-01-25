<?php
session_start();
if((isset($_SESSION['co'])) && $_SESSION['co'] === true)
	header('location: index.php');

if(isset($_GET['id']) && isset($_GET['pseudo']))
{
	require('config.inc.php');
	$pseudo = htmlspecialchars($_GET['pseudo']);
	$id = intval($_GET['id']);
	mysql_query('UPDATE '.$bdd_prefixe.'user SET valide = 1 WHERE id = '.$id.' AND pseudo = "'.$pseudo.'"');
	mysql_close();
	header('location: connexion.php');
}
?>