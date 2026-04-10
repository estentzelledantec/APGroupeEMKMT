<?php
$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "root", "");

$tel   = $_POST["telephone"];
$email = $_POST["email"];
$mdp   = $_POST["mot_de_passe"];
$cat   = $_POST["categorie"];

$sql = $pdo->prepare("SELECT ID_CAT FROM categorie WHERE LIBELLE_CATEG = ?");
$sql->execute([$cat]);
$id_cat = $sql->fetchColumn();

$req = $pdo->prepare("
    INSERT INTO article (TITRE_ART, DESCR_ART, SALAIRE_ART, ID_CAT, STATUS_ART, DATE_PROP_ART)
    VALUES (?, ?, ?, ?, 'P', NOW())
");

$req->execute([$tel, $email, $mdp, $id_cat]);

echo "Compte ajouté";