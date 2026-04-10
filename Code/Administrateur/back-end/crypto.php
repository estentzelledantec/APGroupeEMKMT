<?php

const EMAIL_KEY_B64 = 'a4ogBDJm0fLvAU9rWkn74k4crlA41wfP2Z/mop/gpOQ=';

function getEmailKey(): string {
    return base64_decode(EMAIL_KEY_B64);
}

function encryptData(string $texte): string {
    $key   = getEmailKey();
    $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    $cipher = sodium_crypto_secretbox($texte, $nonce, $key);

    // On stocke nonce + cipher en base64 dans la base
    return base64_encode($nonce . $cipher);
}

function decryptData(string $stored): ?string {
    $key  = getEmailKey();
    $data = base64_decode($stored, true);

    if ($data === false || strlen($data) < SODIUM_CRYPTO_SECRETBOX_NONCEBYTES) {
        return null;
    }

    $nonce  = substr($data, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    $cipher = substr($data, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

    $plain = sodium_crypto_secretbox_open($cipher, $nonce, $key);
    if ($plain === false) {
        return null;
    }

    return $plain;
}
