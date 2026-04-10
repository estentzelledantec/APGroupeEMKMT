<?php
$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "administrateur", "Btssio2017");
require_once __DIR__ . '/crypto.php';

$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
// Récupération des données du formulaire
$prenom = $_POST["prenom"];
$nom = $_POST["nom"];
$tel   = $_POST["telephone"];
$email = $_POST["email"];
$mdp   = $_POST["mot_de_passe"];
$cat   = $_POST["categorie"];
$statut = 0;

// Choisir la table selon la catégorie
if ($cat === "eleve") {
    $table = "inscrit";
	$statut = 1;
} 

elseif ($cat === "gestionnaireAnimation") {
    $table = "administration";
	$statut = 2;
} 

elseif ($cat === "viescolaire") {
  
  $table = "administration";
  $statut = 3;
} 

elseif ($cat === "administration") {
    $table = "administration";
	$statut = 4;
} 

elseif ($cat === "professeur") {
    $table = "inscrit";
	$statut = 5;
} 

elseif ($cat === "agentregion") {
    $table = "inscrit";
	$statut = 6;
} 

elseif ($cat === "animateur") {
    $table = "animateur";
} 


function isValidNom($str)
{
    if (!is_string($str) || $str === "") return false;
    return preg_match("/^[a-zA-ZÀ-ÿ\- ]+$/", $str);
}

// Vérification prenom
if (!isValidNom($prenom)) {
    $erreur['prenom']="Prenom invalide";
}

// Vérification nom
if (!isValidNom($nom)) {
    $erreur['nom']="Nom invalide";
}

// Vérification téléphone
if (!ctype_digit($tel)) {
    $erreur['telephone']="Erreur : le téléphone doit contenir uniquement des chiffres.";
}

// Vérification email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs['email'] = "Email invalide.";

}

// Vérification mot de passe

function isValidMDP($mdp)
{
    return preg_match('/^(?=.*[A-Z])(?=.*[0-9])(?=.*[,*?.:]).{10,}$/', $mdp);
}

if (!isValidMDP($mdp)) {
    $erreurs['mot_de_passe'] = "Mot de passe invalide (10 caractères, 1 majuscule, 1 chiffre, 1 caractère spécial).";

}
	 if (empty($erreurs)) {

			$mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
			
			// Chiffrement de l'email avant insertion
			$email_chiffre = encryptData($email);
			$tel_chiffre = encryptData($tel);


			// Insertion dans la bonne table
			if (empty($erreurs)) {

					$mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

					if ($table === "animateur") {
						$req = $pdo->prepare("
							INSERT INTO animateur (nom, prenom, tel, emel, mdphasher)
							VALUES (?, ?, ?, ?, ?)
						");
						$req->execute([$nom, $prenom, $tel_chiffre, $email_chiffre, $mdp_hash]);

					} elseif ($table === "inscrit"){
						$req = $pdo->prepare("
							INSERT INTO inscrit (nom, prenom, tel, emel, mdphasher, STATUT)
							VALUES (?, ?, ?, ?, ?, ?)
						");
						$req->execute([$nom, $prenom, $tel_chiffre, $email_chiffre, $mdp_hash, $statut]);
					} else {
						$req = $pdo->prepare("
							INSERT INTO administration (tel, emel, mdphasher, STATUT)
							VALUES (?, ?, ?, ?)
						");
						$req->execute([$tel_chiffre, $email_chiffre, $mdp_hash, $statut]);

					header("Location: ../accueil.php");
					exit;
					echo "Ajout du compte bien effectué !";

				}

			}
		}
}



?>