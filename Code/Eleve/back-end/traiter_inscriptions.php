<?php
// ========================================================================
// 1. INITIALISATION ET SÉCURITÉ DE LA CONNEXION
// ========================================================================
session_start();
require_once 'OutilsChiffrement.php';

try {
    $bdd = new PDO('mysql:host=localhost;dbname=animationsfld;charset=utf8', 'root', '');
    
    // Sécurité anti-injection 
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion à la base de données.");
}

// ========================================================================
// 2. RÉCUPÉRATION ET SÉCURISATION DES DONNÉES 
// ========================================================================
// On récupère l'ID réel de l'élève connecté
$id_eleve = $_SESSION['user_id'] ?? null;

// On filtre strictement l'ID de l'animation avec FILTER_VALIDATE_INT
$id_animation = filter_input(INPUT_GET, 'id_anim', FILTER_VALIDATE_INT);

// Sécurisation de l'action demandée avec htmlspecialchars
$action_brute = isset($_GET['action']) ? $_GET['action'] : '';
$action = htmlspecialchars($action_brute, ENT_QUOTES, 'UTF-8');

// On s'assure que les IDs sont valides avant de faire quoi que ce soit
if ($id_eleve > 0 && $id_animation > 0) {

    // ========================================================================
    // 3. APPEL DU FICHIER SQL DÉPORTÉ (Remplace les parties 3A et 3B)
    // ========================================================================
    include '..\..\back-end\code_sql/code_sql_Eleve.php';

    // ========================================================================
    // 4. REDIRECTIONS SELON L'ACTION
    // ========================================================================
    if ($action === 'inscrire') {
        header("Location: ../front-end/accueil.php");
        exit();
    }

    if ($action === 'desinscrire') {
        header("Location: ../front-end/inscriptions.php");
        exit();
    }
}

// ========================================================================
// 5. REDIRECTION POUR LA SECURITE
// ========================================================================
header("Location: ../front-end/accueil.php");
exit();
?>