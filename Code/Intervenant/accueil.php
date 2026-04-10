<?php
require_once(dirname(__DIR__).'/Intervenant/back-end/etat_intervenant.php');
require_once(dirname(__DIR__).'/Intervenant/back-end/acc.php');

include_once(dirname(__DIR__).'/back-end/connexion.php');

?>
<!-- Patate -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Intervenant</title>
    <link rel="stylesheet" href="../Asset/css/style_intervenant.css">
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="header-left">Intervenant/animateur</div>

        <nav class="header-nav">
            <a href="../Intervenant/accueil.php">Accueil</a>
            <a href="#">Statistiques</a>
            <a href="../Intervenant/appelle.php">Présence/absence</a>
        </nav>

        <div class="header-right">
            <a href="../../back-end/deconnexion.php" class="btn-deconnexion">Déconnecter</a>
        </div>
    </header>

    <!-- MAIN -->
    <main class="main-content">
        <h1>Liste des animations</h1>
        <table>
            <tbody>
                    <?php foreach($lignes as $lignes) { ?>
                    <div class="col-md-2">
                    <br><h3><?php echo($lignes['Titre']); ?></h3>
                    <b><?php echo($lignes['commentaire']); ?></b>
                    <p><?php echo($lignes['DateHeureDeb']); ?></p>
                    <p><?php echo($lignes['DateHeureFin']); ?></p>
                    <br>
                    <a href="../Intervenant/Modifier.php?id=<?php echo($lignes['ID']); ?>" class="btn-deconnexion">Modifier</a>
                    <br>
                <?php } ; ?>
            </tbody>
        </table>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        © 2026 - Role
    </footer>
    

</body>
</html>
