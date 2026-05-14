<?php
// Vérifier si un ID est passé
$id = $_GET['id'] ?? null;

if ($id === null) {

    // Pas de statut à charger
    $statut = ['libelle' => 'animateur'];
    $administration = false;

    // Charger les animateurs
    $reqPersonnes = $pdo->query("
        SELECT id, nom, prenom, emel, 'animateur' AS table_name
        FROM animateur
    ");
    $personnes = $reqPersonnes->fetchAll();

} else {

    // Charger le statut
    $reqStatut = $pdo->prepare("SELECT * FROM statut WHERE id = ?");
    $reqStatut->execute([$id]);
    $statut = $reqStatut->fetch();

    $administration = in_array($statut['libelle'], [
        'gestionnaireAnimation',
        'viescolaire',
        'administration'
    ]);

    // Charger les personnes ayant ce statut
    $reqPersonnes = $pdo->prepare("
    SELECT id, nom, prenom, emel, 'inscrit' AS table_name
    FROM inscrit
    WHERE STATUT = ?

    UNION 

    SELECT id, '' AS nom, '' AS prenom, emel, 'administration' AS table_name
    FROM administration
    WHERE STATUT = ?
");

    $reqPersonnes->execute([$id, $id]);
    $personnes = $reqPersonnes->fetchAll();
	
	foreach ($personnes as &$p) {
		if (isset($p['nom'])) {
			$nom_dechiffre = decryptData($p['nom']);
			$p['nom'] = $nom_dechiffre !== null ? $nom_dechiffre : $p['nom'];
		}

		if (isset($p['prenom'])) {
			$prenom_dechiffre = decryptData($p['prenom']);
			$p['prenom'] = $prenom_dechiffre !== null ? $prenom_dechiffre : $p['prenom'];
		}

		if (isset($p['emel'])) {
			$email_dechiffre = decryptData($p['emel']);
			$p['emel'] = $email_dechiffre !== null ? $email_dechiffre : $p['emel'];
		}
}
unset($p);
}


try {
    $query = $pdo->query("SELECT * FROM statut");
    $stat = $query->fetchAll();
} catch (PDOException $e) {
    $stat = [];
}
?>