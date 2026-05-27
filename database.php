<?php
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$db_file = __DIR__ . '/data/database.sqlite';
$db_dir = dirname($db_file);

if (!is_dir($db_dir)) {
    mkdir($db_dir, 0755, true);
}

try {
    $pdo = new PDO('sqlite:' . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create tables
    $pdo->exec("CREATE TABLE IF NOT EXISTS servers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT UNIQUE,
        port INTEGER DEFAULT 7777,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        status TEXT DEFAULT 'offline'
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS players (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        server_name TEXT,
        player_name TEXT,
        join_time DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS logs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        server_name TEXT,
        action TEXT,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// API endpoints
if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    switch ($_GET['action']) {
        case 'add_server':
            $stmt = $pdo->prepare("INSERT OR IGNORE INTO servers (name, port) VALUES (?, ?)");
            $stmt->execute([$_POST['name'] ?? 'server', $_POST['port'] ?? 7777]);
            echo json_encode(['success' => true]);
            break;
        
        case 'list_servers':
            $stmt = $pdo->query("SELECT * FROM servers");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;
    }
    exit;
}