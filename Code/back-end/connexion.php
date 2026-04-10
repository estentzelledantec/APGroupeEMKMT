<?php
session_start();
require_once 'base.php'; 

// On vérifie que le formulaire a été envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. RÉCUPÉRATION ET NETTOYAGE DES DONNÉES
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    try {
        /* =========================================================
           PARTIE A : RECHERCHE DANS L'ADMINISTRATION (Bureaux)
           =========================================================
        */
        $stmt = $pdo->prepare("SELECT * FROM administration WHERE emel = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['mdphasher'])) {
            // On crée la session
            session_regenerate_id(true); 
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['role_id'] = $user['STATUT'];

            // Redirection selon le bureau (le STATUT)
            if ($user['STATUT'] == 4) {
                header('Location: ../Administrateur/accueil.php');
            } elseif ($user['STATUT'] == 3) {
                header('Location: ../VieScolaire/accueil.php');
            } elseif ($user['STATUT'] == 2) {
                header('Location: ../GestAnimation/accueil.php');
            } else {
                header('Location: ../index.php');
            }
            exit();
        }

        /* =========================================================
           PARTIE B : RECHERCHE CHEZ LES ÉLÈVES (Table Inscrit)
           =========================================================
        */
        $stmt = $pdo->prepare("SELECT * FROM inscrit WHERE emel = :email");
        $stmt->execute(['email' => $email]);
        $eleve = $stmt->fetch();

        if ($eleve && password_verify($password, $eleve['mdphasher'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $eleve['ID'];
            $_SESSION['role_id'] = $eleve['STATUT'];
            
            header('Location: ../Eleve/front-end/accueil.php');
            exit();
        }

        
        /* =========================================================
           PARTIE C : RECHERCHE CHEZ LES INTERVENANTS (Table Animateur)
           =========================================================
        */
        $stmt = $pdo->prepare("SELECT * FROM animateur WHERE emel = :email");
        $stmt->execute(['email' => $email]);
        $anim = $stmt->fetch();

        if ($anim && password_verify($password, $anim['mdphasher'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $anim['ID'];
            $_SESSION['role_id'] = 'intervenant';

            /*
            =========================================================
                TEST SI IL Y A UNE ANIMATION EN COURS
            =========================================================
            */
            /*
            Vive les patates
            */

            $stmt = $pdo->prepare('SELECT * 
                FROM animation 
                WHERE animation.DateHeureDeb < NOW() AND animation.DateHeureFin > NOW()'
            );
            $stmt->execute();
            $animation = $stmt->fetch();

            if ($animation) {
                header('Location: ../Intervenant/appelle.php');
                exit();
            } else {
                header('Location: ../Intervenant/accueil.php');
                exit();
            }
            
        }

        /* =========================================================
           PARTIE D : SI LA CONNEXION ÉCHOUE
           =========================================================
        */
        $_SESSION['error'] = "Email ou mot de passe incorrect.";
        header('Location: ../front-end/form-connexion.php');
        exit();

    } catch (PDOException $e) {
        // En cas de problème avec la base de données
        error_log($e->getMessage());
        $_SESSION['error'] = "Erreur technique de connexion.";
        header('Location: ../front-end/form-connexion.php');
        exit();
    }
}