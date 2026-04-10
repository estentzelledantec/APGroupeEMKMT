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
//test2565656156
// ========================================================================
// 2. RÉCUPÉRATION ET SÉCURISATION DES DONNÉES 
// ========================================================================
$id_eleve = $_SESSION['id_user'] ?? $_SESSION['id'] ?? 1; 

// On filtre strictement l'ID de l'animation avec FILTER_VALIDATE_INT
$id_animation = filter_input(INPUT_GET, 'id_anim', FILTER_VALIDATE_INT);

// Sécurisation de l'action demandée avec htmlspecialchars
$action_brute = isset($_GET['action']) ? $_GET['action'] : '';
$action = htmlspecialchars($action_brute, ENT_QUOTES, 'UTF-8');

// On s'assure que les IDs sont valides avant de faire quoi que ce soit
if ($id_eleve > 0 && $id_animation > 0) {

    // ========================================================================
    // 3A. ACTION : S'INSCRIRE À UNE ANIMATION
    // ========================================================================
    if ($action === 'inscrire') {
        
        // --- ÉTAPE A : CHIFFREMENT EN ARRIÈRE-PLAN ---
        $req_eleve = $bdd->prepare("SELECT nom, prenom, classe FROM inscrit WHERE ID = :id");
        $req_eleve->bindValue(':id', $id_eleve, PDO::PARAM_INT);
        $req_eleve->execute();
        $eleve = $req_eleve->fetch(PDO::FETCH_ASSOC);

        // Si l'élève existe et que son nom n'est pas encore chiffré (< 30 caractères)
        if ($eleve && strlen($eleve['nom']) < 30) {
            
            // On utilise notre boîte à outils pour chiffrer les textes
            $nom_chiffre = chiffrer_donnee($eleve['nom']);
            $prenom_chiffre = chiffrer_donnee($eleve['prenom']);
            $classe_chiffree = !empty($eleve['classe']) ? chiffrer_donnee($eleve['classe']) : NULL;

            // On met à jour la base de données de manière sécurisée
            $update = $bdd->prepare("UPDATE inscrit SET nom = :nom, prenom = :prenom, classe = :classe WHERE ID = :id");
            $update->bindValue(':nom', $nom_chiffre, PDO::PARAM_STR);
            $update->bindValue(':prenom', $prenom_chiffre, PDO::PARAM_STR);
            $update->bindValue(':classe', $classe_chiffree, $classe_chiffree ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $update->bindValue(':id', $id_eleve, PDO::PARAM_INT);
            $update->execute();
        }

        // --- ÉTAPE B : INSCRIPTION DE L'ÉLÈVE ---
        // On vérifie d'abord qu'il n'est pas déjà inscrit pour éviter les doublons
        $verif = $bdd->prepare("SELECT COUNT(*) FROM inscription WHERE id_inscrit = :id_eleve AND id_animation = :id_anim");
        $verif->bindValue(':id_eleve', $id_eleve, PDO::PARAM_INT);
        $verif->bindValue(':id_anim', $id_animation, PDO::PARAM_INT);
        $verif->execute();
        
        if ($verif->fetchColumn() == 0) {
            $insert = $bdd->prepare("INSERT INTO inscription (id_inscrit, id_animation, presence) VALUES (:id_eleve, :id_anim, 0)");
            $insert->bindValue(':id_eleve', $id_eleve, PDO::PARAM_INT);
            $insert->bindValue(':id_anim', $id_animation, PDO::PARAM_INT);
            $insert->execute();
        }
        
        // Fin de l'opération, on renvoie vers l'accueil
        header("Location: ../front-end/accueil.php");
        exit();
    }

    // ========================================================================
    // 3B. ACTION : SE DÉSINSCRIRE
    // ========================================================================
    if ($action === 'desinscrire') {
        
        // On vérifie la règle des 7 jours côté serveur
        // pour empêcher un élève de forcer la désinscription via l'URL
        $req_anim = $bdd->prepare("SELECT DateHeureDeb FROM animation WHERE ID = :id_anim");
        $req_anim->bindValue(':id_anim', $id_animation, PDO::PARAM_INT);
        $req_anim->execute();
        $animation = $req_anim->fetch(PDO::FETCH_ASSOC);

        if ($animation) {
            $temps_actuel = time();
            $temps_animation = strtotime($animation['DateHeureDeb']);
            $temps_limite = strtotime('-7 days', $temps_animation);

            // Si on est bien avant la date limite, on autorise la suppression
            if ($temps_actuel <= $temps_limite) {
                $delete = $bdd->prepare("DELETE FROM inscription WHERE id_inscrit = :id_eleve AND id_animation = :id_anim");
                $delete->bindValue(':id_eleve', $id_eleve, PDO::PARAM_INT);
                $delete->bindValue(':id_anim', $id_animation, PDO::PARAM_INT);
                $delete->execute();
            }
        }
        
        // Fin de l'opération, on renvoie vers la page "Mes Inscriptions"
        header("Location: ../front-end/inscriptions.php");
        exit();
    }
}

// ========================================================================
// 4. REDIRECTION POUR LA SECURITE
// ========================================================================
// Si le script arrive ici (mauvaise action, ID manquant, etc.), on éjecte l'utilisateur
header("Location: ../front-end/accueil.php");
exit();
?>