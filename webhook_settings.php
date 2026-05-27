<?php
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$server_name = $_GET['server'] ?? $config['default_server'];
$webhooks_file = __DIR__ . "/servers/{$server_name}/webhooks.json";
$webhooks = file_exists($webhooks_file) ? json_decode(file_get_contents($webhooks_file), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $webhooks[] = [
        'type' => $_POST['type'] ?? 'discord',
        'url' => $_POST['url'] ?? '',
        'event' => $_POST['event'] ?? 'all'
    ];
    file_put_contents($webhooks_file, json_encode($webhooks));
}

function get_events() {
    return ['server_start', 'server_stop', 'player_join', 'player_leave', 'all'];
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إعدادات Webhook</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .webhook-box { background:#16213e; padding:20px; border-radius:10px; }
        input, select { padding:8px; margin:5px; background:#000; color:#fff; border:1px solid #0f0; }
        button { padding:8px 12px; background:#0f3460; color:#fff; border:none; cursor:pointer; }
        .webhook-item { padding:10px; background:#000; margin:5px 0; border-radius:5px; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="webhook-box">
        <h2>Webhook - <?= htmlspecialchars($server_name) ?></h2>
        <form method="POST">
            <select name="type">
                <option value="discord">Discord</option>
                <option value="telegram">Telegram</option>
                <option value="webhook">Webhook عام</option>
            </select>
            <input type="url" name="url" placeholder="رابط Webhook" required>
            <select name="event">
                <?php foreach (get_events() as $evt): ?>
                <option value="<?= $evt ?>"><?= htmlspecialchars($evt) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">إضافة</button>
        </form>
        <?php foreach ($webhooks as $hook): ?>
        <div class="webhook-item">
            <?= $hook['type'] ?> - <?= htmlspecialchars($hook['event']) ?>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>