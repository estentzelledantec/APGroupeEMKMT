<?php
require_once(dirname(__DIR__).'/../back-end/connexion.php');

$stmt = $pdo->prepare("
SELECT * 
FROM animation");
$stmt->execute();
$fetchedData = $stmt->fetchAll(PDO::FETCH_ASSOC);