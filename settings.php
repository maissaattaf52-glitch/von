<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/themes.php';
if (!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";

function read_server_cfg($server_dir) {
    $cfg_file = "{$server_dir}/server.cfg";
    if (!file_exists($cfg_file)) return [];
    
    $lines = file($cfg_file);
    $config = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if (strpos($line, ' ') !== false && !str_starts_with($line, 'echo')) {
            list($key, $value) = array_pad(explode(' ', $line, 2), 2, '');
            $config[$key] = $value;
        }
    }
    return $config;
}

function save_server_cfg($server_dir, $config) {
    $lines = [];
    foreach ($config as $key => $value) {
        $lines[] = "$key $value";
    }
    file_put_contents("{$server_dir}/server.cfg", implode("\n", $lines) . "\n");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $config = [
        'bind' => $_POST['bind'] ?? '0.0.0.0:7777',
        'hostname' => $_POST['hostname'] ?? '',
        'gamemode0' => $_POST['gamemode0'] ?? 'default 1',
        'rcon_password' => $_POST['rcon_password'] ?? 'changeme',
        'announce' => $_POST['announce'] ?? '1',
        'query' => $_POST['query'] ?? '1',
        'weburl' => $_POST['weburl'] ?? 'www.sa-mp.com',
        'maxnpc' => $_POST['maxnpc'] ?? '0',
        'maxplayers' => $_POST['maxplayers'] ?? '50',
    ];
    
    $full_cfg = "echo Executing Server...\n";
    foreach ($config as $key => $value) {
        $full_cfg .= "$key $value\n";
    }
    $full_cfg .= "filterscripts\nplugins\nanticheat 1\nenablestdoutoutput 1\n";
    
    file_put_contents("{$server_dir}/server.cfg", $full_cfg);
}

$theme = apply_turbo_theme();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>⚙️ إعدادات الخادم - تيربو هاوستينج</title>
    <style>
        :root {
            --bg-gradient: <?= $theme['bg_gradient'] ?>;
            --card: <?= $theme['card'] ?>;
            --text: <?= $theme['text'] ?>;
            --accent: <?= $theme['accent'] ?>;
            --success: <?= $theme['success'] ?>;
            --glow: <?= $theme['glow'] ?>;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background: var(--bg-gradient); 
            color: var(--text); 
            padding: 20px;
            min-height: 100vh;
        }
        .settings-box { 
            background: var(--card); 
            padding: 25px; 
            border-radius: 15px;
            border: 2px solid var(--accent);
            box-shadow: var(--glow);
        }
        .form-group { margin: 15px 0; }
        label { 
            display: block; 
            margin-bottom: 8px; 
            color: var(--accent);
            font-weight: bold;
            text-shadow: 0 0 10px var(--accent);
        }
        input, select { 
            width: 100%; 
            padding: 12px; 
            background: #000; 
            color: var(--text); 
            border: 2px solid var(--accent);
            border-radius: 8px;
            font-size: 14px;
        }
        input:focus {
            box-shadow: var(--glow);
            outline: none;
        }
        button { 
            padding: 12px 25px; 
            background: var(--accent); 
            color: #000; 
            border: none; 
            border-radius: 8px;
            cursor: pointer; 
            margin-top: 15px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        button:hover {
            box-shadow: var(--glow);
            transform: scale(1.05);
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
        .turbo-badge {
            display: inline-block;
            background: var(--accent);
            color: #000;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 12px;
            margin-right: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <a href="turbo_housting.php">🏠 العودة للوحة التحكم</a>
    <div class="settings-box">
        <h2><span class="turbo-badge">TURBO</span>إعدادات الخادم - <?= htmlspecialchars($server_name) ?></h2>
        <?php $cfg = read_server_cfg($server_dir); ?>
        <form method="POST">
            <div class="form-group">
                <label>🌐 المنفذ (Port)</label>
                <input type="text" name="bind" value="<?= htmlspecialchars($cfg['bind'] ?? '0.0.0.0:7777') ?>">
            </div>
            <div class="form-group">
                <label>🏷️ اسم الخادم</label>
                <input type="text" name="hostname" value="<?= htmlspecialchars(str_replace('"', '', $cfg['hostname'] ?? '')) ?>">
            </div>
            <div class="form-group">
                <label>🎮 الجيم مود</label>
                <input type="text" name="gamemode0" value="<?= htmlspecialchars($cfg['gamemode0'] ?? 'default 1') ?>">
            </div>
            <div class="form-group">
                <label>🔐 كلمة RCON</label>
                <input type="password" name="rcon_password" value="<?= htmlspecialchars($cfg['rcon_password'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>🔗 رابط الموقع</label>
                <input type="text" name="weburl" value="<?= htmlspecialchars(str_replace('"', '', $cfg['weburl'] ?? '')) ?>">
            </div>
            <div class="form-group">
                <label>👥 الحد الأقصى للاعبين</label>
                <input type="number" name="maxplayers" value="<?= htmlspecialchars($cfg['maxplayers'] ?? '50') ?>">
            </div>
            <div class="form-group">
                <label>🤖 الحد الأقصى لـ NPC</label>
                <input type="number" name="maxnpc" value="<?= htmlspecialchars($cfg['maxnpc'] ?? '0') ?>">
            </div>
            <button type="submit">💾 حفظ الإعدادات</button>
        </form>
    </div>
</body>
</html>