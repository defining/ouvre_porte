<meta charset="utf-8"/>
<?php
//Connection à la base de données
$base = mysql_connect ('xxx.xxx.xxx.xxx','yyy','zzz') or die ('ERREUR'.mysql_error());
mysql_select_db ('elevage',$base) or die ('ERREUR'.mysql_error());

$Nom=$_POST['Nom'];
$Prenom=$_POST['Prenom'];
$Fonction=$_POST['Fonction'];
$ID=$_POST['ID'];
$Statut=$_POST['Statut'];
$Portes=$_POST['Portes'];
$Date_Fin_Validite=$_POST['Date_Fin_Validite'];
$Commentaires=$_POST['Commentaires'];
$Index=$_POST['Index'];
$Index2=intval($Index);

//requete
$sql = "UPDATE Entrees_Sorties 
	SET Nom='$Nom',
	Prenom='$Prenom',
	Fonction='$Fonction',
	ID='$ID', 
	Statut='$Statut', 
	Portes='$Portes ', 
	Date_Fin_Validite='$Date_Fin_Validite', 
	Commentaires='$Commentaires'

	WHERE Entrees_Sorties.Index=".$Index2;

if(isset($Nom) and $Nom!='' and isset($Prenom) and $Prenom!='' and isset($ID) and $ID!='')
{
    //exécution de la requête
    $req=mysql_query($sql,$base) or die ('ERREUR SQL!<br />'.$sql.'<br />'.mysql_error());
}
else
{
    echo "Vous devez obligatoirement spécifier Nom,Prenom et ID <br />";
    echo "Cliquez sur le bouton ci-dessous pour recommencer <br />";
    echo "<form action='modifier.php' name='Revenir' method='POST'>";
	echo "<input type='submit' value='Revenir'></form>";
}
if($req)
{
	echo "Cette personne : $Nom $Prenom à été modifiée";
    echo "<form name='Editer' action='index.php' method='POST'>";
    echo "<input type='submit' value='Accueil'/></form>";
}
else
{
	echo ("Echec de la modification");
}

// Libération de l'espace alloué pour l'interrogation de la base
	mysql_free_result($req);
	mysql_close ();

?>
</html>
