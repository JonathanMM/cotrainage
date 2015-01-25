<?php
session_start();
if((isset($_SESSION['co'])) && $_SESSION['co'] === true)
	header('location: index.php');

if(isset($_POST['envoi']) && $_POST['envoi'] == 1)
{
	require('config.inc.php');
	if($_POST['mdp'] == $_POST['remdp'])
	{
		$pseudo = htmlspecialchars($_POST['pseudo']);
		$requete = mysql_query('SELECT COUNT(id) AS count_id FROM '.$bdd_prefixe.'user WHERE pseudo = "'.$pseudo.'"');
		$donnees = mysql_fetch_array($requete);
		if($donnees['count_id'] == 0)
		{
			$mdp = hash('sha512', $_POST['mdp']);
			mysql_query('INSERT INTO '.$bdd_prefixe.'user (pseudo, mdp, valide) VALUES ("'.$pseudo.'", "'.$mdp.'", 0)') or die(mysql_error());
			$id = mysql_insert_id();
			$message = "Bonjour,
ce courriel permet de valider votre compte sur le site Cotrainage\n
<http://cotrainage.nocle.fr/valider.php?id=$id&pseudo=$pseudo>";
			mysql_close();
			mail($pseudo.'@enssat.fr', "Validation de votre compte sur cotrainage", wordwrap(utf8_decode($message), 70));
			$erreur = "Un courriel vient de partir pour valider votre compte";
		} else
			$erreur = "Un compte existe déjà";
	} else
		$erreur = "Les mots de passes ne correspondent pas";
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
			<h2>Inscription</h2>
		</header>

		<?php if(isset($erreur)) { ?><p><?php echo $erreur; ?></p><?php } ?>

		<form action="inscription.php" method="post"><p>
			<label name="pseudo">Courriel : <input name="pseudo" />@enssat.fr</label><br />
			<label name="mdp">Mot de passe : <input type="password" name="mdp" /></label><br />
			<label name="mdp">Retapez votre mdp : <input type="password" name="remdp" /></label><br />
			<input type="hidden" name="envoi" value="1" />
			<input type="submit" value="Valider" />
		</p></form>

		<p><a href="connexion.php">Se connecter</a></p>
	</body>
</html>
