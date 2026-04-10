<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    die("ID invalide");
}

$id = (int) $_GET['id'];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);

    $stmt = $pdo->prepare("SELECT * FROM animation WHERE ID = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $anim = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$anim) {
        die("Animation introuvable");
    }

} catch (PDOException $e) {
    die("Erreur serveur");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une animation</title>
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
    <h1>Modifier l'animation</h1>

    <div class="form-container">
        <form method="POST" action="../back-end/modifier.php" class="form-animation">

            <input type="hidden" name="id" value="<?= htmlspecialchars($anim['ID']) ?>">

            <label>Titre</label>
            <input type="text" name="titre" required
                   value="<?= htmlspecialchars($anim['Titre'], ENT_QUOTES, 'UTF-8') ?>">

            <label>Date</label>
            <input type="datetime-local" name="dateDeb" required
                   value="<?= date('Y-m-d\TH:i', strtotime($anim['DateHeureDeb'])) ?>">

            <label>Commentaire</label>
            <textarea name="commentaire" required><?= htmlspecialchars($anim['commentaire'], ENT_QUOTES, 'UTF-8') ?></textarea>

            <label>Min</label>
            <input type="number" name="min" required
                   value="<?= htmlspecialchars($anim['nbreMin']) ?>">

            <label>Max</label>
            <input type="number" name="max" required
                   value="<?= htmlspecialchars($anim['nbreMax']) ?>">

            <button type="submit" class="btn-enregistrer">Enregistrer</button>
			<a href="../accueil.php" class="btn-retour">Retour</a>
        </form>
    </div>
</main>

<footer class="footer">© 2026 - Gestionnaire des Animations</footer>

</body>
</html>