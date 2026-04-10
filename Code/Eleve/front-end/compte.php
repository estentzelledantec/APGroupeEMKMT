<?php
// ========================================================================
// 1. INITIALISATION ET CONNEXION À LA BASE DE DONNÉES
// ========================================================================
session_start();

// Inclusion de la boîte à outils pour le déchiffrement des données
require_once '../back-end/OutilsChiffrement.php'; 

try {
    $bdd = new PDO('mysql:host=localhost;dbname=animationsfld;charset=utf8', 'root', '');
    
    // Désactivation de l'émulation des requêtes préparées pour la sécurité 
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // Gestion des erreurs en mode Exception pour ne pas afficher d'informations sensibles
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion à la base de données."); 
}

// ========================================================================
// 2. RÉCUPÉRATION DES INFORMATIONS DE L'UTILISATEUR
// ========================================================================
$id_user = $_SESSION['id_user'] ?? $_SESSION['id'] ?? 1;

// Requête préparée pour aller chercher les informations de l'élève connecté
$sql = "SELECT nom, prenom, classe, emel FROM inscrit WHERE ID = :id_user";
$req = $bdd->prepare($sql);

// Sécurisation de l'identifiant en forçant le type "Entier" pour contrer les injections SQL
$req->bindValue(':id_user', $id_user, PDO::PARAM_INT);
$req->execute();

// On récupère les données sous forme de tableau associatif
$user_bdd = $req->fetch(PDO::FETCH_ASSOC);

// ========================================================================
// 3. LOGIQUE MÉTIER : DÉCHIFFREMENT INTELLIGENT
// ========================================================================
if ($user_bdd) {
    // La fonction dechiffrer_donnee() tente de déchiffrer la chaîne.
    // Si elle échoue (parce que le nom est encore en clair dans la BDD), on garde la valeur brute.
    $nom_clair = dechiffrer_donnee($user_bdd['nom']) ?: $user_bdd['nom'];
    $prenom_clair = dechiffrer_donnee($user_bdd['prenom']) ?: $user_bdd['prenom'];
    
    // Vérification pour la classe qui peut être vide
    if (!empty($user_bdd['classe'])) {
        $classe_clair = dechiffrer_donnee($user_bdd['classe']) ?: $user_bdd['classe'];
    } else {
        $classe_clair = "Non renseignée";
    }

    $email_clair = !empty($user_bdd['emel']) ? $user_bdd['emel'] : "Non renseigné";
} else {
    // Valeurs de sécurité par défaut si l'utilisateur n'est pas trouvé dans la base
    $nom_clair = "Introuvable";
    $prenom_clair = "Introuvable";
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
    <link rel="stylesheet" href="/../../../Asset/css/style_eleve.css">
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