<?php
// Fonction pour la page Animations
function obtenirToutesLesInscriptions($bdd) {
    if (!$bdd) return []; 
    $requete = $bdd->prepare("
        SELECT u.nom, u.prenom, u.classe, a.Titre, a.DateHeureDeb, i.id_animation, i.id_inscrit, i.presence
        FROM inscription i
        INNER JOIN inscrit u ON i.id_inscrit = u.ID
        INNER JOIN animation a ON i.id_animation = a.ID
        ORDER BY a.DateHeureDeb DESC
    ");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer les statistiques globales
function obtenirStatsGlobales($bdd) {
    if (!$bdd) return ['total'=>0, 'presents'=>0, 'absents'=>0, 'pourcentage'=>0];
    
    $total = $bdd->query("SELECT COUNT(*) FROM inscription")->fetchColumn();
    $presents = $bdd->query("SELECT COUNT(*) FROM inscription WHERE presence = 1")->fetchColumn();
    $absents = $total - $presents;
    $pourcentage = ($total > 0) ? round(($presents / $total) * 100) : 0;

    return [
        'total' => $total,
        'presents' => $presents,
        'absents' => $absents,
        'pourcentage' => $pourcentage
    ];
}

// Fonction pour la page Statistiques (Top 3)
function obtenirAnimationsPopulaires($bdd) {
    if (!$bdd) return [];
    $req = $bdd->prepare("
        SELECT a.Titre, COUNT(*) as nb_inscrits 
        FROM inscription i 
        INNER JOIN animation a ON i.id_animation = a.ID 
        GROUP BY a.Titre 
        ORDER BY nb_inscrits DESC 
        LIMIT 3
    ");
    $req->execute();
    return $req->fetchAll();
}
?>