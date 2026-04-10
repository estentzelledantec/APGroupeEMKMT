<?php
require_once(dirname(__DIR__).'/../back-end/connexion.php');

$stmt = $pdo->prepare('
    SELECT inscrit.ID, nom, prenom, classe, presence, 
        animation.ID AS animation_id,  
        animation.Titre
    FROM inscrit, inscription, animation 
    WHERE inscrit.id = inscription.id_inscrit 
    AND animation.id = inscription.id_animation
    AND animation.DateHeureDeb < NOW() AND animation.DateHeureFin > NOW()
    AND idAnimateur = ?');
$stmt->execute([$_SESSION['user_id']]);
$eleves = $stmt->fetchAll(PDO::FETCH_ASSOC);

$animation_id = null; // nouvelle ligne. En assignant une valeur même s'il n'y a pas d'élèves (donc pas d'animation) on va pouvoir distinguer les 2 cas
$titre = null;
if (isset($eleves) && count($eleves) > 0) {
    $animation_id = $eleves[0]['animation_id'];
    $titre = $eleves[0]['Titre'];     
};