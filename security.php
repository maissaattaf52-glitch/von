<?php
// Security functions - Enhanced for Turbo Hosting
function sanitize_filename($name) {
    return preg_replace('/[^a-zA-Z0-9_.-]/', '', $name);
}

function escape_shell($cmd) {
    return escapeshellarg($cmd);
}

function verify_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function generate_csrf() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function rate_limit($key, $limit = 10, $window = 60) {
    $cache_file = __DIR__ . "/cache/{$key}.cache";
    $time = time();
    
    if (file_exists($cache_file)) {
        $data = json_decode(file_get_contents($cache_file), true);
        $requests = array_filter($data['timestamps'] ?? [], fn($t) => $time - $t < $window);
        if (count($requests) >= $limit) {
            return false;
        }
    }
    
    if (!is_dir(__DIR__ . '/cache')) {
        mkdir(__DIR__ . '/cache', 0755, true);
    }
    
    $requests[] = $time;
    file_put_contents($cache_file, json_encode(['timestamps' => $requests]));
    return true;
}

function log_security_event($event, $details = '') {
    $log_file = __DIR__ . '/logs/security.log';
    $log_entry = date('Y-m-d H:i:s') . " | " . $_SERVER['REMOTE_ADDR'] . " | {$event} | {$details}\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

function detect_ddos() {
    $requests_per_minute = $_SESSION['requests_minute'] ?? 0;
    $_SESSION['requests_minute'] = $requests_per_minute + 1;
    return $requests_per_minute > 100;
}

function validate_file_upload($file, $allowed_extensions = ['pwn', 'inc', 'txt']) {
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $size = $file['size'];
    
    if (!in_array($extension, $allowed_extensions)) {
        return false;
    }
    if ($size > 10 * 1024 * 1024) {
        return false;
    }
    return true;
}