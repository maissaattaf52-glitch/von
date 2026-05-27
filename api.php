<?php
header('Content-Type: application/json');

require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'status':
        $servers = list_servers();
        $status = [];
        foreach ($servers as $srv) {
            $status[$srv] = get_server_status($srv);
        }
        echo json_encode(['servers' => $status]);
        break;
    
    case 'players':
        $server_name = $_GET['server'] ?? $config['default_server'];
        echo json_encode(['players' => get_player_count($server_name)]);
        break;
    
    case 'rcon':
        $server = $_POST['server'] ?? '';
        $command = $_POST['command'] ?? '';
        echo json_encode(['response' => send_command($server, $command)]);
        break;
    
    case 'create_server':
        $server_name = $_POST['server_name'] ?? '';
        $gamemode = $_POST['gamemode'] ?? 'default';
        $rcon = $_POST['rcon_password'] ?? 'changeme';
        
        $server_dir = __DIR__ . "/servers/{$server_name}";
        if (!is_dir($server_dir)) {
            mkdir($server_dir, 0755, true);
            mkdir("{$server_dir}/gamemodes", 0755, true);
            mkdir("{$server_dir}/filterscripts", 0755, true);
            mkdir("{$server_dir}/scriptfiles", 0755, true);
            
            $cfg = "echo Executing Server...\n";
            $cfg .= "bind \"0.0.0.0:7777\"\n";
            $cfg .= "hostname {$server_name}\n";
            $cfg .= "gamemode0 {$gamemode} 1\n";
            $cfg .= "rcon_password {$rcon}\n";
            $cfg .= "filterscripts\nplugins\nannounce 1\nquery 1\n";
            file_put_contents("{$server_dir}/server.cfg", $cfg);
            
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Server exists']);
        }
        break;
    
    default:
        echo json_encode(['error' => 'Unknown action']);
}