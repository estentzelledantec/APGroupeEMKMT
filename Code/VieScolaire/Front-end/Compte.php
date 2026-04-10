<?php
/**
 * PAGE PROFIL - ESPACE VIE SCOLAIRE
 * Affiche les informations personnelles de l'utilisateur connecté.
 */

session_start();

// =========================================================================
// 1. SÉCURITÉ ET CONTRÔLE D'ACCÈS
// =========================================================================
// On vérifie que l'utilisateur est bien authentifié avec le rôle Vie Scolaire (Statut 3).
// Le statut 3 correspond à la Vie Scolaire dans ta table 'statut'.
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    // Redirection si l'utilisateur n'a pas les droits ou n'est pas connecté
    header('Location: form-connexion.php');
    exit(); // Interruption du script pour garantir la protection des données
}

// =========================================================================
// 2. RÉCUPÉRATION DES DONNÉES DE SESSION
// =========================================================================
// Ces informations proviennent généralement de la table 'administration' lors de la connexion.
// Utilisation de l'opérateur de coalescence nulle (??) pour éviter les erreurs si la clé n'existe pas.
$nom    = $_SESSION['nom']    ?? 'Non renseigné';
$prenom = $_SESSION['prenom'] ?? 'Utilisateur';
$email  = $_SESSION['email']  ?? 'Non renseigné';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte - Vie Scolaire</title>
    <link rel="stylesheet" href="../../Asset/css/style_vieScolaire.css">
</head>
<body>

    <header class="header">
        <div class="header-left">Vie Scolaire</div>
        
        <nav class="header-nav">
            <a href="Compte.php" class="active">Mon compte</a>
            <a href="Animations.php">Animations</a>
            <a href="Statistiques.php">Statistique</a>
        </nav>

        <div class="header-right">
            <a href="../back-end/deconnexion.php" class="btn-deconnexion">Déconnecter</a>
        </div>
    </header>

    <main class="main-content">
        <h1>Mon Compte</h1>

        <div class="account-container">
            <div class="account-card">
                <h3>Informations personnelles</h3>
                
                <div class="info-group">
                    <label>Prénom</label>
                    <p><?php echo htmlspecialchars($prenom); ?></p>
                </div>

    
   <div class="navigation-container">
        <a href="../accueil.php" class="btn-retour"> ← retour</a>
    </div>