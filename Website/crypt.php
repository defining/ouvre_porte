<?php
if (isset($_POST['login']) AND isset($_POST['pass']))
{
	$login = $_POST['login'];
	$pass_crypte =crypt($_POST['pass']); //crypte le mdp	

	echo'<p>ligne à copier dans le .htpasswd :<br />'. $login .':'.$pass_crypte .'</p>';

}
else // si on a pas rempli le formulaire
{
?>

<p>Entrez votre login et votre mdp pour le crypter.</p>
<form method="post">
<p>
Login : <input type="text" name="login"><br />
Mot de passe : <input type="text" name="pass"><br /> <br />

<input type="submit" value="Crypter !">
</p>
</form>
<?php
}
?>
