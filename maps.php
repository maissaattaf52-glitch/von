<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/themes.php';
require_once __DIR__ . '/security.php';
if (!isset($_SESSION['logged_in'])) exit;

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";
$error = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['map_file'])) {
    $ext = strtolower(pathinfo($_FILES['map_file']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['map', 'cfg'])) {
        $error = 'نوع الملف غير مدعوم';
    } elseif (!validate_file_upload($_FILES['map_file'], ['map', 'cfg'])) {
        $error = 'حجم الملف كبير جداً أو الملف غير مسموح';
    } else {
        $target_dir = "{$server_dir}/";
        move_uploaded_file($_FILES['map_file']['tmp_name'], $target_dir . $_FILES['map_file']['name']);
        $message = "🚀 تم رفع الخريطة بنجاح!";
    }
}

function get_maps($server_dir) {
    $maps = [];
    foreach (glob("{$server_dir}/*.map") as $map) {
        $maps[] = basename($map);
    }
    foreach (glob("{$server_dir}/*.cfg") as $map) {
        if (strpos($map, 'server.cfg') === false) {
            $maps[] = basename($map);
        }
    }
    return $maps;
}

$theme = apply_turbo_theme();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🗺️ إدارة الخرائط - تيربو هاوستينج</title>
    <style>
        :root {
            --bg-gradient: <?= $theme['bg_gradient'] ?>;
            --card: <?= $theme['card'] ?>;
            --text: <?= $theme['text'] ?>;
            --accent: <?= $theme['accent'] ?>;
            --success: <?= $theme['success'] ?>;
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
        .maps-box { 
            background: var(--card); 
            padding: 25px; 
            border-radius: 15px;
            border: 2px solid var(--accent);
            box-shadow: var(--glow);
        }
        .map-item { 
            padding: 15px; 
            background: #000; 
            margin: 10px 0; 
            border-radius: 8px;
            border-right: 4px solid var(--accent);
            transition: all 0.3s ease;
        }
        .map-item:hover {
            box-shadow: var(--glow);
        }
        .upload-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .upload-form input[type="file"] {
            flex: 1;
            padding: 10px;
            background: #000;
            color: var(--text);
            border: 2px solid var(--accent);
            border-radius: 8px;
        }
        button { 
            padding: 12px 25px; 
            background: var(--success); 
            color: #000; 
            border: 2px solid var(--accent);
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        button:hover {
            box-shadow: var(--glow);
            transform: scale(1.03);
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
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin: 10px 0;
        }
        .alert-success { background: var(--success); color: #000; }
        .alert-error { background: var(--danger); color: #fff; }
    </style>
</head>
<body>
    <a href="turbo_housting.php">🏠 العودة للوحة التحكم</a>
    <div class="maps-box">
        <h2>🗺️ إدارة الخرائط - <?= htmlspecialchars($server_name) ?></h2>
        <?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
        <?php if ($message): ?><div class="alert alert-success"><?= $message ?></div><?php endif; ?>
        <form method="POST" enctype="multipart/form-data" class="upload-form">
            <input type="file" name="map_file" accept=".map,.cfg" required>
            <button type="submit">🚀 رفع خريطة</button>
        </form>
        <h3 style="color:var(--accent); margin-top:20px;">📋 الخرائط الموجودة</h3>
        <?php if (empty(get_maps($server_dir))): ?>
        <p style="color:#888;">لا توجد خرائط مرفعة بعد</p>
        <?php endif; ?>
        <?php foreach (get_maps($server_dir) as $map): ?>
        <div class="map-item">📍 <?= htmlspecialchars($map) ?></div>
        <?php endforeach; ?>
    </div>
</body>
</html>