<?php
// Firewall & Security Rules Manager
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$server_name = $_GET['server'] ?? $config['default_server'];
$firewall_file = __DIR__ . "/servers/{$server_name}/firewall.rules";

$default_rules = [
    'allow 0.0.0.0/0', // Allow all
    'block 192.168.1.100', // Example block
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rules = $_POST['rules'] ?? '';
    file_put_contents($firewall_file, $rules);
}

function load_firewall_rules($file) {
    if (file_exists($file)) {
        return file_get_contents($file);
    }
    return implode("\n", $default_rules);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>جدار الحماية</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .firewall-box { background:#16213e; padding:20px; border-radius:10px; }
        textarea { width:100%; height:300px; background:#000; color:#0f0; border:1px solid #0f0; padding:10px; font-family:monospace; }
        button { padding:10px 20px; background:#aa0000; color:#fff; border:none; cursor:pointer; margin-top:10px; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="firewall-box">
        <h2>جدار الحماية - <?= htmlspecialchars($server_name) ?></h2>
        <form method="POST">
            <textarea name="rules" placeholder="قاعدة: allow/block + IP"><?= htmlspecialchars(load_firewall_rules($firewall_file)) ?></textarea>
            <button type="submit">حفظ القواعد</button>
        </form>
    </div>
</body>
</html>