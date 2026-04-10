<?php
// Connexion à la base 
require_once '../../back-end/base.php';
require_once __DIR__ . '../../back-end/crypto.php';
require __DIR__ . '../../back-end/resultatback.php';
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
	<link rel="stylesheet" href="../../Asset/css/style_admin.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Liste des personnes</title>
</head>
<body>

	<header class="header">
        <div class="header-left">
			<a class="navbar-brand" href="../accueil.php">Administrateur</a>
		</div>

        <div class="header-right">
            <a href="../../back-end/deconnexion.php" class="btn-deconnexion">Déconnecter</a>
        </div>
    </header>
	<main class="main-content">

		
			<div class="d-flex justify-content-between align-items-center mb-3">
				<h1>Statut : <?= htmlspecialchars($statut['libelle']) ?></h1>

				<div id="bouton" class="d-flex gap-2">
					<a class="btn btn-outline-primary" type="button">Importer</a>
					<button type="button" class="btn btn-outline-primary" disabled data-bs-toggle="button">Nettoyage</button>
					<a href="/Administrateur/front-end/form_ajout.php" class="btn btn-outline-primary">Ajouter un compte</a>
				</div>
			</div>

		<?php if (empty($personnes)): ?>
			<p>Aucune personne trouvée pour ce statut.</p>
		<?php else: ?>
		<div class="d-flex justify-content-between align-items-center mb-3">
			<ul>
				<?php foreach ($personnes as $p): ?>
					<li>
						
					<?php if ($administration):
					// Tentative de déchiffrement

					$email_dechiffre = decryptData($p['emel']);

					// Si decryptData renvoie null → l'email n'était pas chiffré
					if ($email_dechiffre === null) {
						$email_affiche = $p['emel']; // email en clair
					} else {
						$email_affiche = $email_dechiffre; // email déchiffré
					}
					?>

            <?= htmlspecialchars($email_affiche) ?>



					<?php else: ?>

						<?= htmlspecialchars($p['prenom']) ?> 
						<?= htmlspecialchars($p['nom']) ?> 
					<?php endif; ?>

						<button id="bouton" class="bi bi-pencil btn btn-outline-primary" ></button>
						<button id="bouton"  class="bi bi-trash3 btn btn-outline-primary"></button>
					</li>
						
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>
		
		<div id="bouton" class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Statuts
            </button>
            <ul class="dropdown-menu">
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
        © 2026 - Role..............
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>