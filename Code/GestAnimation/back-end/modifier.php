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

$dateInput = $_POST['dateDeb'];
if (empty($dateInput)) {
    die("Date invalide");
}

$date = str_replace('T', ' ', $dateInput) . ':00';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);

    $sql = "UPDATE animation 
            SET Titre = :titre,
                DateHeureDeb = :date,
                commentaire = :commentaire,
                nbreMin = :min,
                nbreMax = :max
            WHERE ID = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':titre', $titre, PDO::PARAM_STR);
    $stmt->bindValue(':date', $date, PDO::PARAM_STR);
    $stmt->bindValue(':commentaire', $commentaire, PDO::PARAM_STR);
    $stmt->bindValue(':min', $min, PDO::PARAM_INT);
    $stmt->bindValue(':max', $max, PDO::PARAM_INT);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $stmt->execute();

    header("Location: ../accueil.php?success=1");
    exit();

} catch (PDOException $e) {
    die("Erreur serveur");
}