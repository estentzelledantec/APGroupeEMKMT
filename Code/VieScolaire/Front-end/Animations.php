<?php
session_start();

// 1. On remonte de deux niveaux pour atteindre la racine
require_once '../../back-end/base.php'; 

// 2. On charge les fonctions SQL
require_once '../../back-end/code_sql/code_sql_VieScolaire.php';

// 3. Appel de la fonction avec la variable corrigée $bdd
$mes_inscriptions = obtenirToutesLesInscriptions($bdd);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vie Scolaire - Animations</title>
    <link rel="stylesheet" href="../../Asset/css/style_vieScolaire.css">
</head>
<body>

    <header class="header">
        <div class="header-left">Vie Scolaire</div>
        <nav class="header-nav">
            <a href="Compte.php">Mon compte</a>
            <a href="Animations.php" class="active">Animations</a>
            <a href="Statistiques.php">Statistique</a>
            <div class="action-bar">
            <a href="../Back-end/generer_absences.php" class="btn-pdf">Absences PDF</a>
            </div>
        </nav>
        <div class="header-right">
            <a href="../../Back-end/deconnexion.php" class="btn-deconnexion">Déconnecter</a>
        </div>
        
    </header>

    <div class="container">
        <h2>Gestion des Animations</h2>

        <?php if (empty($mes_inscriptions)): ?>
            <p class="empty-msg">Aucun élève inscrit pour le moment.</p>
        <?php else: ?>
            <?php foreach ($mes_inscriptions as $ins): ?>
                <div class="card">
                    <div class="user-info">
                        <span class="user-name">
                            <?= htmlspecialchars($ins['nom'] . " " . $ins['prenom'] . " (" . $ins['classe'] . ")") ?>
                        </span>
                        
                        <p class="anim-details">
                            <?= htmlspecialchars($ins['Titre']) ?> - <?= htmlspecialchars($ins['DateHeureDeb']) ?>
                        </p>
                        
                        <div class="statut">
                            <?php if ($ins['presence'] == '1'): ?>
                                <span class="status-present">✓ présent</span>
                            <?php else: ?>
                                <span class="status-absent">✗ absent</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="actions">
                        <a href="../Back-end/traiter_animation.php?id_ani=<?= $ins['id_animation'] ?>&id_ins=<?= $ins['id_inscrit'] ?>&action=1" class="btn-action confirmer">confirmer</a>
                        <a href="../Back-end/traiter_animation.php?id_ani=<?= $ins['id_animation'] ?>&id_ins=<?= $ins['id_inscrit'] ?>&action=0" class="btn-action annuler">annuler</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <a href="../accueil.php" class="btn-retour">← retour</a>
    </div>

</body>
</html>