<?php
// Vérifier si un ID est passé
$id = $_GET['id'] ?? null;

if ($id === null) {

    // Pas de statut à charger
    $statut = ['libelle' => 'animateur'];
    $administration = false;

    // Charger les animateurs
    $reqPersonnes = $pdo->query("
        SELECT nom, prenom, emel
        FROM animateur
    ");
    $personnes = $reqPersonnes->fetchAll();

} else {

    // Charger le statut
    $reqStatut = $pdo->prepare("SELECT * FROM statut WHERE id = ?");
    $reqStatut->execute([$id]);
    $statut = $reqStatut->fetch();

    $administration = in_array($statut['libelle'], [
        'gestionnaireAnimation',
        'viescolaire',
        'administration'
    ]);

    // Charger les personnes ayant ce statut
    $reqPersonnes = $pdo->prepare("
        SELECT nom, prenom, emel 
        FROM inscrit
        WHERE STATUT = ?

        UNION

        SELECT '' AS nom, '' AS prenom, emel
        FROM administration
        WHERE STATUT = ?
    ");

    $reqPersonnes->execute([$id, $id]);
    $personnes = $reqPersonnes->fetchAll();
}


try {
    $query = $pdo->query("SELECT * FROM statut");
    $stat = $query->fetchAll();
} catch (PDOException $e) {
    $stat = [];
}
?>