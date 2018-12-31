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
	<title> Editer les badges </title>
	</head>
<body>

	<! --corps de la page -->
	<h2 class="titre"> Editer les badges </h2>	
	</p>
<nav>	<! --Cr�ation d'un boutton permettant de revenir � la page d'accueil -->
	<form action="index.php" name="Page d'accueil" method="POST">
	<input type="submit" value="Page d'accueil">
	</form>
<nav>



	<! -- Je reprend le tableau qui stocke les éléments de ma base de donnée --> 
	<table>
	<tbody>
<?php
	// requete affichage de la base de données
	$sql='SELECT * FROM elevage.Entrees_Sorties ORDER BY Nom,Prenom';
	$col='DESCRIBE elevage.Entrees_Sorties';

	// On lance la requête et on impose un message d'erreur si sa déconne
	$req=mysql_query($sql) or die('Erreur SQL!<br />'.$sql.'<br />'.mysql_error());
	$columns = mysql_query($col) or die('Erreur SQL!<br />'.$sql.'<br />'.mysql_error());

	
// Je demande à l'utilisateur de cliquer sur le prénom de la personne à modifier
echo "Cliquer sur le nom de la personne dont vous voulez modifier les données <br>";

	//Récupération sous forme de tableau
	while ($row = mysql_fetch_assoc($columns)){
    		echo '<td>'.$row['Field'].'</td>';
    	}
	while ($data = mysql_fetch_assoc($req)) {
		echo '<tr>';
		echo '<td>'.$data["Index"].'</td>';
		echo '<td>'."<a href='modifier2.php?Index=".$data["Index"]."'>".$data["Nom"]."</a></td>";
		echo '<td>'.$data["Prenom"].'</td>';
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
	<tbody>
	</table>
	</body>
</html>

