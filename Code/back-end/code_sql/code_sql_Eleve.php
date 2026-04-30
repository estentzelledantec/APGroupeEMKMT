<?php
// On vérifie que la connexion existe ($bdd)
if (isset($bdd)) {

    // --- SÉCURITÉ : Initialisation des variables par défaut ---
    if (!isset($filtre_theme)) { $filtre_theme = null; }
    if (!isset($tri_date)) { $tri_date = 'ASC'; }
    
    // IMPORTANT : On synchronise avec le nom utilisé dans traiter_inscriptions.php
    // Si $id_eleve existe déjà (via traiter_inscriptions), on l'utilise, sinon on prend la session
    $id_eleve_final = $id_eleve ?? $_SESSION['user_id'] ?? null;

    // ========================================================================
    // 1. PARTIE AFFICHAGE (Lecture des données)
    // ========================================================================

    // A. Récupération des thèmes
    $req_themes = $bdd->query("SELECT ID, libelle FROM theme ORDER BY libelle ASC");
    $tous_les_themes = $req_themes->fetchAll(PDO::FETCH_ASSOC);

    // B. Requête des animations selon filtres
    $sql_anim = "SELECT a.ID, a.Titre, a.DateHeureDeb, t.libelle AS theme_nom 
                 FROM animation a 
                 INNER JOIN theme t ON a.idTheme = t.ID 
                 WHERE a.annulation = 0";
    if ($filtre_theme) { $sql_anim .= " AND a.idTheme = :id_theme"; }
    $sql_anim .= " ORDER BY a.DateHeureDeb " . $tri_date;
    
    $requete = $bdd->prepare($sql_anim);
    if ($filtre_theme) { $requete->bindValue(':id_theme', $filtre_theme, PDO::PARAM_INT); }
    $requete->execute();
    $animations = $requete->fetchAll(PDO::FETCH_ASSOC);

    // C. Informations spécifiques à l'élève connecté
    if ($id_eleve_final) {
        $req_check = $bdd->prepare("SELECT id_animation FROM inscription WHERE id_inscrit = :id");
        $req_check->execute(['id' => $id_eleve_final]);
        $liste_inscriptions = $req_check->fetchAll(PDO::FETCH_COLUMN);

        $req_profil = $bdd->prepare("SELECT nom, prenom, classe, emel FROM inscrit WHERE ID = :id");
        $req_profil->execute(['id' => $id_eleve_final]);
        $user_bdd = $req_profil->fetch(PDO::FETCH_ASSOC);

        $req_mes_inscr = $bdd->prepare("SELECT a.ID, a.Titre, a.DateHeureDeb, t.libelle AS theme_nom 
                                        FROM inscription i 
                                        INNER JOIN animation a ON i.id_animation = a.ID 
                                        INNER JOIN theme t ON a.idTheme = t.ID 
                                        WHERE i.id_inscrit = :id AND a.annulation = 0 
                                        ORDER BY a.DateHeureDeb DESC");
        $req_mes_inscr->execute(['id' => $id_eleve_final]);
        $mes_inscriptions = $req_mes_inscr->fetchAll(PDO::FETCH_ASSOC);
    }

    // ========================================================================
    // 2. PARTIE ACTIONS (Pour traiter_inscriptions.php)
    // ========================================================================
    if (isset($action) && isset($id_animation) && $id_eleve_final) {

        // --- ACTION : S'INSCRIRE ---
        if ($action === 'inscrire') {
            $req_e = $bdd->prepare("SELECT nom, prenom, classe FROM inscrit WHERE ID = :id");
            $req_e->execute(['id' => $id_eleve_final]);
            $eleve = $req_e->fetch(PDO::FETCH_ASSOC);

            if ($eleve && strlen($eleve['nom']) < 30) {
                $upd = $bdd->prepare("UPDATE inscrit SET nom = :n, prenom = :p, classe = :c WHERE ID = :id");
                $upd->execute([
                    'n' => chiffrer_donnee($eleve['nom']),
                    'p' => chiffrer_donnee($eleve['prenom']),
                    'c' => !empty($eleve['classe']) ? chiffrer_donnee($eleve['classe']) : NULL,
                    'id' => $id_eleve_final
                ]);
            }

            $verif = $bdd->prepare("SELECT COUNT(*) FROM inscription WHERE id_inscrit = :u AND id_animation = :a");
            $verif->execute(['u' => $id_eleve_final, 'a' => $id_animation]);
            if ($verif->fetchColumn() == 0) {
                $ins = $bdd->prepare("INSERT INTO inscription (id_inscrit, id_animation, presence) VALUES (:u, :a, 0)");
                $ins->execute(['u' => $id_eleve_final, 'a' => $id_animation]);
            }
        }

        // --- ACTION : SE DÉSINSCRIRE ---
        if ($action === 'desinscrire') {
            $req_v = $bdd->prepare("SELECT DateHeureDeb FROM animation WHERE ID = :a");
            $req_v->execute(['a' => $id_animation]);
            $anim_data = $req_v->fetch();
            
            if ($anim_data && time() <= strtotime('-7 days', strtotime($anim_data['DateHeureDeb']))) {
                $del = $bdd->prepare("DELETE FROM inscription WHERE id_inscrit = :u AND id_animation = :a");
                $del->execute(['u' => $id_eleve_final, 'a' => $id_animation]);
            }
        }
    }
}
?>