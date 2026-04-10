<?php
session_start();


if (!isset($_SESSION['role_id'])) {
    header('Location: ../front-end/form-connexion.php');
    exit();
}


// Vérification de sécurité : seul le statut 4 (Administrateur) peut accéder
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 4) {
    header('Location: ../front-end/form-connexion.php');
    exit();
}

// Connexion à la base pour charger les statuts 
require_once '../back-end/base.php';
require __DIR__ . '../back-end/resultatback.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Role - Administrateur</title>
    <link rel="stylesheet" href="../Asset/css/style_admin.css">
	
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

    <header class="header">
        <div class="header-left">
			<a class="navbar-brand" href="accueil.php">Administrateur</a>
		</div>

        <div class="header-right">
            <a href="../back-end/deconnexion.php" class="btn-deconnexion">Déconnecter</a>
        </div>
    </header>

    <main class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="m-0">Administrateur</h1>

            <div id="bouton" class="d-flex gap-2">
                <a class="btn btn-outline-primary" type="button">Importer</a>
                <button type="button" class="btn btn-outline-primary" disabled data-bs-toggle="button">Nettoyage</button>
                <a href="/Administrateur/front-end/form_ajout.php" class="btn btn-outline-primary">Ajouter un compte</a>
            </div>
        </div>

        <div id="bouton" class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Statuts
            </button>
            <ul class="dropdown-menu">
				<a class="dropdown-item" href="/Administrateur/front-end/resultat.php">
						Animateur
					</a>

                <?php foreach ($stat as $cat): ?>
                    <li>
					
                        <a class="dropdown-item" href="/Administrateur/front-end/resultat.php?id=<?= $cat['ID'] ?>">
                            <?= htmlspecialchars($cat['libelle']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>
	<!-- FOOTER -->
    <footer class="footer">
        © 2026 - Role
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>