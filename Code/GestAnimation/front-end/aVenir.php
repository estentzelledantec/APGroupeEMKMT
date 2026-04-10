<?php
$animations = require("../back-end/getAnimations.php");
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
        <a href="#">Animations passées</a>
        <a href="#">Statistiques</a>
    </nav>
    <div class="header-right">
        <a href="../../back-end/deconnexion.php" class="btn-deconnexion">Déconnecter</a>
    </div>
</header>

<main class="main-content">
    <h1>Les animations :</h1>

    <div class="animations">
        <?php foreach ($animations as $anim):
            $alerte = ($anim['nbInscrits'] < $anim['nbreMin']);
        ?>
        <div class="carte-animation <?= $alerte ? 'alerte' : '' ?>">
            <div class="top">
                <strong><?= htmlspecialchars($anim['Titre']) ?></strong>
                <span class="nb-inscrit">
                    Nombre d'inscrits : <?= $anim['nbInscrits'] ?> /
                    <?= $anim['nbreMin'] ?> min - <?= $anim['nbreMax'] ?> max
                </span>
            </div>

            <div class="description"><?= htmlspecialchars($anim['commentaire']) ?></div>
            <div>Catégorie : <?= htmlspecialchars($anim['theme']) ?></div>
            <div>Date : <?= date("d/m/Y H:i", strtotime($anim['DateHeureDeb'])) ?></div>

            <?php if ($alerte): ?>
                <div style="color: #FECACA; font-weight:bold;"> Minimum non atteint !</div>
            <?php endif; ?>

            <form method="POST" action="../back-end/annuler.php">
                <input type="hidden" name="id_animation" value="<?= $anim['ID'] ?>">
                <button class="annulerAnim" onclick="return confirm('Supprimer cette animation ?')">
                    Annuler
                </button>
            </form>

            <form method="GET" action="../front-end/formModifier.php">
				<input type="hidden" name="id" value="<?= $anim['ID'] ?>">
				<button type="submit" class="btn-modifier">
					Modifier
				</button>
			</form>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<footer class="footer">© 2026 - Gestionnaire des Animations</footer>

</body>
</html>