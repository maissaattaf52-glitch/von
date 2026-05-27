<?php
// Enhanced plugin management with plugin detection
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";

$plugin_info = [
    'streamer' => ['name' => 'Streamer Plugin', 'author' => 'incognitus', 'version' => '0.9.9'],
    'sscanf' => ['name' => 'sscanf', 'author' => 'maddin', 'version' => '2.9.4'],
    'filemanager' => ['name' => 'File Manager', 'author' => 'YourName', 'version' => '1.0'],
];

function check_plugin_exists($server_dir, $plugin) {
    $files = glob("{$server_dir}/plugins/*");
    foreach ($files as $file) {
        if (stripos($file, $plugin) !== false) {
            return true;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['install_plugin'])) {
    $plugin = $_POST['install_plugin'];
    if (isset($plugin_info[$plugin])) {
        // This would download from GitHub in real implementation
        $message = "سيتم تثبيت {$plugin_info[$plugin]['name']} قريباً";
    }
}
?>