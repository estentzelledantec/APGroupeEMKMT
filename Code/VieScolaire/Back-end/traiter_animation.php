<?php
/**
 * SCRIPT DE TRAITEMENT DES PRÉSENCES (SANS CHIFFREMENT)
 */

session_start();

// Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=animationsfld;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

if (isset($_GET['id_ani']) && isset($_GET['id_ins']) && isset($_GET['action'])) {
    
    $id_animation = (int)$_GET['id_ani'];
    $id_inscrit   = (int)$_GET['id_ins'];
    $etat_brut    = $_GET['action']; // '0' ou '1'[cite: 1]

    // Mise à jour directe de la table inscription[cite: 1]
    $requete = $bdd->prepare("
        UPDATE inscription 
        SET presence = :pres 
        WHERE id_inscrit = :ins AND id_animation = :ani
    ");
    
    $requete->execute(array(
        'pres' => $etat_brut, // On enregistre en clair[cite: 1]
        'ins'  => $id_inscrit,
        'ani'  => $id_animation
    ));

    // Retour à la page précédente
    header('Location: ../front-end/Animations.php');
    exit();

} else {
    die("Données manquantes.");
}
?>