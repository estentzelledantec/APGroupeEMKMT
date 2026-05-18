<?php
$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "administrateur", "Btssio2017");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
require_once __DIR__ . '/crypto.php';

$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $prenom = $_POST["prenom"];
    $nom = $_POST["nom"];
    $tel = $_POST["telephone"];
    $email = $_POST["email"];
    $mdp = $_POST["mot_de_passe"];
    $cat = $_POST["categorie"];
    $statut = 0;

    // Choix de la table
    if ($cat === "eleve") { $table = "inscrit"; $statut = 1; }
    elseif ($cat === "gestionnaireAnimation") { $table = "administration"; $statut = 2; }
    elseif ($cat === "viescolaire") { $table = "administration"; $statut = 3; }
    elseif ($cat === "administration") { $table = "administration"; $statut = 4; }
    elseif ($cat === "professeur") { $table = "inscrit"; $statut = 5; }
    elseif ($cat === "agentregion") { $table = "inscrit"; $statut = 6; }
    elseif ($cat === "animateur") { $table = "animateur"; }

    // Vérifications
    function isValidNom($str) {
        return is_string($str) && preg_match("/^[a-zA-ZÀ-ÿ\- ]+$/", $str);
    }

   // Validation selon la table
	if ($table !== "administration") {
		if (!isValidNom($prenom)) $erreurs['prenom'] = "Prénom invalide";
		if (!isValidNom($nom)) $erreurs['nom'] = "Nom invalide";
	}

    if (!ctype_digit($tel)) $erreurs['telephone'] = "Téléphone invalide";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreurs['email'] = "Email invalide";

    function isValidMDP($mdp) {
        return preg_match('/^(?=.*[A-Z])(?=.*[0-9])(?=.*[,*?.:]).{10,}$/', $mdp);
    }

    if (!isValidMDP($mdp)) $erreurs['mot_de_passe'] = "Mot de passe invalide";

    if (empty($erreurs)) {

        $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
        $email_chiffre = encryptData($email);
        $tel_chiffre = encryptData($tel);

        try {

            if ($table === "animateur") {
                $req = $pdo->prepare("
                    INSERT INTO animateur (nom, prenom, tel, emel, mdphasher)
                    VALUES (?, ?, ?, ?, ?)
                ");
                $req->execute([$nom, $prenom, $tel_chiffre, $email_chiffre, $mdp_hash]);
            }

            elseif ($table === "inscrit") {
                $req = $pdo->prepare("
                    INSERT INTO inscrit (nom, prenom, tel, emel, mdphasher, STATUT)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                $req->execute([$nom, $prenom, $tel_chiffre, $email_chiffre, $mdp_hash, $statut]);
            }

            elseif ($table === "administration") {
                $req = $pdo->prepare("
                    INSERT INTO administration (tel, emel, mdphasher, STATUT)
                    VALUES (?, ?, ?, ?)
                ");
                $req->execute([$tel_chiffre, $email_chiffre, $mdp_hash, $statut]);
            }

            /* echo "Ajout du compte bien effectué !"; */

        } catch (PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
        }
		
		header("Location: ../accueil.php");
		exit;
    }
}
?>
