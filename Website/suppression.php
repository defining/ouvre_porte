<?php
// Connection à la base de données
$base = mysql_connect ('xxx.xxx.xxx.xxx','yyy','zzz') or die ('ERREUR'.mysql_error());
mysql_select_db ('elevage',$base) or die ('ERREUR'.mysql_error());
?>

<html>
	<head>
	<! --En-tête de page -->
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="style.css"/>
	<title> Supprimer des entrées </title>
	</head>
<body>
	<h2 class="titre"> Supprimer les badges </h2>	
	</p>
<nav>	<! --Cr�ation d'un boutton permettant de revenir � la page d'accueil -->
	<form action="index.php" name="Page d'accueil" method="POST">
	<input type="submit" value="Page d'accueil">
	</form>
<nav>

	<! --corps de la page -->
	<p> Sélectionner les entrées à supprimer </p>
	<input type="submit" value="supprimer"></form>

	<! -- Je reprend le tableau qui stocke les éléments de ma base de donnée et je rajoute une checkbox--> 
	<table>

<?php
	// requete affichage de la base de données
	$sql='SELECT * FROM elevage.Entrees_Sorties ORDER BY Nom,Prenom';
	
	// On lance la requête et on impose un message d'erreur si sa déconne
	$req=mysql_query($sql) or die('Erreur SQL!<br />'.$sql.'<br />'.mysql_error());
	
	//Récupération sous forme de tableau
    echo "<form action=\"suppression2.php\" name=\"supprimer\" method=\"POST\">";
	while ($data = mysql_fetch_assoc($req)) {
		echo '<tr>';
		echo "<td><input type='checkbox' name='supp[]' value='".$data['Index']."'/></td>";
		echo '<td>'.$data["Index"].'</td>';
		echo '<td>'.$data["Nom"].'</td>';
		echo '<td>'.$data["Prenom"] .'</td>';
		echo '<td>'.$data["Fonction"] .'</td>';
		echo '<td>'.$data["ID"].'</td>';
		echo '<td>'.$data["Statut"].'</td>';
		echo '<td>'.$data["Portes"].'</td>';
		echo '<td>'.date('d-m-Y H:i:s',strtotime($data["Date_de_creation"])).'</td>';
		echo '<td>'.$data["Date_Fin_Validite"].'</td>';
		echo '<td>'.$data["Commentaires"].'</td>'.'</tr>';
	}

	// Libération de l'espace alloué pour l'interrogation de la base
	mysql_free_result($req);
	mysql_close ();
	?>
	</table>
    	</p>
	<input type="submit" value="supprimer"></form>
	</body>
</html>

