<?php
$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "administrateur", "Btssio2017");
require_once __DIR__ . '/crypto.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Erreur : aucun ID fourni.");
}

$user = null;
$table = null;

/* Recherche dans animateur */
$stmt = $pdo->prepare("SELECT *, 'animateur' AS table_name FROM animateur WHERE ID = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    /* Recherche dans inscrit */
    $stmt = $pdo->prepare("SELECT *, 'inscrit' AS table_name FROM inscrit WHERE ID = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
}

if (!$user) {
    /* Recherche dans administration */
    $stmt = $pdo->prepare("SELECT *, 'administration' AS table_name FROM administration WHERE ID = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

}

if (!$user) {
    die("Erreur : utilisateur introuvable.");
}

$table = $user['table_name'];
$user['tel']  = decryptData($user['tel']);
$user['emel'] = decryptData($user['emel']);
?>
