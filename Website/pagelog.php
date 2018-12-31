<html>
<head>
<title> Page de log</title>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<h2 class="titre"> Journal des 50 derniers événements </h2> </p>
<nav>	<! --Cr�ation d'un boutton permettant de revenir � la page d'accueil -->
	<form action="index.php" name="Page d'accueil" method="POST">
	<input type="submit" value="Page d'accueil">
	</form>
<nav>
<head>
</html>
<table>
<tbody>
<?php
$fichier = fopen('log.txt','r');
echo '<td>'."ID".'</td>';
echo '<td>'."Date et heure".'</td>';
echo '<td>'."Lieu".'</td>';
echo '<td>'."Nom et prénom".'</td>';
echo '<td>'."Fonction".'</td>';
echo '<td>'."Permission(s)".'</td>';
echo '<td>'."Accès".'</td>';

$line = 0;
while (($buffer = fgets($fichier)) !== FALSE)
{
    if ($line == 50) {
       // This is the 51nth line.
       break;
    }   
    $line++;

    $a = explode("\t",$buffer);
    //print_r($a);
    //echo "<a href='ajout.php?ID=".$a[0]."'>$a[0]</a> ".$a[1].$a[2].$a[3].$a[4].$a[5].$a[6];
    if ($a[3]== "Inconnu") {
    	echo '<tr>'.'<td>'."<a href='ajout.php?ID=".$a[0]."'>$a[0]</a>".'</td>';
	}
    else {
	echo '<tr>'.'<td>'.$a[0].'</td>';
	}
    echo '<td>'.$a[1].'</td>';
    echo '<td>'.$a[2].'</td>';
    if ($a[3]== "Inconnu") {
	echo '<td>'.$a[3].'</td>';
	}
    else {
    	echo '<td>'.$a[3].", ".$a[4].'</td>';
	}
    echo '<td>'.$a[5].'</td>';
    echo '<td>'.$a[6].'</td>';
    echo '<td>'.$a[7].'</td>'.'</tr>';
    //echo '<br />';
}
?>
</tbody>
</table>
