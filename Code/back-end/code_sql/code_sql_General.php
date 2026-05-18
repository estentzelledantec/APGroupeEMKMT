<?php
// ========================================================================
// REQUÊTES SQL GÉNÉRALES (Authentification Multi-Tables)
// ========================================================================

if (isset($pdo) && isset($email)) {

    // --- PARTIE A : Recherche dans l'Administration ---
    $stmt_admin = $pdo->prepare("SELECT * FROM administration WHERE emel = :email");
    $stmt_admin->execute(['email' => $email]);
    $user_admin = $stmt_admin->fetch();

    // --- PARTIE B : Recherche chez les Élèves ---
    $stmt_eleve = $pdo->prepare("SELECT * FROM inscrit WHERE emel = :email");
    $stmt_eleve->execute(['email' => $email]);
    $user_eleve = $stmt_eleve->fetch();

    // --- PARTIE C : Recherche chez les Animateurs ---
    $stmt_anim = $pdo->prepare("SELECT * FROM animateur WHERE emel = :email");
    $stmt_anim->execute(['email' => $email]);
    $user_anim = $stmt_anim->fetch();

    // --- PARTIE D : Vérification Animation en cours (pour les intervenants) ---
    // Cette requête n'est lancée que si on a trouvé un animateur
    $stmt_actu = $pdo->prepare('SELECT * FROM animation 
                                WHERE DateHeureDeb < NOW() AND DateHeureFin > NOW()');
    $stmt_actu->execute();
    $animation_en_cours = $stmt_actu->fetch();
}
?>