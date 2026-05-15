<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Accès interdit");
}

if (!isset($_POST['id']) || !filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
    die("ID invalide");
}

$id = (int) $_POST['id'];

$titre = trim($_POST['titre']);
if (empty($titre)) {
    die("Titre invalide");
}

$commentaire = trim($_POST['commentaire']);

if (!filter_var($_POST['min'], FILTER_VALIDATE_INT)) {
    die("Min invalide");
}

if (!filter_var($_POST['max'], FILTER_VALIDATE_INT)) {
    die("Max invalide");
}

$min = (int) $_POST['min'];
$max = (int) $_POST['max'];

if ($min > $max) {
    die("Min ne peut pas être supérieur au max");
}

$dateDebInput = $_POST['dateDeb'] ?? null;
$dateFinInput = $_POST['dateFin'] ?? null;

if (empty($dateDebInput) || empty($dateFinInput)) {
    die("Dates invalides");
}

$dateDeb = str_replace('T', ' ', $dateDebInput) . ':00';
$dateFin = str_replace('T', ' ', $dateFinInput) . ':00';

if (strtotime($dateFin) <= strtotime($dateDeb)) {
    die("La date de fin doit être après la date de début");
}

$materiel = trim($_POST['materiel']);
if (empty($materiel)) {
    die("Matériel invalide");
}

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=animationsfld;charset=utf8",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

    $sql = "UPDATE animation 
            SET Titre = :titre,
                DateHeureDeb = :dateDeb,
                DateHeureFin = :dateFin,
                commentaire = :commentaire,
                nbreMin = :min,
                nbreMax = :max,
                materiel = :materiel
            WHERE ID = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':titre', $titre, PDO::PARAM_STR);
    $stmt->bindValue(':dateDeb', $dateDeb, PDO::PARAM_STR);
    $stmt->bindValue(':dateFin', $dateFin, PDO::PARAM_STR);
    $stmt->bindValue(':commentaire', $commentaire, PDO::PARAM_STR);
    $stmt->bindValue(':min', $min, PDO::PARAM_INT);
    $stmt->bindValue(':max', $max, PDO::PARAM_INT);
    $stmt->bindValue(':materiel', $materiel, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $stmt->execute();

    header("Location: ../accueil.php?success=1");
    exit();

} catch (PDOException $e) {
    die("Erreur serveur");
}