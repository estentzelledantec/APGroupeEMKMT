<?php
/**
 * SCRIPT DE TRAITEMENT DES PRÉSENCES
 * Ce fichier reçoit les données de Animations.php et met à jour la base de données.
 */

session_start();

// =========================================================================
// 1. CONTRÔLE D'ACCÈS ET DÉPENDANCES
// =========================================================================

// Vérification du rôle : Seule la Vie Scolaire (ID 3) peut modifier les présences
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header('Location: ../../front-end/form-connexion.php');
    exit();
}

// Inclusion de l'outil Libsodium pour le chiffrement RGPD
require_once('outil_chiffrement.php');

// Connexion à la base de données avec l'utilisateur dédié
try {
    $bdd = new PDO('mysql:host=localhost;dbname=animationsfld;charset=utf8', 'viescolaire', 'Btssio2017');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// =========================================================================
// 2. RÉCUPÉRATION ET CHIFFREMENT DES DONNÉES
// =========================================================================

// On vérifie que les paramètres nécessaires sont présents dans l'URL (via la méthode GET)
if (isset($_GET['id_ani']) && isset($_GET['id_ins']) && isset($_GET['action'])) {
    
    // Sécurisation des entrées numériques
    $id_animation = (int)$_GET['id_ani'];
    $id_inscrit   = (int)$_GET['id_ins'];
    $etat_brut    = $_GET['action']; // Reçoit '0' (absent) ou '1' (présent)

    /**
     * CHIFFREMENT DE LA DONNÉE :
     * Avant d'enregistrer, on transforme le '0' ou le '1' en une chaîne 
     * illisible (Base64) pour protéger la vie privée des élèves.
     */
    $presence_chiffree = chiffrer_donnee($etat_brut); 

    // =========================================================================
    // 3. MISE À JOUR DE LA BASE DE DONNÉES (SQL)
    // =========================================================================

    // Préparation de la requête pour éviter les injections SQL
    $requete = $bdd->prepare("
        UPDATE inscription 
        SET presence = :pres 
        WHERE id_inscrit = :ins AND id_animation = :ani
    ");
    
    // Exécution de la mise à jour sur la table 'inscription'
    $requete->execute(array(
        'pres' => $presence_chiffree,
        'ins'  => $id_inscrit,
        'ani'  => $id_animation
    ));

    // =========================================================================
    // 4. FINALISATION
    // =========================================================================

    // Redirection automatique vers la liste des animations pour voir le changement
    header('Location: ../front-end/Animations.php');
    exit();

} else {
    // Message d'erreur si le script est appelé sans les bons paramètres
    die("Erreur : Impossible de traiter la demande (données manquantes).");
}
?>