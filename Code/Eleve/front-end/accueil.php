<?php
// ========================================================================
// 1. INITIALISATION ET CONNEXION À LA BASE DE DONNÉES
// ========================================================================
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=animationsfld;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion à la base de données."); 
}

// ========================================================================
// 2. RÉCUPÉRATION ET SÉCURISATION DES DONNÉES DE SESSION ET FILTRES
// ========================================================================
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../front-end/form-connexion.php');
    exit();
}

$id_user = $_SESSION['user_id'];
$filtre_theme = filter_input(INPUT_GET, 'theme', FILTER_VALIDATE_INT);
$tri_date = (isset($_GET['tri_date']) && $_GET['tri_date'] === 'desc') ? 'DESC' : 'ASC';

// ========================================================================
// 3. APPEL DU CODE SQL (MODÈLE)
// ========================================================================
// On inclut le fichier qui contient toutes nos requêtes préparées
include '../../back-end/code_sql/code_sql_Eleve.php';

// ======================================================================
// 4. ALGORITHME DE FILTRAGE (Logique d'affichage)
// ======================================================================
$animations_dispo = [];
foreach ($animations as $anim) {
    if (!in_array($anim['ID'], $liste_inscriptions)) {
        $animations_dispo[] = $anim;
    }
}
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