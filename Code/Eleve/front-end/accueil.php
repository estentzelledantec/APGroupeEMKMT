<?php
// ========================================================================
// 1. INITIALISATION ET CONNEXION À LA BASE DE DONNÉES
// ========================================================================
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=animationsfld;charset=utf8', 'root', '');
    
    // Désactivation de l'émulation des requêtes préparées pour la protection SQL 
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // Gestion des erreurs en mode Exception 
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion à la base de données."); 
}

// ========================================================================
// 2. RÉCUPÉRATION ET SÉCURISATION DES DONNÉES GET (FILTRES)
// ========================================================================
$id_user = $_SESSION['id_user'] ?? $_SESSION['id'] ?? 1;

// On force la validation en tant qu'entier pour sécuriser la saisie du filtre
$filtre_theme = filter_input(INPUT_GET, 'theme', FILTER_VALIDATE_INT);

// Sécurisation du tri : seules deux valeurs strictes sont autorisées (ASC ou DESC)
// Cela empêche toute injection SQL dans la clause ORDER BY
$tri_date = (isset($_GET['tri_date']) && $_GET['tri_date'] === 'desc') ? 'DESC' : 'ASC';

// ========================================================================
// 3. REQUÊTES SQL PRÉPARÉES
// ========================================================================

// --- A. Récupération des thèmes (pour le menu déroulant) ---
$req_themes = $bdd->query("SELECT ID, libelle FROM theme ORDER BY libelle ASC");
$tous_les_themes = $req_themes->fetchAll(PDO::FETCH_ASSOC);

// --- B. Construction de la requête principale (Animations) ---
$sql = "SELECT a.ID, a.Titre, a.DateHeureDeb, t.libelle AS theme_nom 
        FROM animation a
        INNER JOIN theme t ON a.idTheme = t.ID
        WHERE a.annulation = 0";

// Si un thème valide a été sélectionné, on ajoute la condition à la requête
if ($filtre_theme) {
    $sql .= " AND a.idTheme = :id_theme";
}

// On ajoute le tri 
$sql .= " ORDER BY a.DateHeureDeb " . $tri_date;

$requete = $bdd->prepare($sql);

// On associe la variable au marqueur SQL en forçant le typage (PARAM_INT)
if ($filtre_theme) {
    $requete->bindValue(':id_theme', $filtre_theme, PDO::PARAM_INT);
}

$requete->execute();
$animations = $requete->fetchAll(PDO::FETCH_ASSOC);

// --- C. Récupération des inscriptions de l'élève ---
$req_check = $bdd->prepare("SELECT id_animation FROM inscription WHERE id_inscrit = :id_user");
$req_check->bindValue(':id_user', $id_user, PDO::PARAM_INT);
$req_check->execute();
// On récupére directement un tableau avec juste les IDs d'animations avec "FETCH_COLUMN"
$liste_inscriptions = $req_check->fetchAll(PDO::FETCH_COLUMN);

// ======================================================================
// 4. ALGORITHME DE FILTRAGE (On retire les animations déjà inscrites)
// ======================================================================
$animations_dispo = [];

// On parcourt toutes les animations trouvées dans la base de données
foreach ($animations as $anim) {
    // Si l'ID de l'animation n'est PAS dans la liste des inscriptions de l'élève...
    if (!in_array($anim['ID'], $liste_inscriptions)) {
        // ... alors on la garde pour l'afficher !
        $animations_dispo[] = $anim;
    }
}

// On remplace le tableau complet par notre tableau filtré
$animations = $animations_dispo;
// ======================================================================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Animations</title>
    <link rel="stylesheet" href="../../Asset/css/style_eleve.css">
</head>
<body>
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
        <div class="page-layout">
            
            <!-- SECTION GAUCHE : LISTE DES ANIMATIONS -->
            <section class="section-animations">
                <h1>Animations disponibles</h1>
                
                <div class="animation-grid">
                    <?php if (empty($animations)): ?>
                        <p>Aucune animation ne correspond à vos critères de recherche ou vous êtes déjà inscrit à toutes les animations affichées.</p>
                    <?php else: ?>
                        <?php foreach ($animations as $anim): ?>
                            <article class="card">
                                <div class="card-header">
                                    <span class="avatar"><?php echo strtoupper(substr($anim['Titre'], 0, 1)); ?></span>
                                    <!-- Prévention des failles XSS lors de l'affichage avec htmlspecialchars -->
                                    <h3><?php echo htmlspecialchars($anim['Titre'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                </div>
                                <p><strong>Thème :</strong> <?php echo htmlspecialchars($anim['theme_nom'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <span class="horaires-tag">📅 <?php echo date('d/m/Y H:i', strtotime($anim['DateHeureDeb'])); ?></span>
                                
                                <div class="card-footer">
                                    <!-- Puisqu'on a filtré en PHP, on sait que l'élève n'est pas inscrit. On affiche direct le bouton ! -->
                                    <a href="../back-end/traiter_inscriptions.php?action=inscrire&id_anim=<?php echo $anim['ID']; ?>" class="btn-primary">
                                        S'inscrire
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <!-- SECTION DROITE : FILTRES -->
            <aside class="sidebar-filters">
                <form action="accueil.php" method="GET" class="filter-box">
                    <h3>Filtres & Tri</h3>
                    
                    <!-- Filtre Thème -->
                    <label for="theme">Thème :</label>
                    <select name="theme" id="theme" class="filter-select">
                        <option value="">Tous les thèmes</option>
                        <?php foreach ($tous_les_themes as $theme_db): ?>
                            <option value="<?php echo $theme_db['ID']; ?>" <?php if ($filtre_theme == $theme_db['ID']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($theme_db['libelle'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Filtre Date (Ordre) -->
                    <label for="tri_date">Trier par date :</label>
                    <select name="tri_date" id="tri_date" class="filter-select">
                        <option value="asc" <?php if ($tri_date === 'ASC') echo 'selected'; ?>>Croissant (Plus proches)</option>
                        <option value="desc" <?php if ($tri_date === 'DESC') echo 'selected'; ?>>Décroissant (Plus lointaines)</option>
                    </select>

                    <button type="submit" class="btn-primary btn-full">Appliquer</button>
                    
                    <!-- Petit lien pour réinitialiser les filtres s'ils sont actifs -->
                    <?php if ($filtre_theme || $tri_date === 'DESC'): ?>
                        <div class="reset-filter-container">
                            <a href="accueil.php" class="btn-reset">Effacer les filtres</a>
                        </div>
                    <?php endif; ?>
                </form>
            </aside>
            

        </div>
    </main>
        <!-- FOOTER -->
    <footer class="footer">
        <p>© 2026 - Lycée | Tous droits réservés</p>
        <p>Contact : contact@lycee.fr</p>
    </footer>
</body>
</html>