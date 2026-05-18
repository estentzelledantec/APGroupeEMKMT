<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Accès interdit");
}

$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$titre = trim($_POST['titre']);
$commentaire = trim($_POST['commentaire']);
$materiel = trim($_POST['materiel']);

$min = (int) $_POST['min'];
$max = (int) $_POST['max'];

$dateDeb = str_replace('T', ' ', $_POST['dateDeb']) . ":00";
$dateFin = str_replace('T', ' ', $_POST['dateFin']) . ":00";

$idAnimateur = (int) $_POST['idAnimateur'];
$idLieu = (int) $_POST['idLieu'];

$idTheme = null;

/* 🔥 gestion thème */
if (!empty($_POST['newTheme'])) {
    $stmt = $pdo->prepare("INSERT INTO theme (libelle) VALUES (?)");
    $stmt->execute([trim($_POST['newTheme'])]);
    $idTheme = $pdo->lastInsertId();
} else {
    $idTheme = (int) $_POST['idTheme'];
}

/* insertion animation */
$sql = "INSERT INTO animation
(Titre, DateHeureDeb, DateHeureFin, nbreMin, nbreMax, materiel, commentaire, idTheme, idAnimateur, idLieu)
VALUES
(:titre, :deb, :fin, :min, :max, :materiel, :commentaire, :theme, :anim, :lieu)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':titre' => $titre,
    ':deb' => $dateDeb,
    ':fin' => $dateFin,
    ':min' => $min,
    ':max' => $max,
    ':materiel' => $materiel,
    ':commentaire' => $commentaire,
    ':theme' => $idTheme,
    ':anim' => $idAnimateur,
    ':lieu' => $idLieu
]);

header("Location: ../accueil.php");
exit();