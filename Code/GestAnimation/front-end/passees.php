<?php
$animations = require("../back-end/getAnimationsPassees.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestionnaire des Animations</title>
    <link rel="stylesheet" href="../../Asset/css/style_gestAnimation.css">
</head>
<body>

<header class="header">
    <a class="header-left" href="../accueil.php">Gestionnaire des Animations</a>
    <nav class="header-nav">
        <a href="aVenir.php">Animations à venir</a>
        <a href="passees.php">Animations passées</a>
        <a href="statistiques.php">Statistiques</a>
    </nav>
    <div class="header-right">
        <a href="../../back-end/deconnexion.php" class="btn-deconnexion">Déconnecter</a>
    </div>
</header>

<main class="main-content">
    <h1>Les animations passées:</h1>

    <div class="animations">
        <?php foreach ($animations as $anim):
        ?>
        <div class="carte-animation">
            <div class="top">
                <strong><?= htmlspecialchars($anim['Titre']) ?></strong>
                <span class="nb-inscrit">
                    Nombre d'inscrits : <?= $anim['nbInscrits'] ?>
                </span>
            </div>

            <div class="description"><?= htmlspecialchars($anim['commentaire']) ?></div>
            <div>Catégorie : <?= htmlspecialchars($anim['theme']) ?></div>
            <div>Date : <?= date("d/m/Y H:i", strtotime($anim['DateHeureDeb'])) ?></div>


        </div>
        <?php endforeach; ?>
    </div>
</main>

<footer class="footer">© 2026 - Gestionnaire des Animations</footer>

</body>
</html>