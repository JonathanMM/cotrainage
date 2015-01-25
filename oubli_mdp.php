<?php
session_start();
if((isset($_SESSION['co'])) && $_SESSION['co'] === true)
	header('location: index.php');
	
require('config.inc.php');
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

	<h2>Oubli de mot de passe</h2>

<?php 
if(isset($_POST['envoi']) && $_POST['envoi'] == 2)
{
	if($_POST['code'] == $_SESSION['code'])
	{
		$id = intval($_POST['id']);
		$list = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$mdp = '';
		for($i = 0; $i < 8; $i++)
			$mdp .= $list[rand(0, strlen($list) - 1)];

		echo '<p>Votre nouveau mot de passe est : '.$mdp.'</p>';
		$mdp_hash = hash('sha512', $mdp);
		mysql_query('UPDATE '.$bdd_prefixe.'user SET mdp = "'.$mdp_hash.'" WHERE id = '.$id) or die(mysql_error());
	} else {
		?>
		<p>Code incorrect !</p>
		<form action="oubli_mdp.php" method="post">
		<p>
		<label name="courriel">Code : <input name="code" /></label>
		<input type="hidden" name="envoi" value="2" />
		<input type="hidden" name="id" value="<?php echo intval($_POST['id']); ?>" />
		<input type="submit" value="OK" />
		</p></form>
	<?php }

} elseif(isset($_POST['envoi']) && $_POST['envoi'] == 1)
{
    $courriel = htmlspecialchars($_POST['courriel']);
    $requete = mysql_query('SELECT id, pseudo FROM '.$bdd_prefixe.'user WHERE pseudo = "'.$courriel.'"');

    if($donnees = mysql_fetch_array($requete))
    {
	$list = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$code = '';
	for($i = 0; $i < 8; $i++)
		$code .= $list[rand(0, strlen($list) - 1)];

	$_SESSION['code'] = $code;
	$message = "Bonjour ".$donnees['pseudo']."\n
Quelqu\'un (probablement vous) a fait une demande de nouveau mot de passe sur Cotrainage.Nocle.fr.\n
Pour obtenir un nouveau mot de passe, le code est : ".$code."\n
Si vous n\'avez pas demander de changement de mot de passe, merci d\'ignorer ce courriel\n
<http://cotrainage.nocle.fr>";
	mail($courriel.'@enssat.fr', 'Oubli du mot de passe sur Cotrainage', wordwrap($message, 70));
?>
<form action="oubli_mdp.php" method="post">
	<p>Veuillez taper le code que vous avez reçu par mail :<br />
	<label name="courriel">Code : <input name="code" /></label>
	<input type="hidden" name="envoi" value="2" />
	<input type="hidden" name="id" value="<?php echo $donnees['id']; ?>" />
	<input type="submit" value="OK" />
	</p></form>
<?php
    } else {
       echo "Courriel inconnu";
    }
} else { ?>
<?php if(isset($erreur)) { ?><p><?php echo $erreur; ?></p><?php } ?>
	<form action="oubli_mdp.php" method="post">
	<p>Vous avez oublié votre mot de passe ? Sachez tout d'abord que c'est vraiment pas bien… Vous auriez pu un effort quand même. C'est pas si dur que ça de retenir un mot de passe, non ?<br />
	Bon, en tout cas, vous avez une chance de le récupérer. Oh, y a juste trois fois rien à faire : Vous devez remplir le formulaire G-42, pour l'obtenir, il faut se rendre au guichet A-12, ce qui nécessite d'avoir un laisser passer Y-7, celui s'obtenant en faisant une demande avec un préavis de 2 mois minimum et 2 mois et 3 minutes maximums en tournant 3 fois sur vous même avant d'envoyer un courriel au standardiste du bureau O-45b, dont vous pouvez obtenir son adresse en remplissant le formulaire X-6a, celui concernant la demande d'accès au courriel du standardiste du bureau O-45b, et qui donc permettra de se connecter via un login demandé à l'aide du formulaire V-fe remis en main propre au bureau T-7 dont son emplacement est précisé sur le plan d'accès C-48 (attention, le C-47 ne contient pas cette information) ainsi que le mot de passe que vous avez oublié.<br />
	Vous pouvez aussi indiquer votre courriel, mais pour le coup, c'est moins drôle…<br />
	<label name="courriel">Courriel : <input name="courriel" />@enssat.fr</label>
	<input type="hidden" name="envoi" value="1" />
	<input type="submit" value="OK" />
	</p></form>
<?php } ?>

	<nav><a href="index.php">Retour à l'accueil</a></nav>
	</body>
</html>