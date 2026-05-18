<?php
$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "administrateur", "Btssio2017");

/*Suppression du compte*/
$sup = $pdo->prepare("DELETE FROM inscrit WHERE STATUT=1");
$sup->execute();

	header("Location: ../accueil.php");
	exit;
	
echo "Élève supprimé avec succès!";
?>