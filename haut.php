<?php
@session_start();
if(!(isset($_SESSION['co'])) || $_SESSION['co'] === false)
	header('location: connexion.php');
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
include('config.inc.php');
?>
<!DOCTYPE html>
<html lang="fr">

	<head>
	<meta charset="utf-8">
	<title>Cotrainage</title>

	<!-- meta -->
	<meta name="description" content="" />
	<meta name="author" content="JonathanMM" />

	<!-- <link rel="shortcut icon" href="favicon.ico"> -->

	<link rel="stylesheet" href="main.css" type="text/css"  media="screen" />

	</head>


	<body>
	<header><h1>Cotrainage</h1>
	<nav><a href="index.php">Accueil</a></nav></header>
	<div id="contenu">