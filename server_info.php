<?php
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) {
    exit;
}

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";

function get_disk_usage($path) {
    $total_size = 0;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $file) {
        $total_size += $file->getSize();
    }
    return $total_size;
}

$usage = get_disk_usage($server_dir);
$players = get_player_count($server_name);
$status = get_server_status($server_name);

echo json_encode([
    'server_name' => $server_name,
    'status' => $status,
    'players' => $players,
    'disk_usage_mb' => round($usage / 1024 / 1024, 2),
    'ip' => $_SERVER['SERVER_ADDR'] ?? '127.0.0.1',
    'port' => 7777
]);