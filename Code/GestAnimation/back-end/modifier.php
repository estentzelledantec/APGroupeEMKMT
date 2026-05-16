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
$commentaire = trim($_POST['commentaire']);
$materiel = trim($_POST['materiel']);

$min = (int) $_POST['min'];
$max = (int) $_POST['max'];

$dateDeb = str_replace('T', ' ', $_POST['dateDeb']) . ':00';
$dateFin = str_replace('T', ' ', $_POST['dateFin']) . ':00';

$idAnimateur = (int) $_POST['idAnimateur'];
$idLieu = (int) $_POST['idLieu'];

$newTheme = trim($_POST['newTheme']);

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

    if ($newTheme !== "") {

        $stmtTheme = $pdo->prepare(
            "INSERT INTO theme (libelle) VALUES (?)"
        );

        $stmtTheme->execute([$newTheme]);

        $idTheme = $pdo->lastInsertId();

    } else {

        $idTheme = (int) $_POST['idTheme'];

    }

    $sql = "UPDATE animation
            SET
                Titre = :titre,
                DateHeureDeb = :dateDeb,
                DateHeureFin = :dateFin,
                commentaire = :commentaire,
                materiel = :materiel,
                nbreMin = :min,
                nbreMax = :max,
                idTheme = :theme,
                idAnimateur = :animateur,
                idLieu = :lieu
            WHERE ID = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':titre' => $titre,
        ':dateDeb' => $dateDeb,
        ':dateFin' => $dateFin,
        ':commentaire' => $commentaire,
        ':materiel' => $materiel,
        ':min' => $min,
        ':max' => $max,
        ':theme' => $idTheme,
        ':animateur' => $idAnimateur,
        ':lieu' => $idLieu,
        ':id' => $id
    ]);

    header("Location: ../accueil.php?success=1");
    exit();

} catch (PDOException $e) {

    die("Erreur serveur");

}
?>