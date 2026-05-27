<?php
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";
$log_entry = [
    'timestamp' => date('Y-m-d H:i:s'),
    'server' => $server_name,
    'action' => $_GET['action'] ?? '',
    'ip' => $_SERVER['REMOTE_ADDR']
];

$log_file = __DIR__ . "/logs/activity.log";
file_put_contents($log_file, json_encode($log_entry) . "\n", FILE_APPEND);

function get_activity_logs($limit = 100) {
    $log_file = __DIR__ . "/logs/activity.log";
    if (!file_exists($log_file)) return [];
    
    $lines = array_slice(file($log_file), -$limit);
    return array_map('json_decode', $lines);
}