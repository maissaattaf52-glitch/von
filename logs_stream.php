<?php
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) {
    exit;
}

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";

// Send log updates
while (true) {
    $log_file = "{$server_dir}/server_log.txt";
    if (file_exists($log_file)) {
        $log = file_get_contents($log_file);
        echo "data: " . base64_encode($log) . "\n\n";
    } else {
        echo "data: " . base64_encode("No log") . "\n\n";
    }
    ob_flush();
    flush();
    sleep(2);
}