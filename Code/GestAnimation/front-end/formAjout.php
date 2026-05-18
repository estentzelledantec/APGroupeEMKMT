<?php
$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$themes = $pdo->query("SELECT * FROM theme ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);
$animateurs = $pdo->query("SELECT * FROM animateur ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
$lieux = $pdo->query("SELECT * FROM lieu ORDER BY batiment, numsalle")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une animation</title>
    <link rel="stylesheet" href="../../Asset/css/style_gestAnimation.css">
</head>
<body>

<header class="header">
    <a class="header-left" href="../accueil.php">Gestionnaire des Animations</a>
</header>

<main class="main-content">
    <h1>Ajouter une animation</h1>

    <div class="form-container">
        <form method="POST" action="../back-end/ajouterAnimation.php" class="form-animation">

            <label>Titre</label>
            <input type="text" name="titre" required>

            <label>Date de début</label>
            <input type="datetime-local" name="dateDeb" required>

            <label>Date de fin</label>
            <input type="datetime-local" name="dateFin" required>

            <label>Commentaire</label>
            <textarea name="commentaire" required></textarea>

            <label>Matériel</label>
            <input type="text" name="materiel" required>

            <label>Min</label>
            <input type="number" name="min" required>

            <label>Max</label>
            <input type="number" name="max" required>

            <!-- THEME -->
            <label>Thème</label>
            <select name="idTheme">
                <option value="">-- Choisir un thème --</option>
                <?php foreach ($themes as $t): ?>
                    <option value="<?= $t['ID'] ?>">
                        <?= htmlspecialchars($t['libelle']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Ou ajouter un nouveau thème</label>
            <input type="text" name="newTheme" placeholder="Nouveau thème (optionnel)">

            <!-- ANIMATEUR -->
            <label>Animateur</label>
            <select name="idAnimateur" required>
                <option value="">-- Choisir un animateur --</option>
                <?php foreach ($animateurs as $a): ?>
                    <option value="<?= $a['ID'] ?>">
                        <?= htmlspecialchars($a['nom'] . " " . $a['prenom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- LIEU -->
            <label>Lieu</label>
            <select name="idLieu" required>
                <option value="">-- Choisir un lieu --</option>
                <?php foreach ($lieux as $l): ?>
                    <option value="<?= $l['ID'] ?>">
                        <?= $l['batiment'] . " " . $l['numsalle'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn-enregistrer">Ajouter</button>
            <a href="../accueil.php" class="btn-retour">Retour</a>

        </form>
    </div>
</main>

</body>
</html>