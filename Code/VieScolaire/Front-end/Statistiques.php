<?php
session_start();
try {
    $bdd = new PDO('mysql:host=localhost;dbname=animationsfld;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) { die('Erreur : ' . $e->getMessage()); }

include '../../Back-end/code_sql/code_sql_VieScolaire.php';

// Récupération des chiffres
$stats = obtenirStatsGlobales($bdd);
$populaires = obtenirAnimationsPopulaires($bdd);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vie Scolaire - Statistiques</title>
    <link rel="stylesheet" href="../../Asset/css/style_vieScolaire.css">
</head>
<body>

    <header class="header">
        <div class="header-left">Vie Scolaire</div>
        <nav class="header-nav">
            <a href="Compte.php">Mon compte</a>
            <a href="Animations.php">Animations</a>
            <a href="Statistiques.php" class="active">Statistique</a>
        </nav>
        <div class="header-right">
            <a href="../../Back-end/deconnexion.php" class="btn-deconnexion">Déconnecter</a>
        </div>
    </header>

    <div class="container">
        <h2>Tableau de bord des présences</h2>

        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-number"><?= $stats['total'] ?></span>
                <span class="stat-label">Inscriptions totales</span>
            </div>
            <div class="stat-card">
                <span class="stat-number txt-presents"><?= $stats['presents'] ?></span>
                <span class="stat-label">Élèves présents</span>
            </div>
            <div class="stat-card">
                <span class="stat-number txt-absents"><?= $stats['absents'] ?></span>
                <span class="stat-label">Élèves absents</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?= $stats['pourcentage'] ?>%</span>
                <span class="stat-label">Taux de présence</span>
            </div>
        </div>

        <h2 class="title-margin">Animations les plus suivies</h2>
        <div class="card">
            <ul class="populaires-list">
                <?php foreach ($populaires as $ani): ?>
                    <li class="populaire-item">
                        <span><?= htmlspecialchars($ani['Titre']) ?></span>
                        <span class="nb-inscrits"><?= $ani['nb_inscrits'] ?> inscrits</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <a href="../accueil.php" class="btn-retour">← retour</a>
    </div>

</body>
</html>