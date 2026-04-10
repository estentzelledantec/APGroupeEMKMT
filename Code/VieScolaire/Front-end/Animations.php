<?php
/**
 * GESTION DES PRÉSENCES - ESPACE VIE SCOLAIRE
 * Cette page permet de visualiser les inscriptions et de valider la présence des élèves.
 */

session_start();

// =========================================================================
// 1. CHARGEMENT DES DÉPENDANCES ET SÉCURITÉ
// =========================================================================

// Inclusion de l'outil Libsodium pour le déchiffrement des données de présence
require_once('../Back-end/outil_chiffrement.php'); 

// Connexion à la base de données avec l'utilisateur dédié 'viescolaire'
try {
    $bdd = new PDO('mysql:host=localhost;dbname=animationsfld;charset=utf8', 'viescolaire', 'Btssio2017');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// =========================================================================
// 2. RÉCUPÉRATION DES INSCRIPTIONS (SQL)
// =========================================================================

/**
 * Requête récupérant :
 * - Les infos de l'élève (table inscrit)
 * - Les détails de l'activité (table animation)
 * - Le statut de présence chiffré (table inscription)
 */
$requete = $bdd->prepare("
    SELECT 
        u.nom, u.prenom, u.classe, 
        a.Titre, a.DateHeureDeb, 
        i.id_animation, i.id_inscrit, i.presence
    FROM inscription i
    INNER JOIN inscrit u ON i.id_inscrit = u.ID
    INNER JOIN animation a ON i.id_animation = a.ID
    ORDER BY a.DateHeureDeb DESC
");
$requete->execute();
$mes_inscriptions = $requete->fetchAll(PDO::FETCH_ASSOC); 
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
        </nav>
        <div class="action-bar">
            <a href="generer_absences.php" class="btn-pdf">Absences PDF</a>
        </div>
        <div class="header-right">
            <a href="../../back-end/deconnexion.php" class="btn-deconnexion">Déconnecter</a>
        </div>
    </header>

    <div class="container">
        
        <h2>Gestion des Animations</h2>

        <?php if (empty($mes_inscriptions)): ?>
            <p>Aucun élève inscrit pour le moment.</p>
        <?php else: ?>
            <?php foreach ($mes_inscriptions as $ins): ?>
                <?php 
                    /**
                     * DÉCHIFFREMENT RGPD :
                     * La valeur stockée en base est une chaîne Base64.
                     * On utilise la fonction de ton outil pour retrouver '1' ou '0'.
                     */
                    $etat_reel = dechiffrer_donnee($ins['presence']); 
                ?>
                <div class="navbar">
                    <div class="card">
                        <div class="user-info">
                            <div class="avatar">👤</div>
                            <div class="text-info">
                                <strong><?= htmlspecialchars($ins['nom'] . " / " . $ins['prenom'] . " / " . $ins['classe']) ?></strong>
                                <p><?= htmlspecialchars($ins['Titre'] . " / " . $ins['DateHeureDeb']) ?></p>
                            </div>
                        </div>
                        
                        <div class="actions">
                            <?php if ($etat_reel === '1' || $etat_reel === 1): ?>
                                <span class="btn-action confirmer">✓ présent</span>
                                <a href="../Back-end/traiter_animation.php?id_ani=<?= $ins['id_animation'] ?>&id_ins=<?= $ins['id_inscrit'] ?>&action=0" class="modifier">Modifier</a>

                            <?php elseif ($etat_reel === '0' || $etat_reel === 0): ?>
                                <span class="btn-action annuler">✕ absent</span>
                                <a href="../Back-end/traiter_animation.php?id_ani=<?= $ins['id_animation'] ?>&id_ins=<?= $ins['id_inscrit'] ?>&action=1" class="modifier">Modifier</a>

                            <?php else: ?>
                                <a href="../Back-end/traiter_animation.php?id_ani=<?= $ins['id_animation'] ?>&id_ins=<?= $ins['id_inscrit'] ?>&action=1" class="btn-action confirmer">confirmer</a>
                                <a href="../Back-end/traiter_animation.php?id_ani=<?= $ins['id_animation'] ?>&id_ins=<?= $ins['id_inscrit'] ?>&action=0" class="btn-action annuler">annuler</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

   <div class="navigation-container">
        <a href="../accueil.php" class="btn-retour"> ← retour</a>
    </div>

    <footer class="footer">
        © 2026 - Lycée | Bureau Vie Scolaire
    </footer>
</body>
</html>