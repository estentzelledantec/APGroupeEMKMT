<?php
// On empêche toute sortie de texte avant le fichier
ob_start();
session_start();

// 1. Connexion
try {
    $bdd = new PDO('mysql:host=localhost;dbname=animationsfld;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// 2. Importation de la logique
include '../../back-end/code_sql/code_sql_VieScolaire.php';

// 3. Récupération des données
if (function_exists('obtenirElevesAbsents')) {
    $absents = obtenirElevesAbsents($bdd);
} else {
    die("La fonction SQL est introuvable.");
}

// --- COMMANDE DE TÉLÉCHARGEMENT FORCÉ ---
// On vide le tampon pour être sûr qu'il n'y a pas d'espaces blancs
ob_end_clean();

// On définit le type de fichier (Excel)
header('Content-Type: application/vnd.ms-excel');
// "attachment" force le navigateur à ouvrir la boîte "Enregistrer sous"
header('Content-Disposition: attachment; filename="liste_absences_viescolaire.xls"');
header('Cache-Control: max-age=0');
header('Pragma: no-cache');

// 4. Génération du tableau format Excel
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1">
    <tr style="background-color: #7a98cf; color: white;">
        <th>Nom</th>
        <th>Prénom</th>
        <th>Classe</th>
        <th>Animation</th>
        <th>Date/Heure</th>
    </tr>
    <?php if (!empty($absents)): ?>
        <?php foreach ($absents as $eleve): ?>
        <tr>
            <td><?php echo htmlspecialchars($eleve['nom']); ?></td>
            <td><?php echo htmlspecialchars($eleve['prenom']); ?></td>
            <td><?php echo htmlspecialchars($eleve['classe']); ?></td>
            <td><?php echo htmlspecialchars($eleve['Titre']); ?></td>
            <td><?php echo htmlspecialchars($eleve['DateHeureDeb']); ?></td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
<?php
exit();