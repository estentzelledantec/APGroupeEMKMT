<?php
session_start();
require_once 'base.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. RÉCUPÉRATION ET NETTOYAGE
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    try {
        // 2. APPEL DU MODÈLE SQL GÉNÉRAL
        include 'code_sql/code_sql_General.php';

        // 3. LOGIQUE DE CONNEXION (DÉCISION)

        // CAS 1 : C'est un Administrateur / Bureau
        if ($user_admin && password_verify($password, $user_admin['mdphasher'])) {
            session_regenerate_id(true); 
            $_SESSION['user_id'] = $user_admin['ID'];
            $_SESSION['role_id'] = $user_admin['STATUT'];

            $redirections = [
                4 => '../Administrateur/accueil.php',
                3 => '../VieScolaire/accueil.php',
                2 => '../GestAnimation/accueil.php'
            ];
            $url = $redirections[$user_admin['STATUT']] ?? '../index.php';
            header("Location: $url");
            exit();
        }

        // CAS 2 : C'est un Élève
        if ($user_eleve && password_verify($password, $user_eleve['mdphasher'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user_eleve['ID'];
            $_SESSION['role_id'] = $user_eleve['STATUT'];
            header('Location: ../Eleve/front-end/accueil.php');
            exit();
        }

        // CAS 3 : C'est un Animateur / Intervenant
        if ($user_anim && password_verify($password, $user_anim['mdphasher'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user_anim['ID'];
            $_SESSION['role_id'] = 'intervenant';

            if ($animation_en_cours) {
                header('Location: ../Intervenant/appelle.php');
            } else {
                header('Location: ../Intervenant/accueil.php');
            }
            exit();
        }

        // CAS 4 : ÉCHEC
        $_SESSION['error'] = "Email ou mot de passe incorrect.";
        header('Location: ../front-end/form-connexion.php');
        exit();

    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION['error'] = "Erreur technique.";
        header('Location: ../front-end/form-connexion.php');
        exit();
    }
}