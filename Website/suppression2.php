<html>
<head>
<meta charset="utf-8"/>
</head>

<body>

<?php
//Connection à la base de données
$base = mysql_connect ('xxx.xxx.xxx.xxx','yyy','zzz') or die ('ERREUR'.mysql_error());
mysql_select_db ('elevage',$base) or die ('ERREUR'.mysql_error());


if(isset($_POST['supp']))
{
	// je regarde toute les checkbox cochées et je supprime les lignes correspondantes
	foreach($_POST['supp'] as $supp)
    {
        // Requete SQL
        $sql1= 'SELECT Nom,Prenom FROM elevage.Entrees_Sorties WHERE Entrees_Sorties.index='.$supp;
        $req=mysql_query($sql1,$base) or die('Erreur SQL!<br />'.$sql.'<br />'.mysql_error());
        while ($rep = mysql_fetch_array($req)) 
        {
            $Nom=$rep["Nom"];
            $Prenom=$rep["Prenom"];
        
            $sql='DELETE FROM elevage.Entrees_Sorties WHERE Entrees_Sorties.index='.$supp;
		    mysql_query($sql,$base) or die('Erreur SQL!<br />'.$sql.'<br />'.mysql_error());
            if($sql)
            {
                echo "Suppression de $Nom $Prenom effectuée<br/>";
            }
            else
            {
                echo "Problème lors de la suppression!<br/>";
            }
        }
	}
}

else
{
	echo "Sélectionner au moins 1 champ à supprimer";
}

?>

<! --je demande à revenir sur la page d'accueil -->
<form action="index.php" name="Accueil" method="POST"> <input type="submit" value="Accueil"> </form>
</body>

</html>
