<?php
require_once 'base.php';

// On liste tes 3 tables
$lesTables = ['administration', 'inscrit', 'animateur'];

foreach ($lesTables as $nomTable) {
    echo "--- Analyse de la table : $nomTable ---<br>";
    
    // On récupère l'ID et l'ANCIEN mot de passe (colonne mdp)
    $requeteSelection = $pdo->query("SELECT ID, mdp FROM $nomTable");
    
    while ($donnees = $requeteSelection->fetch()) {
        $idUtilisateur = $donnees['ID'];
        $ancienTexteMdp = $donnees['mdp'];

        // On génère la clé sécurisée (le Hash)
        $cleSecurisee = password_hash($ancienTexteMdp, PASSWORD_DEFAULT);

        // ON REMPLIT UNIQUEMENT LA COLONNE 'mdphasher'
        $requeteMaj = $pdo->prepare("UPDATE $nomTable SET mdphasher = :nouveau_hash WHERE ID = :id_vise");
        $requeteMaj->execute([
            'nouveau_hash' => $cleSecurisee,
            'id_vise'      => $idUtilisateur
        ]);
        
        echo "Utilisateur ID $idUtilisateur : OK (Hash généré)<br>";
    }
}
?>