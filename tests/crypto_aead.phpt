--TEST--
Check for libsodium AEAD
--SKIPIF--
<?php
if (!extension_loaded("libsodium")) print "skip extension not loaded";
if (!defined('SODIUM_CRYPTO_AEAD_AES256GCM_NPUBBYTES')) print "skip libsodium without AESGCM";
?>
--FILE--
<?php
echo "aead_chacha20poly1305:\n";

$msg = random_bytes(random_int(0, 1000));
$nonce = random_bytes(SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_NPUBBYTES);
$key = random_bytes(SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_KEYBYTES);
$ad = random_bytes(random_int(0, 1000));

$ciphertext = sodium_crypto_aead_chacha20poly1305_encrypt($msg, $ad, $nonce, $key);
$msg2 = sodium_crypto_aead_chacha20poly1305_decrypt($ciphertext, $ad, $nonce, $key);
var_dump($ciphertext !== $msg);
var_dump($msg === $msg2);
var_dump(sodium_crypto_aead_chacha20poly1305_decrypt($ciphertext, 'x' . $ad, $nonce, $key));
try {
    // Switched order
    $msg2 = sodium_crypto_aead_chacha20poly1305_decrypt($ciphertext, $ad, $key, $nonce);
    var_dump(false);
} catch (SodiumException $ex) {
    var_dump(true);
}

echo "aead_chacha20poly1305_ietf:\n";

if (SODIUM_LIBRARY_MAJOR_VERSION > 7 ||
    (SODIUM_LIBRARY_MAJOR_VERSION == 7 &&
     SODIUM_LIBRARY_MINOR_VERSION >= 6)) {
    $msg = random_bytes(random_int(0, 1000));
    $nonce = random_bytes(SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_IETF_NPUBBYTES);
    $key = random_bytes(SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_IETF_KEYBYTES);
    $ad = random_bytes(random_int(0, 1000));

    $ciphertext = sodium_crypto_aead_chacha20poly1305_ietf_encrypt($msg, $ad, $nonce, $key);
    $msg2 = sodium_crypto_aead_chacha20poly1305_ietf_decrypt($ciphertext, $ad, $nonce, $key);
    var_dump($ciphertext !== $msg);
    var_dump($msg === $msg2);
    var_dump(sodium_crypto_aead_chacha20poly1305_ietf_decrypt($ciphertext, 'x' . $ad, $nonce, $key));
    try {
        // Switched order
        $msg2 = sodium_crypto_aead_chacha20poly1305_ietf_decrypt($ciphertext, $ad, $key, $nonce);
        var_dump(false);
    } catch (SodiumException $ex) {
        var_dump(true);
    }
} else {
    var_dump(true);
    var_dump(true);
    var_dump(false);
    var_dump(true);
}

echo "aead_xchacha20poly1305_ietf:\n";

if (SODIUM_LIBRARY_MAJOR_VERSION > 9 ||
    (SODIUM_LIBRARY_MAJOR_VERSION == 9 &&
     SODIUM_LIBRARY_MINOR_VERSION >= 4)) {
    $msg = random_bytes(random_int(0, 1000));
    $nonce = random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);
    $key = random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_KEYBYTES);
    $ad = random_bytes(random_int(0, 1000));

    $ciphertext = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($msg, $ad, $nonce, $key);
    $msg2 = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($ciphertext, $ad, $nonce, $key);
    var_dump($ciphertext !== $msg);
    var_dump($msg === $msg2);
    var_dump(sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($ciphertext, 'x' . $ad, $nonce, $key));
    try {
        // Switched order
        $msg2 = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($ciphertext, $ad, $key, $nonce);
        var_dump(false);
    } catch (SodiumException $ex) {
        var_dump(true);
    }
} else {
    var_dump(true);
    var_dump(true);
    var_dump(false);
    var_dump(true);
}

echo "aead_aes256gcm:\n";

$msg = random_bytes(random_int(0, 1000));
$nonce = random_bytes(SODIUM_CRYPTO_AEAD_AES256GCM_NPUBBYTES);
$key = random_bytes(SODIUM_CRYPTO_AEAD_AES256GCM_KEYBYTES);
$ad = random_bytes(random_int(0, 1000));

if (sodium_crypto_aead_aes256gcm_is_available()) {
    $ciphertext = sodium_crypto_aead_aes256gcm_encrypt($msg, $ad, $nonce, $key);
    $msg2 = sodium_crypto_aead_aes256gcm_decrypt($ciphertext, $ad, $nonce, $key);
    var_dump($ciphertext !== $msg);
    var_dump($msg === $msg2);
    var_dump(sodium_crypto_aead_aes256gcm_decrypt($ciphertext, 'x' . $ad, $nonce, $key));
    try {
        // Switched order
        $msg2 = sodium_crypto_aead_aes256gcm_decrypt($ciphertext, $ad, $key, $nonce);
        var_dump(false);
    } catch (SodiumException $ex) {
        var_dump(true);
    }
} else {
    var_dump(true);
    var_dump(true);
    var_dump(false);
    var_dump(true);
}
?>
--EXPECT--
aead_chacha20poly1305:
bool(true)
bool(true)
bool(false)
bool(true)
aead_chacha20poly1305_ietf:
bool(true)
bool(true)
bool(false)
bool(true)
aead_xchacha20poly1305_ietf:
bool(true)
bool(true)
bool(false)
bool(true)
aead_aes256gcm:
bool(true)
bool(true)
bool(false)
bool(true)
