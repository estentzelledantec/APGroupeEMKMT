<?php
session_start();
//fichier de point d'entree pour les utilisatueurs de la vie scolaire

// 1. CONTRÔLE D'ACCÈS
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    header('Location: front -end/form-connexion.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vie Scolaire - Accueil</title>
<link rel="stylesheet" href="../Asset/css/style_vieScolaire.css">
</head>
<body>

    <header class="header">
        <div class="header-left">
            Vie<br>Scolaire
        </div>
        
        <nav class="header-nav">
            <a href="front-end/Compte.php">Mon<br>compte</a>
            <a href="front-end/Animations.php">Animations</a>
            <a href="front-end/Statistiques.php">Statistique</a>
            <a href="#" class="btn-pdf">Absences PDF</a>
        </nav>

        <div class="header-right">
            <a href="../../back-end/deconnexion.php" class="btn-deconnexion">Déconnecter</a>
        </div>
    </header>

    <main class="main-content">
        <h1>Accueil Vie Scolaire</h1>
        <p class="welcome-text">Bienvenue sur votre espace de la vie scolaire</p>
    </main>
    
    <footer class="footer">
        © 2026 - Lycée | Bureau Vie Scolaire
    </footer>

</body>
</html>