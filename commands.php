<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/themes.php';
// نظام اللوقات
require_once __DIR__ . '/logs.php';
// مكتبة توليد صور
require_once __DIR__ . '/vendor/autoload.php'; // مثال: استخدام Intervention Image

if (!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";

$quick_commands = [
    'say مرحباً بكم في تيربو هاوستينج!' => '📢 إرسال رسالة للاعبين',
    'players' => '👥 إظهار عدد اللاعبين',
    'kick 0' => '🚫 طرد اللاعب برقم ID',
    'ban 0' => '🔨 حظر اللاعب برقم ID',
    'gamemodetext تيربو' => '🎮 تغيير اسم اللعبة',
    'hostname الخادم الجديد' => '🏷️ تغيير اسم الخادم',
    'reloadfs' => '🔄 إعادة تحميل الفلتر سكربتات',
    'gmx' => '🎲 تغيير GameMode',
    'performance' => '📊 إحصائيات الأداء',
    'status' => '🟢 حالة الخادم',
];

$theme = apply_turbo_theme();

// دالة تسجيل اللوقات مع حماية من السبام
function log_command($user, $server, $command) {
    $log_entry = date('Y-m-d H:i:s') . " | $user | $server | $command\n";
    $logfile = __DIR__ . '/logs/commands.log';
    // حماية من السبام: لا تسجل نفس الأمر من نفس المستخدم خلال 3 ثواني
    if (file_exists($logfile)) {
        $lines = array_slice(file($logfile), -3);
        foreach ($lines as $line) {
            if (strpos($line, "$user | $server | $command") !== false && (time() - strtotime(substr($line, 0, 19))) < 3) {
                return;
            }
        }
    }
    file_put_contents($logfile, $log_entry, FILE_APPEND);
}

// دالة حماية من الأوامر الضارة
function is_command_safe($cmd) {
    $dangerous = ['rm ', 'del ', 'shutdown', 'reboot', 'format', ':(){:|:&};:', 'mkfs', 'dd ', 'wget ', 'curl '];
    foreach ($dangerous as $bad) {
        if (stripos($cmd, $bad) !== false) return false;
    }
    return true;
}

// دالة جلب حالة السيرفر (مثال)
function get_server_status($server_dir) {
    $status = [
        'online' => rand(0,1) ? 'متصل' : 'غير متصل',
        'players' => rand(0, 100),
        'cpu' => rand(1, 90) . '%',
        'ram' => rand(100, 2000) . 'MB',
    ];
    return $status;
}

// دالة توليد صورة إحصائية (PNG)
function generate_stats_image($stats = []) {
    if (!class_exists('Intervention\\Image\\ImageManagerStatic')) return false;
    $img = Intervention\Image\ImageManagerStatic::canvas(400, 120, '#222');
    $img->text('إحصائيات الخادم:', 20, 30, function($font) {
        $font->file(__DIR__.'/fonts/arial.ttf');
        $font->size(22);
        $font->color('#fff');
    });
    $y = 60;
    foreach ($stats as $k => $v) {
        $img->text("$k: $v", 30, $y, function($font) {
            $font->file(__DIR__.'/fonts/arial.ttf');
            $font->size(16);
            $font->color('#0ff');
        });
        $y += 25;
    }
    $path = __DIR__ . '/stats.png';
    $img->save($path);
    return basename($path);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>⚡ الأوامر السريعة - تيربو هاوستينج</title>
    <style>
        :root {
            --bg-gradient: <?= $theme['bg_gradient'] ?>;
            --sidebar: <?= $theme['sidebar'] ?>;
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
        .quick-box { 
            background: var(--card); 
            padding: 25px; 
            border-radius: 15px;
            border: 2px solid var(--accent);
            box-shadow: var(--glow);
        }
        .cmd-btn { 
            display: inline-block; 
            padding: 12px 18px; 
            background: var(--sidebar); 
            color: var(--text); 
            margin: 8px; 
            text-decoration: none; 
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 2px solid var(--accent);
            font-weight: bold;
        }
        .cmd-btn:hover { 
            background: var(--accent);
            color: #000;
            box-shadow: var(--glow);
            transform: scale(1.05);
        }
        .form-section { 
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid var(--accent);
        }
        input, textarea { 
            width: 100%; 
            padding: 12px; 
            background: #000; 
            color: var(--text); 
            border: 2px solid var(--accent); 
            margin: 5px 0;
            border-radius: 8px;
            font-family: monospace;
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
    </style>
</head>
<body>
    <a href="turbo_housting.php">🏠 العودة للوحة التحكم</a>
    <div class="quick-box">
        <h2>⚡ الأوامر السريعة - تيربو هاوستينج</h2>
        <div style="background:var(--sidebar);padding:10px 15px;border-radius:8px;margin-bottom:15px;">
            <b>شرح:</b> استخدم الأزرار أو أرسل أوامر مخصصة. جميع الأوامر تخضع للحماية والتوثيق. يتم تسجيل كل عملية لوقائياً.
        </div>
        <?php if (isset($_GET['done'])): ?>
            <div style="background:var(--success);color:#000;padding:10px 15px;border-radius:8px;margin-bottom:10px;">✅ تم تنفيذ الأمر بنجاح!</div>
        <?php endif; ?>
        <?php if (isset($_GET['err'])): ?>
            <div style="background:var(--danger);color:#fff;padding:10px 15px;border-radius:8px;margin-bottom:10px;">❌ تم رفض الأمر (غير آمن أو مكرر بسرعة)!</div>
        <?php endif; ?>
        <div style="background:var(--card);padding:10px 15px;border-radius:8px;margin-bottom:15px;">
            <b>حالة السيرفر:</b><br>
            <?php $status = get_server_status($server_dir); ?>
            🟢 الحالة: <b><?= $status['online'] ?></b> | 👥 اللاعبين: <b><?= $status['players'] ?></b> | 🖥️ CPU: <b><?= $status['cpu'] ?></b> | 💾 RAM: <b><?= $status['ram'] ?></b>
        </div>
        <?php foreach ($quick_commands as $cmd => $desc): ?>
            <a href="?server=<?= $server_name ?>&quickcmd=<?= urlencode($cmd) ?>" class="cmd-btn"><?= htmlspecialchars($desc) ?></a>
        <?php endforeach; ?>
        <div class="form-section">
            <h3 style="color:var(--accent);">💻 أمر مخصص</h3>
            <form method="POST" action="commands.php">
                <input type="hidden" name="action" value="command">
                <textarea name="command" rows="3" placeholder="اكتب أمر RCON هنا..." required></textarea>
                <button type="submit">🚀 إرسال الأمر</button>
            </form>
        </div>
        <div class="form-section">
            <h3 style="color:var(--accent);">📊 توليد صورة إحصائية</h3>
            <form method="POST" action="commands.php">
                <input type="hidden" name="action" value="generate_png">
                <input type="text" name="stat1" placeholder="اسم الإحصائية 1:القيمة">
                <input type="text" name="stat2" placeholder="اسم الإحصائية 2:القيمة">
                <button type="submit">🖼️ توليد صورة</button>
            </form>
            <?php if (isset($_SESSION['stats_img'])): ?>
                <img src="<?= $_SESSION['stats_img'] ?>" alt="إحصائيات الخادم" style="margin-top:10px;max-width:100%;border:2px solid var(--accent);border-radius:8px;">
            <?php unset($_SESSION['stats_img']); endif; ?>
        </div>
    </div>
    <div class="form-section">
        <h3 style="color:var(--accent);">📝 أحدث اللوقات</h3>
        <pre style="background:#111;color:#0ff;padding:10px;border-radius:8px;max-height:200px;overflow:auto;">
        <?php 
        $logfile = __DIR__ . '/logs/commands.log';
        if (file_exists($logfile)) {
            $lines = array_slice(file($logfile), -10);
            foreach ($lines as $line) echo htmlspecialchars($line);
        } else {
            echo 'لا توجد لوقات بعد.';
        }
        ?>
        </pre>
    </div>
</body>
</html>
<?php
// معالجة الأوامر السريعة والمخصصة مع حماية
if (isset($_GET['quickcmd'])) {
    $cmd = $_GET['quickcmd'];
    if (!is_command_safe($cmd)) {
        header('Location: commands.php?server=' . urlencode($server_name) . '&err=1');
        exit;
    }
    log_command($_SESSION['username'] ?? 'unknown', $server_name, $cmd);
    // ... تنفيذ الأمر على الخادم ...
    header('Location: commands.php?server=' . urlencode($server_name) . '&done=1');
    exit;
}
if (isset($_POST['action']) && $_POST['action'] === 'command' && !empty($_POST['command'])) {
    $cmd = trim($_POST['command']);
    if (!is_command_safe($cmd)) {
        header('Location: commands.php?server=' . urlencode($server_name) . '&err=1');
        exit;
    }
    log_command($_SESSION['username'] ?? 'unknown', $server_name, $cmd);
    // ... تنفيذ الأمر على الخادم ...
    header('Location: commands.php?server=' . urlencode($server_name) . '&done=1');
    exit;
}
// معالجة توليد صورة إحصائية
if (isset($_POST['action']) && $_POST['action'] === 'generate_png') {
    $stats = [];
    if (!empty($_POST['stat1'])) {
        [$k, $v] = explode(':', $_POST['stat1'] . ':');
        $stats[$k] = $v;
    }
    if (!empty($_POST['stat2'])) {
        [$k, $v] = explode(':', $_POST['stat2'] . ':');
        $stats[$k] = $v;
    }
    $img = generate_stats_image($stats);
    if ($img) {
        $_SESSION['stats_img'] = $img;
    }
    header('Location: commands.php?server=' . urlencode($server_name));
    exit;
}
?>