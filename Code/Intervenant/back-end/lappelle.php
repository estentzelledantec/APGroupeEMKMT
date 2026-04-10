<?php
require_once(dirname(__DIR__).'/../back-end/base.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // on a toujours besoin de $id_animation, on le sort du if
    $id_animation = $_POST['id_animation'];
    if (isset($_POST['presence'])) {
        $presences = array_keys($_POST['presence']) ?? [];
    }

    // on met bien tout à 0
    $sql = "UPDATE inscription
        SET presence = 0
        WHERE id_animation=?";
    $stmt = $pdo->prepare($sql);

    $params = [$id_animation];
    $result = $stmt->execute($params);

    // on fait la 2ème partie uniquement quand il y a des présences
    if (isset($_POST['presence']) && isset($_POST['id_animation'])) {
        $in  = str_repeat('?,', count($presences) - 1) . '?';
        $sql = "UPDATE inscription
            SET presence = 1
            WHERE id_animation=? AND id_inscrit IN ($in)";
        $stmt = $pdo->prepare($sql);

        $params = array_merge([$id_animation], $presences);
        $result = $stmt->execute($params);
    }

    // $result existe soit à cause de la 1ère requete (cas où il n'y a aucune
    // présence) ou de la 2ème (cas où il n'y a dres présences)
    if ($result) {
        header('Location: ../appelle.php');
        exit();
    }
}
