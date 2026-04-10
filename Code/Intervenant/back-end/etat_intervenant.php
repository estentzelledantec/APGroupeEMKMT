<?php
require_once(dirname(__DIR__).'/../back-end/connexion.php');

$requete = $pdo->prepare(' 
    SELECT ID,Titre,commentaire,DateHeureDeb,DateHeureFin 
    from animation
    WHERE idAnimateur = ?
    order by DateHeureDeb');
$requete->execute([$_SESSION['user_id']]);
$lignes = $requete->fetchAll(PDO::FETCH_ASSOC);