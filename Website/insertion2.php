<html>
<head>
<title>Ajout d'une nouvelle personne :partie 2</title>
<meta charset="utf-8"/>
<head>

<?php
// Connection à la base de données
$base = mysql_connect ('xxx.xxx.xxx.xxx','yyy','zzz') or die ('ERREUR'.mysql_error());
mysql_select_db ('elevage',$base) or die ('ERREUR'.mysql_error());

// récupération de la valeur des champs
	$Nom =$_POST['Nom'];
	$Prenom =$_POST['Prenom'];	
	$Fonction =$_POST['Fonction'];	
	$ID =$_POST['ID'];	
	$Statut =$_POST['Statut'];	
	$Portes =$_POST['Portes'];
	$Date_de_creation=date("Y-m-d H:i:s");	
	$Date_Fin_Validite =$_POST['Date_Fin_Validite'];	
	$Commentaires =$_POST['Commentaires'];

// requete pour l'ajout dans la base de données
$sql = "INSERT INTO Entrees_Sorties (Nom,Prenom,Fonction,ID,Statut,Portes,Date_de_creation,Date_Fin_Validite,Commentaires)
	VALUES ('$Nom','$Prenom','$Fonction','$ID','$Statut','$Portes','$Date_de_creation','$Date_Fin_Validite','$Commentaires')";

// requete pour vérifier que l'id n'est pas déjà utilisé
$sql2 = "SELECT * FROM elevage.Entrees_Sorties WHERE Entrees_Sorties.ID='$ID'";
$test = mysql_query($sql2,$base) or die ('ERREUR SQL!<br />'.$sql2.'<br />'.mysql_error());

if(isset($Nom) and $Nom!='' and isset($Prenom) and $Prenom!='' and isset($ID) and $ID!='' and mysql_num_rows($test)==0)
{
    //exécution de la requête
    $req=mysql_query($sql,$base) or die ('ERREUR SQL!<br />'.$sql.'<br />'.mysql_error());
}
else 
{
    echo "Vous devez obligatoirement spécifier Nom,Prenom et ID, si vous l'avez fait l'ID est peu être déjà utilisé <br />";
    echo "Cliquez sur le bouton ci-dessous pour recommencer <br />";
    echo "<form action='ajout.php' name='Revenir' method='POST'>";
	echo "<input type='submit' value='Revenir'></form>";
}
if($req)
{
	echo "Cette personne : $Nom $Prenom à été ajoutée";
    echo "<form action='index.php' name='Accueil' method='POST'>";
    echo "<input type='submit' value='Accueil'></form>";
}
else
{
	echo "Echec de l'insertion";
}
?>
</html>
