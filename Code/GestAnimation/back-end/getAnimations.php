<?php
$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "root", "");

$sql = "
SELECT 
    a.ID, 
    a.Titre, 
    a.DateHeureDeb, 
    a.commentaire,
    a.nbreMin,
    a.nbreMax,
    t.libelle AS theme,
    COUNT(i.id_inscrit) AS nbInscrits
FROM animation a
JOIN theme t ON a.idTheme = t.ID
JOIN inscription i ON a.ID = i.id_animation
GROUP BY a.ID
ORDER BY a.DateHeureDeb ASC
";

$stmt = $pdo->query($sql);
return $stmt->fetchAll(PDO::FETCH_ASSOC);