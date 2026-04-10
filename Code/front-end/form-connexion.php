<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Lycée</title>
    <link rel="stylesheet" href="../Asset/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <header class="header">
        <div class="header-left">Site name</div>
        <nav class="header-nav">
            <a href="../index.php" class="btn-connexion">Accueil</a>
        </nav>
    </header>

    <main class="main-content">
        <div class="login-card">
            <h2>Connexion</h2>
            
            <?php if (isset($_SESSION['error'])): ?>
                <p class="error-msg"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>

            <form action="../back-end/connexion.php" method="POST" class="login-form">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <button type="submit" class="btn-connexion">Se connecter</button>
            </form>
        </div>
    </main>

    <footer class="footer">
        <p>© 2026 - Lycée | Tous droits réservés............</p> 
    </footer>
</body>
</html>