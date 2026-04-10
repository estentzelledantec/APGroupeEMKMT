<?php
if (!isset($_POST['id_animation'])) die("ID manquant");

$id = intval($_POST['id_animation']);
$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "root", "");

$pdo->prepare("DELETE FROM inscription WHERE id_animation = ?")->execute([$id]);
$pdo->prepare("DELETE FROM animation WHERE ID = ?")->execute([$id]);

header("Location: ../accueil.php");
exit();