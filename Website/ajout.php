<! -- Fichier affichant le formulaire √† remplir pour permettre l'ajout d'une personne -->

<html>
<head>
<title> Ajouter une nouvelle personne </title>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
</head>

<body>
	<h2 class="titre"> Ajouter une nouvelle personne </h2> </p>	
<nav>	<! --CrÈation d'un boutton permettant de revenir ‡ la page d'accueil -->
	<form action="index.php" name="Page d'accueil" method="POST">
	<input type="submit" value="Page d'accueil">
	</form>
<nav>

<p> <a href="pagelog.php">Voir le fichier log </a></p>
 
<form name="Ajout" action="insertion2.php" method="POST">
<p>

<label for="Nom">Nom: </label> <input type="text" name="Nom" id="Nom"/><br />

<label for="Prenom">Pr√©nom: </label> <input type="text" name="Prenom" id="Prenom"/><br /> 

<label for="Fonction" >Fonction: </label> <SELECT name="Fonction" id="Fonction">
	<OPTION VALUE=1> ETUDIANT
	<OPTION VALUE=2 selected> MEMBRE
	<OPTION VALUE=3> EXTERNE
	<OPTION VALUE=4> STAGE
	<OPTION VALUE=5> INVITE
	<OPTION VALUE=6> SPARE1
	<OPTION VALUE=7> SPARE2 
</SELECT><br />
<?php
$ID=$_GET['ID'];
if(isset($ID))
{
    echo "<label for='ID'>ID: </label> <input type='text' name='ID' id='ID' value='".$ID."'/><br />";
}
else
{
    echo "<label for='ID'>ID: </label> <input type='text' name='ID' id='ID'/><br />";
}
?>
<label for="Statut">Statut: </label> <SELECT name="Statut" id="Statut"> 
	<OPTION VALUE=1> Actif
	<OPTION VALUE=2> Inactif
	
</SELECT><br />
<label for="Portes">Portes (UA2,UA5,UB3,L): </label> <input type="text" name="Portes" id="Portes"/><br />	

<label for="Date_Fin_Validite">Date Fin Validit√© (YYYY-MM-DD): </label> <input type="text" name="Date_Fin_Validite" id="Date_Fin_Validite"/><br />

<label for="Commentaires">Commentaires: </label> <input type="text" name="Commentaires" id="Commentaires"/><br /> <br />

<input type="submit" value="Ajouter">
</p>
</form>
</body>


