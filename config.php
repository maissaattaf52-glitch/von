<?php
$config = [
    'servers_dir' => __DIR__ . '/servers',
    'default_server' => 'server1',
    'auth' => [
        'username' => 'admin',
        'password' => 'admin123'
    ]
];

function list_servers() {
    $servers_dir = __DIR__ . '/servers';
    $servers = [];
    if (is_dir($servers_dir)) {
        foreach (glob($servers_dir . '/*', GLOB_ONLYDIR) as $dir) {
            $servers[] = basename($dir);
        }
    }
    return $servers;
}

function get_server_status($server_name) {
    $pid_file = __DIR__ . "/servers/{$server_name}/samp03svr.pid";
    if (file_exists($pid_file)) {
        $pid = file_get_contents($pid_file);
        if (file_exists("/proc/{$pid}")) {
            return ['status' => 'online', 'players' => get_player_count($server_name)];
        }
    }
    return ['status' => 'offline', 'players' => 0];
}

function get_player_count($server_name) {
    return rand(0, 50);
}

function send_command($server_name, $command) {
    $response_file = __DIR__ . "/servers/{$server_name}/response.txt";
    if (file_exists($response_file)) {
        return file_get_contents($response_file);
    }
    return "لا يوجد رد من الخادم";
}
?>