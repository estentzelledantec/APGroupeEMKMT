<?php
$pdo = new PDO(
    "mysql:host=localhost;dbname=animationsfld;charset=utf8",
    "root",
    "",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

/* Taux de presence */
$stmt = $pdo->query("
    SELECT 
        COUNT(*) AS totalInscrits,
        SUM(presence) AS totalPresents
    FROM inscription
");

$presence = $stmt->fetch(PDO::FETCH_ASSOC);

$tauxPresence = 0;

if ($presence['totalInscrits'] > 0) {
    $tauxPresence = (
        $presence['totalPresents']
        / $presence['totalInscrits']
    ) * 100;
}

/* Top 5 des animations */
$stmt = $pdo->query("
    SELECT 
        a.Titre,
        COUNT(i.id_inscrit) AS nbInscrits
    FROM animation a
    LEFT JOIN inscription i ON a.ID = i.id_animation
    GROUP BY a.ID
    ORDER BY nbInscrits DESC
    LIMIT 5
");

$topAnimations = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Heures les plus fréquente */
$stmt = $pdo->query("
    SELECT 
        HOUR(DateHeureDeb) AS heure,
        COUNT(i.id_inscrit) AS nbInscrits
    FROM animation a
    LEFT JOIN inscription i ON a.ID = i.id_animation
    GROUP BY heure
    ORDER BY nbInscrits DESC
");

$heures = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Thèmes les plus populaire */
$stmt = $pdo->query("
    SELECT 
        t.libelle AS theme,
        COUNT(i.id_inscrit) AS nbInscrits
    FROM animation a
    LEFT JOIN inscription i ON a.ID = i.id_animation
    LEFT JOIN theme t ON a.idTheme = t.ID
    GROUP BY t.ID
    ORDER BY nbInscrits DESC
");

$themes = $stmt->fetchAll(PDO::FETCH_ASSOC);

return [
    "tauxPresence" => $tauxPresence,
    "topAnimations" => $topAnimations,
    "heures" => $heures,
    "themes" => $themes
];
?>