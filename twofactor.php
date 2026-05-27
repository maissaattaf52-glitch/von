<?php
// Two-Factor Authentication (TOTP)
require_once __DIR__ . '/config.php';

function generate_secret() {
    return str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
}

function verify_totp($secret, $code) {
    $time_slice = floor(time() / 30);
    $expected = substr(md5($secret . $time_slice), 0, 6);
    return $code == $expected;
}

function enable_2fa($username) {
    $secret = generate_secret();
    $_SESSION['2fa_secret'] = $secret;
    return $secret;
}

function check_2fa($code) {
    return verify_totp($_SESSION['2fa_secret'] ?? '', $code);
}
?>