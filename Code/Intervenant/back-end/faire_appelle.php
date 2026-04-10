<?php
require_once(dirname(__DIR__).'/../back-end/connexion.php');

$requete = $pdo->prepare('SELECT ID,nom,prenom,classe, presence 
from inscrit, inscription 
where inscrit.id = inscription.id_inscrit ');
$requete->execute();
$eleves = $requete->fetchAll();
?>
