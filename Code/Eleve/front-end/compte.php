<?php
// ========================================================================
// 1. INITIALISATION
// ========================================================================
session_start();
require_once '../back-end/OutilsChiffrement.php'; 

try {
    $bdd = new PDO('mysql:host=localhost;dbname=animationsfld;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion."); 
}

// ========================================================================
// 2. RÉCUPÉRATION DES DONNÉES (MODÈLE)
// ========================================================================
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../front-end/form-connexion.php');
    exit();
}
$id_user = $_SESSION['user_id'];

// APPEL DU FICHIER SQL 
include '../../back-end/code_sql/code_sql_Eleve.php';

// ========================================================================
// 3. LOGIQUE MÉTIER : DÉCHIFFREMENT INTELLIGENT
// ========================================================================
if ($user_bdd) {
    // Tentative de déchiffrement. Si Erreur_Decodage, on garde la valeur brute.
    $nom_clair = dechiffrer_donnee($user_bdd['nom']);
    if ($nom_clair === "Erreur_Decodage") { $nom_clair = $user_bdd['nom']; }

    $prenom_clair = dechiffrer_donnee($user_bdd['prenom']);
    if ($prenom_clair === "Erreur_Decodage") { $prenom_clair = $user_bdd['prenom']; }
    
    if (!empty($user_bdd['classe'])) {
        $classe_clair = dechiffrer_donnee($user_bdd['classe']);
        if ($classe_clair === "Erreur_Decodage") { $classe_clair = $user_bdd['classe']; }
    } else {
        $classe_clair = "Non renseignée";
    }

    $email_clair = !empty($user_bdd['emel']) ? $user_bdd['emel'] : "Non renseigné";
} else {
    $nom_clair = $prenom_clair = "Introuvable";
    $classe_clair = "Non renseignée";
    $email_clair = "Non renseigné";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Informations - Espace Élève</title>
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
        <h1>Mes Informations</h1>

        <div class="card profile-card">
            <div class="card-header">
                <span class="avatar">👤</span>
                <h3>Détails du compte</h3>
            </div>
            
            <div class="profile-details">
                <!-- Protection XSS systématique à l'affichage des variables PHP -->
                <p><strong>Nom :</strong> <?php echo htmlspecialchars($nom_clair, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Prénom :</strong> <?php echo htmlspecialchars($prenom_clair, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Classe :</strong> <?php echo htmlspecialchars($classe_clair, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Email :</strong> <?php echo htmlspecialchars($email_clair, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            
            <p class="profile-footer-text">
                Si vous constatez une erreur, merci de vous rapprocher de la vie scolaire.
            </p>
        </div>
    </main>
        <!-- FOOTER -->
    <footer class="footer">
        <p>© 2026 - Lycée | Tous droits réservés</p>
        <p>Contact : contact@lycee.fr</p>
    </footer>
</body>
</html>