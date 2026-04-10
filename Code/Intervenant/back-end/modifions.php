
<?php
require_once(dirname(__DIR__).'/../back-end/base.php');
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM animation WHERE ID = ? AND idAnimateur = ?");
$stmt->execute([$id,$_SESSION['user_id']]);
$animation = $stmt->fetch(PDO::FETCH_ASSOC);