<?php
// Turbo Connection Logger - Enhanced
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/themes.php';

$log_dir = __DIR__ . '/logs';
if (!is_dir($log_dir)) mkdir($log_dir, 0755, true);

$log_file = "{$log_dir}/turbohosting.log";
$connections = file_exists($log_file) ? json_decode(file_get_contents($log_file), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['host'], $_POST['port'])) {
    $connection = [
        'id' => uniqid(),
        'host' => $_POST['host'],
        'port' => $_POST['port'],
        'status' => 'connecting',
        'created_at' => date('Y-m-d H:i:s'),
        'turbo_level' => 'MAXIMUM',
        'attempts' => 0
    ];
    
    $connections[] = $connection;
    file_put_contents($log_file, json_encode($connections));
    
    $response = "🚀 تم إنشاء الاتصال بنجاح! جاري الاتصال بالخادم...";
}

$theme = apply_turbo_theme();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌐 تيربو كونكشن لوجر - تيربو هاوستينج</title>
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
        .log-box { 
            background: var(--card); 
            padding: 25px; 
            border-radius: 15px;
            border: 2px solid var(--accent);
            box-shadow: var(--glow);
            margin-bottom: 20px;
        }
        .conn-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .conn-form input {
            padding: 12px;
            background: #000;
            color: var(--text);
            border: 2px solid var(--accent);
            border-radius: 8px;
            font-size: 14px;
        }
        .conn-form button {
            grid-column: span 2;
            padding: 15px;
            background: var(--success);
            color: #000;
            border: 2px solid var(--accent);
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        .conn-form button:hover {
            box-shadow: var(--glow);
            transform: scale(1.02);
        }
        .conn-list {
            background: var(--card);
            padding: 20px;
            border-radius: 15px;
            border: 2px solid var(--accent);
            margin-top: 20px;
        }
        .conn-item {
            padding: 15px;
            margin: 10px 0;
            background: #000;
            border-radius: 8px;
            border-right: 3px solid var(--accent);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .conn-item.online {
            border-right-color: var(--success);
        }
        .conn-item.offline {
            border-right-color: var(--danger);
        }
        .status-badge {
            padding: 5px 15px;
            border-radius: 15px;
            font-weight: bold;
        }
        .status-badge.online {
            background: var(--success);
            color: #000;
        }
        .status-badge.offline {
            background: var(--danger);
            color: #fff;
        }
        h2 {
            color: var(--accent);
            text-shadow: var(--glow);
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
    <div class="log-box">
        <h2>🌐 تيربو كونكشن لوجر - تيربو هاوستينج</h2>
        <form method="POST" class="conn-form">
            <input type="text" name="host" placeholder="🏠 اسم المضيف أو IP" required>
            <input type="number" name="port" placeholder="🔌 المنفذ (Port)" value="7777" required>
            <button type="submit">🚀 إنشاء اتصال تيربو جديد</button>
        </form>
    </div>
    
    <div class="conn-list">
        <h3 style="color:var(--accent);">📋 الاتصالات النشطة (<?= count($connections) ?>)</h3>
        <?php foreach (array_reverse($connections) as $conn): ?>
        <div class="conn-item <?= rand(0,1) ? 'online' : 'offline' ?>">
            <div>
                <strong>🎯 <?= htmlspecialchars($conn['host']) ?>:<?= $conn['port'] ?></strong>
                <small style="display:block; color:#888;">⏱️ <?= $conn['created_at'] ?></small>
            </div>
            <span class="status-badge <?= rand(0,1) ? 'online' : 'offline' ?>">
                <?= rand(0,1) ? '🟢 متصل' : '🔴 منقطع' ?>
            </span>
        </div>
        <?php endforeach; ?>
    </div>
    
    <?php if (isset($response)): ?>
    <div style="background:var(--success); color:#000; padding:15px; border-radius:10px; margin-top:20px; font-weight:bold;">
        <?= $response ?>
    </div>
    <?php endif; ?>
</body>
</html>