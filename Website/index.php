<?php
// Connection à la base de données
$base = mysql_connect ('xxx.xxx.xxx.xxx','yyy','zzz') or die ('ERREUR'.mysql_error());
mysql_select_db ('elevage',$base) or die ('ERREUR'.mysql_error());

//d�termination de la localisation du badgeur
$ip=$_SERVER['SERVER_ADDR'];
switch ($ip) {
	case "xxx.xxx.xxx.xxx":
	$door='UA2';
	break;
	case "xxx.xxx.xxx.xxx":
	$door='UA5';
	break;
	case "xxx.xxx.xxx.xxx":
	$door='UA2';
	break;
}
?>

<html>
	<head> <p><img src="beams.png" class="logobeams"/></p>
	<h1 class="titre2"> Bio-Electro and Mechanical System </h1> 
	<! --En-tête de page -->
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="style.css"/>
 
	</head>

	<body>
	<! --corps de la page -->
	<h1 class="titre3"> Gestion des badgeurs de BEAMS</h1>
	<h2 class="titre"> Liste des badges connus </h2> </p>

	

<nav>	<! --Création d'un boutton permettant d'ajouter par exemple dans la base -->
	<form action="ajout.php" name="Ajouter" method="POST">
	<input type="submit" value="Ajouter">
	</form>

	<! --Création d'un boutton permettant de supprimer des personnes dans la base -->
	<form action="suppression.php" name="Supprimer" method="POST">
	<input type="submit" value="Supprimer">
	</form>

	<! -- Création d'un bouton permettant d'éditer un champ -->
	<form action="modifier.php" name="Modifier" method="POST">
	<input type="submit" value="Modifier">
	</form>

	<! --Cr�ation d'un boutton permettant d'aller � la page de log -->
	<form action="pagelog.php" name="Log" method="POST">
	<input type="submit" value="Log">
	</form>
</nav>

	<! -- Je crée un tableau qui va stocker les éléments de ma base de donnée --> 
	<table>
	<tbody>
	<?php
	// requete affichage de la base de données
	$sql='SELECT * FROM elevage.Entrees_Sorties ORDER BY Nom,Prenom';
    $col='DESCRIBE elevage.Entrees_Sorties';
	
	// On lance la requête et on impose un message d'erreur si sa déconne
	$req = mysql_query($sql) or die('Erreur SQL!<br />'.$sql.'<br />'.mysql_error());
	$columns = mysql_query($col) or die('Erreur SQL!<br />'.$sql.'<br />'.mysql_error());

	//Récupération sous forme de tableau
    while ($row = mysql_fetch_assoc($columns)){
    echo '<td>'.$row['Field'].'</td>';
    }
    
	while ($data = mysql_fetch_assoc($req)) {
		echo '<tr>'.'<td>'.$data["Index"].'</td>';
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
	</tbody>
	</table>
	</body>

<footer>
<img src="logoulb.png" class="logoulb">
</footer>

</html>
