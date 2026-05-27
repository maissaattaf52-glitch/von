<?php
// Ultimate IP Whitelist/Blacklist System
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";
$ip_file = "{$server_dir}/ip_filter.txt";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ip_action'])) {
    $ip = filter_var($_POST['ip_address'], FILTER_VALIDATE_IP);
    if ($ip) {
        $rule = $_POST['ip_action'] . ' ' . $ip . "\n";
        file_put_contents($ip_file, $rule, FILE_APPEND);
    }
}

function get_ip_rules($server_dir) {
    $file = "{$server_dir}/ip_filter.txt";
    return file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فلترة IPs</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .ip-box { background:#16213e; padding:20px; border-radius:10px; }
        input { padding:8px; margin:5px; background:#000; color:#fff; border:1px solid #0f0; }
        button { padding:8px 12px; background:#aa0000; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="ip-box">
        <h2>فلترة عناوين IP</h2>
        <form method="POST">
            <select name="ip_action">
                <option value="allow">السماح</option>
                <option value="block">حظر</option>
            </select>
            <input type="text" name="ip_address" placeholder="192.168.1.1" required>
            <button type="submit">حفظ القاعدة</button>
        </form>
        <h3 style="margin-top:20px;">القواعد الحالية</h3>
        <?php foreach (get_ip_rules($server_dir) as $rule): ?>
        <p><?= htmlspecialchars($rule) ?></p>
        <?php endforeach; ?>
    </div>
</body>
</html>