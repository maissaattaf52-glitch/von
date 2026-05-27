<?php
// Server Configuration Validator
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";

function validate_server_cfg($cfg_file) {
    $errors = [];
    $lines = file($cfg_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    $required = ['bind', 'hostname', 'gamemode0', 'rcon_password'];
    $found = [];
    
    foreach ($lines as $line) {
        $key = strtok($line, ' ');
        $found[] = $key;
    }
    
    foreach ($required as $req) {
        if (!in_array($req, $found)) {
            $errors[] = "Missing required config: $req";
        }
    }
    
    // Validate port format
    foreach ($lines as $line) {
        if (strpos($line, 'bind') === 0) {
            if (!preg_match('/:(\d+)$/', $line, $m) || $m[1] > 65535) {
                $errors[] = "Invalid port in bind directive";
            }
        }
    }
    
    return $errors;
}

$validation = validate_server_cfg("{$server_dir}/server.cfg");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>التحقق من الإعدادات</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .val-box { background:#16213e; padding:20px; border-radius:10px; }
        .error { color:#f00; padding:5px; margin:5px 0; }
        .success { color:#0f0; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="val-box">
        <h2>التحقق من إعدادات الخادم</h2>
        <?php if (empty($validation)): ?>
        <p class="success">جميع الإعدادات صالحة!</p>
        <?php else: ?>
        <?php foreach ($validation as $error): ?>
        <p class="error">خطأ: <?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>