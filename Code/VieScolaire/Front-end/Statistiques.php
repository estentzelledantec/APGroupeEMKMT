<?php
/**
 * PAGE STATISTIQUES - ESPACE VIE SCOLAIRE
 * Permet de visualiser le taux de présence par animation ou par catégorie d'utilisateur.
 */

session_start();

// =========================================================================
// 1. CONTRÔLE D'ACCÈS ET SÉCURITÉ
// =========================================================================
// Vérification stricte du rôle : seuls les membres de la Vie Scolaire (ID 3) accèdent à cette page.
// Le statut 3 est défini dans ta table 'statut'.
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
    // Redirection si l'utilisateur n'est pas autorisé
    header('Location: ../../front-end/form-connexion.php');
    exit(); // Sécurité : arrêt du script
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - Vie Scolaire</title>
    <link rel="stylesheet" href="../../Asset/css/style_vieScolaire.css">
</head>
<body>

    <header class="header">
        <div class="header-left">Vie Scolaire</div>
        
        <nav class="header-nav">
            <a href="Compte">Mon compte</a>
            <a href="Animations.php">Animations</a>
            <a href="Statistiques.php" class="active">Statistique</a>
        </nav>

        <div class="header-right">
            <a href="../../back-end/deconnexion.php" class="btn-deconnexion">Déconnecter</a>
        </div>
    </header>

    <main class="main-content">
        <h1>Statistique</h1>

        <div class="stats-grid-container">
            
            <div class="stat-item">
                <div class="stat-header-line">
                    <span class="label-text">présent</span>
                    <span class="stat-name">tarte aux fraise</span>
                    <span class="label-text">Absent</span>
                </div>
                <div class="bar-container">
                    <div class="bar-fill" style="width: 75%;"></div>
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-header-line">
                    <span class="label-text">présent</span>
                    <span class="stat-name">élève</span>
                    <span class="label-text">Absent</span>
                </div>
                <div class="bar-container">
                    <div class="bar-fill" style="width: 85%;"></div>
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-header-line">
                    <span class="label-text">présent</span>
                    <span class="stat-name">buche au chocolat</span>
                    <span class="label-text">Absent</span>
                </div>
                <div class="bar-container">
                    <div class="bar-fill" style="width: 60%;"></div>
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-header-line">
                    <span class="label-text">présent</span>
                    <span class="stat-name">animateur</span>
                    <span class="label-text">Absent</span>
                </div>
                <div class="bar-container">
                    <div class="bar-fill" style="width: 50%;"></div>
                </div>
            </div>

        </div>
    </main>

    <div class="navigation-container">
        <a href="../accueil.php" class="btn-retour"> ← retour</a>
    </div>

    <footer class="footer">
        © 2026 - Lycée | Bureau Vie Scolaire
    </footer>
</body>
</html>