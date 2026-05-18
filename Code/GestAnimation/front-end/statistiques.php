<?php
$stats = require("../back-end/getStats.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques</title>
    <link rel="stylesheet" href="../../Asset/css/style_gestAnimation.css">
</head>
<body>

<header class="header">

    <a class="header-left" href="../accueil.php">
        Gestionnaire des Animations
    </a>

    <nav class="header-nav">
        <a href="aVenir.php">Animations à venir</a>
        <a href="passees.php">Animations passées</a>
        <a href="statistiques.php">Statistiques</a>
    </nav>

    <div class="header-right">
        <a href="../../back-end/deconnexion.php" class="btn-deconnexion">
            Déconnecter
        </a>
    </div>

</header>

<main class="main-content">

    <h1>Les statistiques</h1>

    <div class="stats-container">

        <div class="stats">

            <div>
                <h2>Taux de présence</h2>
                <p><?= round($stats["tauxPresence"], 2) ?> %</p>
            </div>

            <div>
                <h2>Animations</h2>
                <p><?= count($stats["topAnimations"]) ?></p>
            </div>

        </div>

        <hr>

        <h2>Animations les plus populaires</h2>

        <?php foreach ($stats["topAnimations"] as $a): ?>

            <div class="stats-card">

                <strong>
                    <?= htmlspecialchars($a["Titre"]) ?>
                </strong>

                <span>
                    <?= $a["nbInscrits"] ?> inscrits
                </span>

            </div>

        <?php endforeach; ?>

        <hr>

        <h2>Créneaux les plus actifs</h2>

        <?php foreach ($stats["heures"] as $h): ?>

            <div class="stats-card">

                <strong>
                    <?= $h["heure"] ?>h
                </strong>

                <span>
                    <?= $h["nbInscrits"] ?> inscrits
                </span>

            </div>

        <?php endforeach; ?>

        <hr>

        <h2>Thèmes préférés</h2>

        <?php foreach ($stats["themes"] as $t): ?>

            <div class="stats-card">

                <strong>
                    <?= htmlspecialchars($t["theme"]) ?>
                </strong>

                <span>
                    <?= $t["nbInscrits"] ?> inscrits
                </span>

            </div>

        <?php endforeach; ?>

    </div>

</main>

<footer class="footer">
    © 2026 - Gestionnaire des Animations
</footer>

</body>
</html>