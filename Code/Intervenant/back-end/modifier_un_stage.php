
<?php
require_once(dirname(__DIR__).'/../back-end/base.php');
$id = $_POST['id'];
$titre = $_POST['titre'];
$commentaire = $_POST['commentaire'];
$dateDeb = $_POST['dateDebut'];
$dateFin = $_POST['dateFin'];
$nbreMin = $_POST['nbreMin'];
$nbreMax = $_POST['nbreMax'];
$materiel = $_POST['materiel'];
$idLieu = $_POST['idLieu'];

$stmt = $pdo->prepare("UPDATE animation 
SET Titre = ?, commentaire = ?, DateHeureDeb = ?, DateHeureFin = ?, nbreMin = ?, nbreMax = ?, materiel = ?, idLieu = ?
WHERE ID = ?");

$succes=$stmt->execute([$titre, $commentaire, $dateDeb, $dateFin, $nbreMin, $nbreMax, $materiel, $idLieu, $id,]);

header("Location: ../accueil.php");
