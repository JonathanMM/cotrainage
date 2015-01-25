<?php include('haut.php'); ?>
<h2>Ajouter un train</h2>
<form action="ajout_desserte.php" method="post">
<p>
Numéro du train : <input name="numero" /><br />
Date : <input name="date" type="date" /> (Format : AAAA-MM-JJ)<br />
Type : <select name="type">
<option value="ter">ter</option>
<option value="tgv">TGV</option>
<option value="car">Car</option>
</select><br />
Voiture : <input name="voiture" /> (Éventuellement)<br />
Place : <input name="place" /> (Éventuellement)<br />
<input type="checkbox" name="notif" value="1" /> Recevoir une notification en cas de nouveau passager dans mon train.<br />
<input type="submit" name="envoi" value="Envoyer" />
</p>
</form>
<?php include('bas.php'); ?>