<?php 
require __DIR__ . '/../back-end/utilisateur_modif.php';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire d'ajout d'un compte</title>
  	<link rel="stylesheet" href="/../../Asset/css/style_admin.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body class="derriere">
	<header class="header">
        <div class="header-left">
			<a class="navbar-brand" href="../accueil.php">Administrateur</a>
		</div>

        <div class="header-right">
            <a href="../../back-end/deconnexion.php" class="btn-deconnexion">Déconnecter</a>
        </div>
    </header>
	<main class="main-content">
	  <section class="story">
		
		<h2>Modifier un compte</h2>
		
		<form method="POST" action="../back-end/modification.php">

				
				<!-- ID caché -->
			
			<input type="hidden" name="table" value="<?= $table ?>">

			<?php if ($table !== 'administration'): ?>
				<div class="form-group">
					<label>Prénom :</label>
					<input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>">
				</div>

				<div class="form-group">
					<label>Nom :</label>
					<input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($user['nom'] ?? '') ?>">
				</div>
			<?php endif; ?>

			<div class="form-group">
				<label>Téléphone :</label>
				<input type="text" name="tel" class="form-control" value="<?= htmlspecialchars($user['tel'] ?? '') ?>">
			</div>

			<div class="form-group">
				<label>Email :</label>
				<input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['emel'] ?? '') ?>">
			</div>

			<div class="form-group">
				<label>Mot de passe :</label>
				<input type="password" name="mot_de_passe" class="form-control">
				<small>(Laisser vide pour ne pas changer le mot de passe)</small>
			</div>

			<button type="submit" class="btn btn-primary">Modifier</button>

		</form>
		
	  </section>
	</main>
	
	<!-- FOOTER -->
    <footer class="footer">
        © 2026 - Role
    </footer>

    <!-- Bootstrap 5 JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>