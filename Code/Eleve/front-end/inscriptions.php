<?php
// ========================================================================
// 1. INITIALISATION ET CONNEXION À LA BASE DE DONNÉES
// ========================================================================
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=animationsfld;charset=utf8', 'root', '');
    
    // Désactivation de l'émulation des requêtes préparées pour une protection SQL
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // Gestion des erreurs en mode Exception pour ne pas fuiter d'infos sensibles
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion à la base de données."); 
}
//test4564651651
// ========================================================================
// 2. RÉCUPÉRATION DES INSCRIPTIONS DE L'ÉLÈVE
// ========================================================================
$id_user = $_SESSION['id_user'] ?? $_SESSION['id'] ?? 1;

// Requête préparée pour récupérer les animations (Triées de la plus lointaine à la plus proche : DESC)
$sql = "SELECT a.ID, a.Titre, a.DateHeureDeb, t.libelle AS theme_nom 
        FROM inscription i
        INNER JOIN animation a ON i.id_animation = a.ID
        INNER JOIN theme t ON a.idTheme = t.ID
        WHERE i.id_inscrit = :id_user
        ORDER BY a.DateHeureDeb DESC";

$requete = $bdd->prepare($sql);

// On associe l'ID de l'utilisateur en forçant le type "Entier" pour bloquer les injections
$requete->bindValue(':id_user', $id_user, PDO::PARAM_INT);
$requete->execute();

$mes_inscriptions = $requete->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Inscriptions - Espace Élève</title>
    <link rel="stylesheet" href="../../Asset/css/style_eleve.css">
</head>
<body class="bg-bleu-clair">
    <header class="header">
        <div class="header-left">Espace Élève</div>
        <nav class="header-nav">
            <a href="accueil.php">Animations</a>
            <a href="inscriptions.php">Mes Inscriptions</a>
            <a href="compte.php">Mon Profil</a>
        </nav>
        <div class="header-right">
            <a href="../../back-end/deconnexion.php" class="btn-deconnexion">Déconnexion</a>
        </div>
    </header>

    <main class="main-content">
        <h1>Mes inscriptions</h1>
        
        <div class="list-container">
            <?php if (empty($mes_inscriptions)): ?>
                <p>Vous n'êtes inscrit à aucune animation pour le moment.</p>
            <?php else: ?>
                
                <div class="animation-list">
                    <?php foreach ($mes_inscriptions as $ins): 
                        
                        // ======================================================================
                        // 3. LOGIQUE MÉTIER : GESTION DES DATES ET DE LA DÉSINCRIPTION
                        // ======================================================================
                        // On transforme les dates en secondes pour les comparer facilement
                        $temps_actuel = time(); 
                        $temps_animation = strtotime($ins['DateHeureDeb']);
                        
                        // Calcul de la date limite (-7 jours avant l'animation)
                        $temps_limite_desinscription = strtotime('-7 days', $temps_animation);

                        // Détermination de l'état de la carte
                        if ($temps_actuel > $temps_animation) {
                            $etat = 'passee'; // L'animation est déjà terminée
                        } elseif ($temps_actuel > $temps_limite_desinscription) {
                            $etat = 'bloquee'; // Moins de 7 jours, désinscription impossible
                        } else {
                            $etat = 'modifiable'; // Plus de 7 jours, le bouton s'affiche
                        }
                        // ======================================================================
                    ?>
                        
                        <article class="card-horizontal">
                            <!-- PARTIE GAUCHE (Textes et boutons) -->
                            <div class="card-left">
                                <!-- Protection XSS à l'affichage avec htmlspecialchars et ENT_QUOTES (sécuriser tous les guillemets) -->
                                <h3><?php echo htmlspecialchars($ins['Titre'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p class="description"><?php echo htmlspecialchars($ins['theme_nom'], ENT_QUOTES, 'UTF-8'); ?></p>
                                
                                <?php if ($etat == 'modifiable'): ?>
                                    <a href="../back-end/traiter_inscriptions.php?action=desinscrire&id_anim=<?php echo $ins['ID']; ?>" class="btn-desinscrire">
                                        se désinscrire
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- PARTIE DROITE (Icône de statut et Date) -->
                            <div class="card-right">
                                <?php if ($etat == 'modifiable'): ?>
                                    <div class="status-indicator status-vert">
                                        <span class="icon">ⓘ</span> Animation présente et modifiable
                                    </div>
                                <?php elseif ($etat == 'bloquee'): ?>
                                    <div class="status-indicator status-rouge">
                                        <span class="icon">①</span> datant de moins d'une semaine, non modifiable
                                    </div>
                                <?php elseif ($etat == 'passee'): ?>
                                    <div class="status-indicator status-bleu">
                                        <span class="icon">ⓘ</span> Animation passée
                                    </div>
                                <?php endif; ?>
                                
                                <!-- La date en bas à droite -->
                                <div class="date-text <?php echo 'text-' . $etat; ?>">
                                    <?php echo date('d/m/Y', strtotime($ins['DateHeureDeb'])); ?>
                                </div>
                            </div>
                        </article>

                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>
    </main>
        <!-- FOOTER -->
    <footer class="footer">
        <p>© 2026 - Lycée | Tous droits réservés</p>
        <p>Contact : contact@lycee.fr</p>
    </footer>
</body>
</html>