<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/themes.php';
require_once __DIR__ . '/security.php';
if (!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}

$server_name = $_POST['server_name'] ?? '';
$gamemode = $_POST['gamemode'] ?? 'default';
$rcon_password = $_POST['rcon_password'] ?? 'changeme';
$max_players = $_POST['max_players'] ?? 50;
$language = $_POST['language'] ?? 'ar';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $server_name) {
    $server_dir = __DIR__ . "/servers/{$server_name}";
    if (!is_dir($server_dir)) {
        mkdir($server_dir, 0755, true);
        
        $server_cfg = "echo Executing Server...\r\n";
        $server_cfg .= "bind \"0.0.0.0:7777\"\r\n";
        $server_cfg .= "hostname {$server_name}\r\n";
        $server_cfg .= "gamemode0 {$gamemode} 1\r\n";
        $server_cfg .= "filterscripts\r\n";
        $server_cfg .= "plugins\r\n";
        $server_cfg .= "announce 1\r\n";
        $server_cfg .= "query 1\r\n";
        $server_cfg .= "rcon_password {$rcon_password}\r\n";
        $server_cfg .= "weburl www.sa-mp.com\r\n";
        $server_cfg .= "anticheat 1\r\n";
        $server_cfg .= "maxnpc 0\r\n";
        $server_cfg .= "maxplayers {$max_players}\r\n";
        $server_cfg .= "enablestdoutoutput 1\r\n";
        $server_cfg .= "language {$language}\r\n";
        
        file_put_contents("{$server_dir}/server.cfg", $server_cfg);
        
        mkdir("{$server_dir}/gamemodes", 0755, true);
        mkdir("{$server_dir}/filterscripts", 0755, true);
        mkdir("{$server_dir}/scriptfiles", 0755, true);
        mkdir("{$server_dir}/plugins", 0755, true);
        
        log_security("تم إنشاء خادم جديد: {$server_name}", 'TURBO');
        
        $success = true;
    } else {
        $error = true;
    }
}

$theme = apply_turbo_theme();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 إنشاء خادم جديد - تيربو هاوستينج</title>
    <style>
        :root {
            --turbo-blue: #0000FF;
            --turbo-dark-blue: #000033;
            --turbo-black: #000000;
            --turbo-cyan: #00FFFF;
            --turbo-magenta: #FF00FF;
            --turbo-green: #00FF00;
            --turbo-yellow: #FFFF00;
            --neon-glow: 0 0 20px #00FFFF, 0 0 40px #0088FF;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background: linear-gradient(135deg, var(--turbo-blue) 0%, var(--turbo-dark-blue) 50%, var(--turbo-black) 100%); 
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-box { 
            max-width: 500px; 
            margin: 0 auto; 
            background: rgba(0, 0, 102, 0.9); 
            padding: 30px; 
            border-radius: 15px;
            border: 2px solid var(--turbo-cyan);
            box-shadow: var(--neon-glow);
        }
        .form-group {
            margin: 15px 0;
        }
        input, select { 
            width: 100%; 
            padding: 12px; 
            margin: 10px 0; 
            background: #000; 
            color: var(--turbo-cyan); 
            border: 2px solid var(--turbo-cyan); 
            border-radius: 8px;
            font-size: 14px;
        }
        input::placeholder {
            color: #666;
        }
        button { 
            width: 100%; 
            padding: 15px; 
            background: var(--turbo-green); 
            color: #000; 
            border: 2px solid var(--turbo-cyan);
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        button:hover {
            box-shadow: var(--neon-glow);
            transform: scale(1.02);
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }
        .checkbox-group input {
            width: auto;
            margin-left: 10px;
        }
        h2 {
            color: var(--turbo-cyan);
            text-shadow: var(--neon-glow);
            margin-bottom: 20px;
            text-align: center;
        }
        a {
            color: var(--turbo-cyan);
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 15px;
        }
        .success-message {
            background: var(--turbo-green);
            color: #000;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .error-message {
            background: #FF0000;
            color: #fff;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .turbo-badge {
            display: inline-block;
            background: linear-gradient(45deg, var(--turbo-cyan), var(--turbo-magenta));
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 12px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2><span class="turbo-badge">TURBO</span>إنشاء خادم SA-MP جديد</h2>
        <?php if (isset($success)): ?>
        <div class="success-message">🎉 تم إنشاء الخادم بنجاح! جاري التوجيه...</div>
        <script>setTimeout(() => location.href='turbo_housting.php', 2000);</script>
        <?php endif; ?>
        <?php if (isset($error)): ?>
        <div class="error-message">❌ الخادم موجود مسبقاً!</div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="server_name" placeholder="🏷️ اسم الخادم الجديد" required>
            </div>
            <div class="form-group">
                <input type="text" name="gamemode" placeholder="🎮 اسم الجيم مود (default)" value="default">
            </div>
            <div class="form-group">
                <input type="text" name="rcon_password" placeholder="🔐 كلمة RCON الأمنية" value="changeme">
            </div>
            <div class="form-group">
                <input type="number" name="max_players" placeholder="👥 الحد الأقصى للاعبين" value="50" min="1" max="500">
            </div>
            <div class="checkbox-group">
                <input type="checkbox" name="turbo_mode" checked>
                <label>🚀 تمكين وضع تيربو الاحترافي</label>
            </div>
            <button type="submit">🚀 إنشاء الخادم الآن</button>
        </form>
        <a href="turbo_housting.php">🏠 العودة للوحة التحكم</a>
    </div>
</body>
</html>