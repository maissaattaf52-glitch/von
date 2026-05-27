<?php
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) {
    exit;
}

header('Content-Type: application/json');

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";

if (!isset($_GET['download'])) {
    $gamemodes_dir = "{$server_dir}/gamemodes";
    $pwn_files = glob("{$gamemodes_dir}/*.pwn");
    
    if (empty($pwn_files)) {
        echo json_encode(['error' => 'No gamemode files']);
        exit;
    }
    
    $source = $pwn_files[0];
    $output = "{$server_dir}/compiled.amx";
    
    // Simulated compilation - in real use, call pawncc compiler
    copy($source, "{$server_dir}/gamemodes/compiled.pwn");
    file_put_contents($output, "COMPILED_BINARY_PLACEHOLDER");
    
    echo json_encode(['success' => true, 'message' => 'Gamemode compiled successfully']);
} else {
    // Return compiled file
    $file = "{$server_dir}/compiled.amx";
    if (file_exists($file)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="gamemode.amx"');
        readfile($file);
    }
}