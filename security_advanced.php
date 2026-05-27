<?php
// Advanced Security Manager
require_once __DIR__ . '/config.php';

function log_security_event($event, $details = '') {
    $log = date('Y-m-d H:i:s') . " - $event - $details - IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n";
    file_put_contents(__DIR__ . '/logs/security.log', $log, FILE_APPEND);
}

function check_brute_force($username, $limit = 5, $window = 300) {
    $attempts_file = __DIR__ . "/logs/brute_{$username}.json";
    $attempts = file_exists($attempts_file) ? json_decode(file_get_contents($attempts_file), true) : [];
    
    $now = time();
    $recent = array_filter($attempts, fn($t) => $now - $t < $window);
    
    if (count($recent) >= $limit) {
        log_security_event('BRUTE_FORCE_BLOCKED', $username);
        return false;
    }
    return true;
}

function record_login_attempt($username, $success) {
    $attempts_file = __DIR__ . "/logs/brute_{$username}.json";
    $attempts = file_exists($attempts_file) ? json_decode(file_get_contents($attempts_file), true) : [];
    
    if (!$success) {
        $attempts[] = time();
        file_put_contents($attempts_file, json_encode($attempts));
    } else {
        file_put_contents($attempts_file, '[]'); // Clear on success
    }
}

function validate_rcon($server_dir, $password) {
    $cfg = file_get_contents("{$server_dir}/server.cfg");
    preg_match('/rcon_password\s+(\S+)/', $cfg, $match);
    return $match[1] ?? '' === $password;
}

function encrypt_config($data) {
    return openssl_encrypt(json_encode($data), 'AES-256-CBC', $_SESSION['key'] ?? 'default_key');
}

function decrypt_config($data) {
    return json_decode(openssl_decrypt($data, 'AES-256-CBC', $_SESSION['key'] ?? 'default_key'), true);
}

function secure_headers() {
    header('X-Frame-Options: DENY');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}
?>