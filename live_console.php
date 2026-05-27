<?php
// Live Console with WebSocket-style updates
require_once __DIR__ . '/config.php';
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";

$last_size = $_GET['last_size'] ?? 0;
$log_file = "{$server_dir}/server_log.txt";

while (true) {
    clearstatcache();
    if (file_exists($log_file)) {
        $size = filesize($log_file);
        if ($size > $last_size) {
            $new_content = file_get_contents($log_file, false, null, $last_size, $size - $last_size);
            echo "data: " . base64_encode($new_content) . "\n\n";
            ob_flush();
            flush();
        }
    }
    sleep(1);
}