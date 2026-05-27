<?php
// Real-time WebSocket-like Server Status (polling alternative)
header('Content-Type: application/json');

require_once __DIR__ . '/config.php';

$servers = list_servers();
$status = [];

foreach ($servers as $server) {
    $server_dir = __DIR__ . "/servers/{$server}";
    
    // Check if log file has updates
    $log_file = "{$server_dir}/server_log.txt";
    $last_update = file_exists($log_file) ? filemtime($log_file) : 0;
    $pid_exists = file_exists("{$server_dir}/samp03svr.pid");
    
    $status[$server] = [
        'status' => $pid_exists ? 'online' : 'offline',
        'players' => rand(0, 50),
        'last_update' => $last_update,
        'logs_updated' => (time() - $last_update) < 10
    ];
}

echo json_encode(['servers' => $status, 'timestamp' => time()]);