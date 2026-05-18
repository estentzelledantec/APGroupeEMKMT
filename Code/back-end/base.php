<?php
$host    = 'localhost';
$db      = 'animationsfld';
$user    = 'root';
$pass    = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Dans back-end/base.php
try {
    // Change $pdo par $bdd ici
    $bdd = new PDO($dsn, $user, $pass, $options); // Il faut que ce soit $bdd, pas $pdo
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}