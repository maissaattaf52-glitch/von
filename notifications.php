<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/themes.php';
if (!isset($_SESSION['logged_in'])) exit;

$server_name = $_GET['server'] ?? $config['default_server'];
$notif_file = __DIR__ . "/logs/notifications.json";
$notifications = file_exists($notif_file) ? json_decode(file_get_contents($notif_file), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notifications[] = [
        'id' => uniqid(),
        'server' => $server_name,
        'type' => $_POST['type'] ?? 'info',
        'message' => $_POST['message'] ?? '',
        'time' => date('Y-m-d H:i:s'),
        'read' => false
    ];
    file_put_contents($notif_file, json_encode($notifications));
}
$theme = apply_turbo_theme();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>🔔 الإشعارات - تيربو هاوستينج</title>
    <style>
        :root {
            --bg-gradient: <?= $theme['bg_gradient'] ?>;
            --card: <?= $theme['card'] ?>;
            --text: <?= $theme['text'] ?>;
            --accent: <?= $theme['accent'] ?>;
            --success: <?= $theme['success'] ?>;
            --warning: <?= $theme['warning'] ?>;
            --danger: <?= $theme['danger'] ?>;
            --glow: <?= $theme['glow'] ?>;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background: var(--bg-gradient); 
            color: var(--text); 
            padding: 20px;
            min-height: 100vh;
        }
        .notif-box { 
            background: var(--card); 
            padding: 25px; 
            border-radius: 15px;
            border: 2px solid var(--accent);
            box-shadow: var(--glow);
        }
        .notif-item { 
            padding: 15px; 
            margin: 10px 0; 
            border-radius: 8px; 
            background: #000;
            border-right: 4px solid var(--accent);
            transition: all 0.3s ease;
        }
        .notif-item:hover {
            box-shadow: var(--glow);
        }
        .notif-item.unread { 
            border-right-color: var(--success);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 5px var(--success); }
            50% { box-shadow: 0 0 20px var(--success); }
            100% { box-shadow: 0 0 5px var(--success); }
        }
        .notif-error { border-right-color: var(--danger); }
        .notif-warning { border-right-color: var(--warning); }
        select, textarea, button { 
            padding: 10px; 
            margin: 5px;
            background: #000;
            color: var(--text);
            border: 2px solid var(--accent);
            border-radius: 5px;
        }
        button {
            background: var(--accent);
            color: #000;
            font-weight: bold;
            cursor: pointer;
        }
        h2 {
            color: var(--accent);
            text-shadow: var(--glow);
            margin-bottom: 20px;
        }
        a {
            color: var(--accent);
            text-decoration: none;
        }
        a:hover {
            text-shadow: var(--glow);
        }
    </style>
</head>
<body>
    <a href="turbo_housting.php">🏠 العودة للوحة التحكم</a>
    <div class="notif-box">
        <h2>🔔 الإشعارات - <?= htmlspecialchars($server_name) ?></h2>
        <form method="POST">
            <select name="type">
                <option value="info">ℹ️ معلومات</option>
                <option value="warning">⚠️ تحذير</option>
                <option value="error">❌ خطأ</option>
            </select>
            <textarea name="message" placeholder="نص الإشعار هنا..." style="width:100%;height:80px;"></textarea>
            <button type="submit">🚀 إرسال إشعار</button>
        </form>
        <h3 style="margin-top:20px; color:var(--accent);">📂 الإشعارات السابقة</h3>
        <?php foreach (array_reverse($notifications) as $notif): ?>
        <?php $class = $notif['type'] === 'error' ? 'notif-error' : ($notif['type'] === 'warning' ? 'notif-warning' : ''); ?>
        <div class="notif-item <?= $notif['read'] ? '' : 'unread' ?> <?= $class ?>">
            <strong><?= $notif['type'] === 'info' ? 'ℹ️' : ($notif['type'] === 'warning' ? '⚠️' : '❌') ?> <?= htmlspecialchars($notif['message'] ?? '') ?></strong>
            <small style="float:left; color:#888;"><?= $notif['time'] ?? '' ?></small>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>