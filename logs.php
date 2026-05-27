<?php
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";

function get_logs($server_dir) {
    $log_file = "{$server_dir}/server_log.txt";
    return file_exists($log_file) ? file_get_contents($log_file) : 'No logs available';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rcon_password'])) {
    $cfg_file = "{$server_dir}/server.cfg";
    $cfg = file_get_contents($cfg_file);
    $cfg = preg_replace('/rcon_password\s+\S+/', "rcon_password {$_POST['rcon_password']}", $cfg);
    file_put_contents($cfg_file, $cfg);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>السجلات والإعدادات</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .section { background:#16213e; padding:20px; border-radius:10px; margin:10px 0; }
        .log-box { background:#000; color:#0f0; padding:15px; height:300px; overflow-y:auto; font-family:monospace; font-size:12px; }
        input { padding:8px; width:200px; background:#000; color:#fff; border:1px solid #0f0; }
        button { padding:8px 15px; background:#0f3460; color:#fff; border:none; cursor:pointer; margin:5px; }
        .info-table { width:100%; border-collapse:collapse; margin:10px 0; }
        .info-table td { padding:10px; border-bottom:1px solid #333; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="section">
        <h2>السجلات الحية</h2>
        <div class="log-box" id="logBox"><?= htmlspecialchars(get_logs($server_dir)) ?></div>
        <button onclick="refreshLogs()">تحديث</button>
    </div>
    <div class="section">
        <h2>إعدادات الخادم</h2>
        <table class="info-table">
            <tr><td>اسم الخادم:</td><td><?= htmlspecialchars($server_name) ?></td></tr>
            <tr><td>المجلد:</td><td><?= htmlspecialchars($server_dir) ?></td></tr>
            <tr><td>الحالة:</td><td><?= get_server_status($server_name)['status'] === 'online' ? 'متصل' : 'معطل' ?></td></tr>
        </table>
        <h3 style="margin-top:20px;">تغيير كلمة RCON</h3>
        <form method="POST">
            <input type="text" name="rcon_password" placeholder="كلمة جديدة">
            <button type="submit">حفظ</button>
        </form>
    </div>
    <script>
    function refreshLogs() {
        fetch('logs_api.php?server=<?= $server_name ?>')
            .then(r => r.text())
            .then(text => {
                document.getElementById('logBox').textContent = text;
            });
    }
    setInterval(refreshLogs, 3000);
    </script>
</body>
</html>