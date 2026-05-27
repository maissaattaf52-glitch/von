<?php
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) {
    exit;
}

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";
$log_file = "{$server_dir}/server_log.txt";

echo file_exists($log_file) ? file_get_contents($log_file) : 'No logs available';