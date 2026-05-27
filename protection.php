<?php
// Complete Protection System
session_start();
require_once __DIR__ . '/config.php';

secure_headers();

// Rate limiting
if (!rate_limit('request_' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'), 100, 60)) {
    http_response_code(429);
    die('Too many requests');
}

// Block known bad IPs
$blocked_ips = file_exists(__DIR__ . '/logs/blocked_ips.txt') ? 
    file(__DIR__ . '/logs/blocked_ips.txt', FILE_IGNORE_NEW_LINES) : [];
    
if (in_array($_SERVER['REMOTE_ADDR'], $blocked_ips)) {
    http_response_code(403);
    die('Access denied');
}

// Check for malicious patterns in requests
$magic_quotes = ini_get('magic_quotes_gpc');
$input = $_GET + $_POST + $_COOKIE;

function detect_attack($input) {
    $patterns = [
        '/(UNION|SELECT|INSERT|UPDATE|DELETE|DROP|EXEC|EXECUTE)/i' => 'SQL Injection',
        '/(<script|javascript:|onload=|onerror=)/i' => 'XSS',
        '/(\.\.\/|\/\.\.\/)/i' => 'Path Traversal',
        '/(eval\(|system\(|exec\(|passthru\()/i' => 'Code Injection',
    ];
    
    foreach ($input as $key => $value) {
        if (is_string($value)) {
            foreach ($patterns as $pattern => $attack) {
                if (preg_match($pattern, $value)) {
                    return $attack;
                }
            }
        }
    }
    return false;
}

$attack = detect_attack($input);
if ($attack) {
    log_security_event('ATTACK_BLOCKED', $attack);
    $_SESSION['blocked'] = true;
    header('Location: blocked.php');
    exit;
}