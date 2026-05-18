<?php
require_once __DIR__ . '/crypto.php';

if (!isset($_FILES['fichier']) || $_FILES['fichier']['error'] !== 0) {
    die("Aucun fichier envoyé");
}

$fichier = $_FILES['fichier']['tmp_name'];

// Vérifier l’extension
$extension = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
if ($extension !== 'csv') {
    die("Le fichier doit être un CSV");
}

// Connexion BDD
$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "administrateur", "Btssio2017");

// Ouvrir le fichier
$handle = fopen($fichier, "r");

if (!$handle) {
    die("Impossible de lire le fichier");
}

// Lire la première ligne (en-têtes)
$header = fgetcsv($handle, 1000, ";");

// Lire chaque ligne
while (($data = fgetcsv($handle, 1000, ";")) !== false) {

    // Ordre Pronote :
    // 0 = prénom
    // 1 = nom
    // 2 = email
    // 3 = téléphone
    // 4 = classe

    $prenom = $data[0];
    $nom = $data[1];
    $email = $data[2];
    $tel = $data[3];
    $classe = $data[4];
	$email_chiffre = encryptData($email);
    $tel_chiffre = encryptData($tel);

    // Valeurs automatiques
    $statut = 1;
    $mdp = password_hash("123456", PASSWORD_DEFAULT);

    // Insertion
    $sql = "INSERT INTO inscrit (nom, prenom, tel, emel, STATUT, classe, mdphasher)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $prenom, $tel_chiffre, $email_chiffre, $statut, $classe, $mdp]);
}

fclose($handle);

header("Location: ../accueil.php");
exit;
