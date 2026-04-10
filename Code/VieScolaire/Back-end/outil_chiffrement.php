<?php
/**
 * BOÎTE À OUTILS DE CRYPTOGRAPHIE (Protection des données RGPD)
 * * Ce fichier utilise Libsodium, la bibliothèque de référence moderne en PHP 
 * pour le chiffrement symétrique (une seule clé pour chiffrer et déchiffrer).
 */

// ========================================================================
// 1. GÉNÉRATION DE LA CLÉ MAÎTRESSE
// ========================================================================

/**
 * Libsodium exige une clé d'exactement 32 octets.
 * Nous utilisons hash('sha256') sur une phrase secrète pour garantir :
 * 1. La taille exacte requise (256 bits / 32 octets).
 * 2. Une clé complexe impossible à deviner.
 * Le paramètre 'true' génère une sortie binaire brute.
 */
define('CLE_SECRETE_PROJET', hash('sha256', 'CleSecretePROJETBTSSIO2026', true));


// ========================================================================
// 2. FONCTION DE CHIFFREMENT (Écriture vers la BDD)
// ========================================================================

/**
 * Transforme un texte clair (ex: '1') en une chaîne sécurisée illisible.
 * @param string $message_clair La donnée à protéger.
 * @return string La donnée chiffrée encodée en Base64.
 */
function chiffrer_donnee($message_clair) {
    
    // a. Création du "Nonce" (Number used once)
    // C'est un sel aléatoire de 24 octets généré pour CHAQUE opération.
    // Sécurité : même si on chiffre dix fois le chiffre '1', le résultat sera différent à chaque fois.
    $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    
    // b. Chiffrement Secretbox
    // Utilise l'algorithme XSalsa20-Poly1305 (très rapide et hautement sécurisé).
    $texte_chiffre = sodium_crypto_secretbox($message_clair, $nonce, CLE_SECRETE_PROJET);
    
    // c. Formatage pour le stockage
    // On concatène (colle) le nonce au début du texte chiffré car on en aura besoin pour déchiffrer.
    // On utilise base64_encode pour que le résultat binaire puisse être stocké dans un champ TEXT/VARCHAR.
    return base64_encode($nonce . $texte_chiffre);
}


// ========================================================================
// 3. FONCTION DE DÉCHIFFREMENT (Lecture depuis la BDD)
// ========================================================================

/**
 * Transforme la chaîne stockée en BDD en texte lisible par PHP.
 * @param string $texte_base64 La chaîne récupérée de la base.
 * @return string|false Le texte d'origine ou une erreur.
 */
function dechiffrer_donnee($texte_base64) {
    
    // a. Décodage du format de stockage
    $donnees_brutes = base64_decode($texte_base64, true);
    
    // Sécurité : vérification que la donnée n'est pas corrompue
    if ($donnees_brutes === false || strlen($donnees_brutes) <= SODIUM_CRYPTO_SECRETBOX_NONCEBYTES) {
        return "Erreur_Format_Donnee";
    }
    
    // b. Extraction des composants
    // On récupère les 24 premiers octets (le nonce)...
    $nonce = substr($donnees_brutes, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    // ...et le reste de la chaîne (le message chiffré).
    $texte_chiffre = substr($donnees_brutes, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    
    // c. Ouverture de la "Secretbox"
    // On tente de déchiffrer avec la clé du projet.
    $message_dechiffre = sodium_crypto_secretbox_open($texte_chiffre, $nonce, CLE_SECRETE_PROJET);
    
    // d. Validation de l'intégrité
    // Si la donnée a été modifiée manuellement en BDD ou si la clé est mauvaise, Libsodium renvoie false.
    if ($message_dechiffre === false) {
        return "Donnée corrompue ou clé invalide";
    }
    
    return $message_dechiffre;
}
?>