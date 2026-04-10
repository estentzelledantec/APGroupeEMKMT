<?php
// ========================================================================
// BOÎTE À OUTILS DE CRYPTOGRAPHIE (Protection des données RGPD)
// Utilisation de l'extension native PHP : Libsodium
// ========================================================================

// ========================================================================
// 1. DÉFINITION DE LA CLÉ SECRÈTE GLOBALE
// ========================================================================
// Libsodium exige une clé d'exactement 32 octets.
// Pour obtenir cette taille parfaite à partir de la phrase secrète, on utilise : hash('sha256').
// Le paramètre "true" renvoie la clé en format binaire brut.
define('CLE_SECRETE_PROJET', hash('sha256', 'CleSecretePROJETBTSSIO2026', true));

// ========================================================================
// 2. FONCTION POUR CHIFFRER UNE DONNÉE (Avant insertion en BDD)
// ========================================================================
function chiffrer_donnee($message_clair) {
    // 1. Création du "Nonce"
    // C'est une valeur aléatoire unique générée pour CHAQUE chiffrement. 
    // Ça empêche deux élèves avec le même prénom d'avoir la même chaîne chiffrée.
    $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    
    // 2. Chiffrement du message avec la clé secrète et le nonce
    $texte_chiffre = sodium_crypto_secretbox($message_clair, $nonce, CLE_SECRETE_PROJET);
    //test12948156156156
    // 3. Préparation pour la Base de Données
    // On "colle" le nonce devant le texte chiffré.
    // On encode tout en Base64 pour transformer les caractères binaires illisibles en texte classique compatible avec un champ VARCHAR.
    return base64_encode($nonce . $texte_chiffre);
}

// ========================================================================
// 3. FONCTION POUR DÉCHIFFRER UNE DONNÉE (Lecture depuis la BDD)
// ========================================================================
function dechiffrer_donnee($texte_base64) {
    // 1. On redécode le texte Base64 pour retrouver les données binaires d'origine
    $donnees_brutes = base64_decode($texte_base64, true);
    
    // Sécurité : Si le décodage échoue ou si la chaîne est trop courte pour contenir un nonce, on arrête.
    if ($donnees_brutes === false || strlen($donnees_brutes) <= SODIUM_CRYPTO_SECRETBOX_NONCEBYTES) {
        return "Erreur_Decodage"; 
    }
    
    // 2. Séparation des éléments
    // On récupère les 24 premiers octets qui correspondent au nonce
    $nonce = substr($donnees_brutes, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    // On récupère tout le reste qui correspond au véritable texte chiffré
    $texte_chiffre = substr($donnees_brutes, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    
    // 3. Tentative de déchiffrement avec la clé secrète
    $message_dechiffre = sodium_crypto_secretbox_open($texte_chiffre, $nonce, CLE_SECRETE_PROJET);
    
    // 4. Gestion de l'erreur de clé
    // Si la clé a changé entre le moment du chiffrement et aujourd'hui, Libsodium bloque et renvoie "false".
    if ($message_dechiffre === false) {
        return "Erreur_Dechiffrement_Cle_Invalide";
    }
    
    // 5. Tout s'est bien passé, on retourne le texte en clair
    return $message_dechiffre;
}
?>