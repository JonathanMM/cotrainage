<?php
session_start();
if((isset($_SESSION['co'])) && $_SESSION['co'] === true)
	header('location: index.php');

if(isset($_POST['envoi']) && $_POST['envoi'] == 1)
{
	require('config.inc.php');
	$pseudo = htmlspecialchars($_POST['pseudo'], ENT_QUOTES);
	$mdp = hash('sha512', $_POST['mdp']);
	$requete = mysql_query('SELECT * FROM '.$bdd_prefixe.'user WHERE pseudo = "'.$pseudo.'" AND mdp = "'.$mdp.'" AND valide = 1');
	mysql_close();
	if(!($requete === false) && $donnees = mysql_fetch_array($requete))
	{
		$_SESSION['pseudo'] = $donnees['pseudo'];
		$_SESSION['id'] = $donnees['id'];
		$_SESSION['co'] = true;
		header('location: index.php');
	} else
		$erreur = "Pseudo et/ou mot de passe incorrect(s).";
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Cotrainage</title>
		<link rel="icon" type="image/png" href="images/favicon.png" />

		<link rel="stylesheet" href="main.css" type="text/css" media="screen" />
	</head>

	<body>
		<header>
			<h1>Cotrainage</h1>
		</header>

		<?php if(isset($erreur)) { ?><p><?php echo $erreur; ?></p><?php } ?>

		<form action="connexion.php" method="post"><p>
			<label name="pseudo">Pseudo : <input name="pseudo" /></label><br />
			<label name="mdp">Mot de passe : <input type="password" name="mdp" /></label><br />
			<input type="hidden" name="envoi" value="1" />
			<input type="submit" value="Valider" />
		</p></form>

		<p><a href="inscription.php">S'inscrire</a> - <a href="oubli_mdp.php">Mot de passe oublié ?</a></p>
	</body>
</html>