<?php
$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "administrateur", "Btssio2017");
require_once __DIR__ . '/crypto.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$id = $_POST['ID'];
    $table  = $_POST['table'];
    $prenom = $_POST['prenom'];
    $nom    = $_POST['nom'];
    $tel    = encryptData($_POST['tel']);
    $email  = encryptData($_POST['email']);
    $mdp    = $_POST['mot_de_passe'];



	// Hash du mot de passe seulement si modifié
	$mdp_hash = !empty($mdp) ? password_hash($mdp, PASSWORD_DEFAULT) : null;
	
	$sql = "UPDATE $table SET nom=?, prenom=?, tel=?, emel=?";
    $params = [$nom, $prenom, $tel, $email];
	
	if ($mdp_hash) {
        $sql .= ", mdphasher=?";
        $params[] = $mdp_hash;
    }

    $sql .= " WHERE ID=?";
    $params[] = $id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
	
	header("Location: ../accueil.php");
	exit;

	echo "Modification réussie !";
}
?>
