<?php
// Connexion à la base
$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "root", "");

// Récupérer les articles par catégorie
$stmt = $pdo->prepare("SELECT ID, libelle FROM statut");
$stmt->execute();
$statut = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>