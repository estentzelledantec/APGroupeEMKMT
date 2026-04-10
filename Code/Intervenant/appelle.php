<?php
require_once(dirname(__DIR__).'/Intervenant/back-end/pas_appelle.php');
include_once(dirname(__DIR__).'/back-end/connexion.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Intervenant</title>
    <link rel="stylesheet" href="/Asset/css/style_intervenant.css">

    <!-- Ajout uniquement pour améliorer le tableau -->
    <style>
    </style>
</head>
<body>
    <!-- Enchantix -->

    <!-- HEADER -->
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

<?php if ($animation_id == null) { ?>
<main class="main-content">
  <h1>Pas d'animation pour l'instant !!</h1>
</main>
<?php } else { ?>

    <!-- MAIN -->
    <main class="main-content">
    <h1>Faire l'appel des élèves de l'animation "<?php echo $titre ?>"</h1>

    <form action="/Intervenant/back-end/lappelle" method="POST" target="_self">
        <input type="hidden" name="id_animation" value="<?php echo $animation_id ?>" />
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Classe</th>
                    <th>Présence</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach($eleves as $eleve) { ?>
            <tr>
                <td><?php echo $eleve['nom']; ?></td>
                <td><?php echo $eleve['prenom']; ?></td>
                <td><?php echo $eleve['classe']; ?></td>
                <td>
                    <input type="checkbox" 
                        name="presence[<?php echo $eleve['ID']; ?>]" 
                        value="1"
                        <?php echo $eleve['presence'] === 1 ? 'checked' : '' ?>
                    >
                </td>
            </tr>
            <?php } ?>
            </tbody>

        </table>

        <br>
        <button type="submit">Valider l'appel</button>
    </form>
<?php } ?>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        © 2026 - Role
    </footer>

</body>
</html>
