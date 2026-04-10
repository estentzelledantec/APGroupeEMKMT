<?php
require_once(dirname(__DIR__).'/Intervenant/back-end/etat_intervenant.php');
require_once(dirname(__DIR__).'/Intervenant/back-end/modifions.php');
include_once(dirname(__DIR__).'/back-end/connexion.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier animation</title>
    <link rel="stylesheet" href="../Asset/css/style_intervenant.css">
</head>

<body>

<header class="header">
    <div class="header-left">Intervenant/animateur</div>

    <nav class="header-nav">
        <a href="../Intervenant/accueil.php">Accueil</a>
        <a href="#">Statistiques</a>
        <a href="../Intervenant/appelle.php">Présence/absence</a>
    </nav>

    <div class="header-right">
        <a href="../back-end/deconnexion.php" class="btn-deconnexion">Déconnecter</a>
    </div>
</header>

<main class="main-content">

<h1>Modifier une animation</h1>

<form action="/Intervenant/back-end/modifier_un_stage.php" method="POST" target="_self">

    <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div>
            <label>Titre</label><br>
            <input type="text" name="titre" value="<?php echo $animation['Titre']; ?>" required>
        </div>
            <div>
                <label>Date début</label><br>
                <input type="datetime-local" name="dateDebut" value="<?php echo $animation['DateHeureDeb']; ?>">
            </div>

            <div>
                <label>Date fin</label><br>
                <input type="datetime-local" name="dateFin" value="<?php echo $animation['DateHeureFin']; ?>">
            </div>

        <div>
            <label>Nombre de Participant Minimum</label><br>
            <input type="text" name="nbreMin" value="<?php echo $animation['nbreMin']; ?>" required>
        </div>

        <div>
            <label>Nombre de Participant Maximum</label><br>
            <input type="text" name="nbreMax" value="<?php echo $animation['nbreMax']; ?>" required>
        </div>

        <div>
            <label>Matériel</label><br>
            <input type="text" name="materiel" value="<?php echo $animation['materiel']; ?>" required>
        </div>

        <div>
            <label>Commentaire</label><br>
            <textarea name="commentaire"><?php echo $animation['commentaire']; ?></textarea>
        </div>

        <div>
            <label>Lieu</label><br>
            <input type="text" name="idLieu" value="<?php echo $animation['idLieu']; ?>" required>
        </div>


<br>
<button type="submit" class="btn-deconnexion">Enregistrer</button>

</form>

</main>

<footer class="footer">
© 2026 - Role
</footer>

</body>
</html>