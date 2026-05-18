<?php
$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "administrateur", "Btssio2017");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
require_once __DIR__ . '/crypto.php';

$id = $_GET['id'] ?? null;
$table = $_GET['table'] ?? null;



if (!$id || !$table) {
    die("Erreur : aucun ID ou table fourni.");
}

// Sécurité : empêcher l'injection dans le nom de table
$tablesAutorisees = ['inscrit', 'administration', 'animateur'];
if (!in_array($table, $tablesAutorisees)) {
    die("Erreur : table non autorisée.");
}

/* Recherche dans la bonne table */
$stmt = $pdo->prepare("SELECT * FROM $table WHERE ID = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Erreur : utilisateur introuvable.");
}

if (isset($user['tel'])) {
    $user['tel'] = decryptData($user['tel']);
}
if (isset($user['emel'])) {
    $user['emel'] = decryptData($user['emel']);
}
?>
