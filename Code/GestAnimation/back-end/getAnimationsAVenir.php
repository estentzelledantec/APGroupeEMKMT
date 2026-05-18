<?php
$pdo = new PDO("mysql:host=localhost;dbname=animationsfld;charset=utf8", "root", "");

$sql = "
SELECT 
    animation.ID, 
    animation.Titre, 
    animation.DateHeureDeb, 
    animation.commentaire,
    animation.nbreMin,
    animation.nbreMax,
    theme.libelle AS theme,
    COUNT(inscription.id_inscrit) AS nbInscrits
FROM animation
JOIN theme ON animation.idTheme = theme.ID
LEFT JOIN inscription ON animation.ID = inscription.id_animation
WHERE animation.DateHeureDeb >= NOW()
GROUP BY animation.ID
ORDER BY animation.DateHeureDeb ASC
";

$stmt = $pdo->query($sql);
return $stmt->fetchAll(PDO::FETCH_ASSOC);
?>