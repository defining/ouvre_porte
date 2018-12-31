<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<head>

<?php
//Connection à la base de données
$base = mysql_connect ('xxx.xxx.xxx.xxx','yyy','zzz') or die ('ERREUR'.mysql_error());
mysql_select_db ('elevage',$base) or die ('ERREUR'.mysql_error());


$Index=$_GET['Index'];
$sql="SELECT * FROM elevage.Entrees_Sorties WHERE Entrees_Sorties.Index=$Index";

$req=mysql_query($sql,$base) or die ('ERREUR SQL!<br />'.$sql.'<br />'.mysql_error());
$donnees = mysql_fetch_assoc($req);

?>
<body>
		
<form name="Edition" action="modifier3.php" method="POST">
<input type="hidden" name="Index" id="Index" value="<?php echo $Index; ?>"/><br />

<label for="Nom">Nom: </label> <input type="text" name="Nom" id="Nom" value="<?php echo $donnees['Nom']; ?>"/><br />

<label for="Prenom">Prénom: </label> <input type="text" name="Prenom" id="Prenom" value="<?php echo $donnees['Prenom']; ?>"/><br /> 

<?php
$fonction = $donnees['Fonction'];
switch ($fonction) {
	case "ETUDIANT":
		$valeur = 1;
		break;
	case "MEMBRE":
		$valeur = 2;
		break;
	case "EXTERNE":
		$valeur = 3;
		break;
	case "STAGE":
		$valeur = 4;
		break;
	case "INVITE":
		$valeur = 5;
		break;
	case "SPARE1":
		$valeur = 6;
		break;
	case "SPARE2":
		$valeur = 7;
		break;
}
?>
<label for="Fonction" >Fonction: </label> <SELECT name="Fonction" id="Fonction" >
	<OPTION VALUE=1 <?php if ($valeur == 1) { echo "selected"; } ?>  > ETUDIANT </option>
	<OPTION VALUE=2 <?php if ($valeur == 2) { echo "selected"; } ?>  > MEMBRE </option>
	<OPTION VALUE=3 <?php if ($valeur == 3) { echo "selected"; } ?>  > EXTERNE </option>
	<OPTION VALUE=4 <?php if ($valeur == 4) { echo "selected"; } ?>  > STAGE </option>
	<OPTION VALUE=5 <?php if ($valeur == 5) { echo "selected"; } ?>  > INVITE </option>
	<OPTION VALUE=6 <?php if ($valeur == 6) { echo "selected"; } ?>  > SPARE1 </option>
	<OPTION VALUE=7 <?php if ($valeur == 7) { echo "selected"; } ?>  > SPARE2 </option>
</SELECT><br />


<label for="ID">ID: </label> <input type="text" name="ID" id="ID" value="<?php echo $donnees['ID']; ?>"/><br />


<?php
$statut= $donnees['Statut'];
switch ($statut) {
	case "Actif":
		$valeurstat = 1;
		break;
	case "Inactif":
		$valeurstat = 2;
		break;
}
?>
<label for="Statut">Statut: </label> <SELECT name="Statut" id="Statut" > 
	<OPTION VALUE=1 <?php if ($valeurstat == 1) { echo "selected"; } ?>  > Actif </option>
	<OPTION VALUE=2 <?php if ($valeurstat == 2) { echo "selected"; } ?>  > Inactif
	
</SELECT><br />

<label for="Portes">Portes (UA2,UA5,UB3,L): </label> <input type="text" name="Portes" id="Portes" value="<?php echo $donnees['Portes']; ?>"><br />	

<label for="Date_Fin_Validite">Date Fin Validité (YYYY-MM-DD): </label> <input type="text" name="Date_Fin_Validite" id="Date_Fin_Validite" value="<?php echo $donnees['Date_Fin_Validite']; ?>"/><br />

<label for="Commentaires">Commentaires: </label> <input type="text" name="Commentaires" id="Commentaires" value="<?php echo $donnees['Commentaires']; ?>"/><br /> <br />
<?php
// Libération de l'espace alloué pour l'interrogation de la base
	mysql_free_result($req);
	mysql_close ();
?>

<input type="submit" value="EDITER"/>

</form>
</body>


