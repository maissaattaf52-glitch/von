<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/themes.php';
if (!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}

$servers_dir = __DIR__ . '/servers';
$total_servers = 0;
$online_servers = 0;
$total_files = 0;
$total_size = 0;

foreach (glob($servers_dir . '/*', GLOB_ONLYDIR) as $dir) {
    $total_servers++;
    $pid_file = $dir . '/samp03svr.pid';
    if (file_exists($pid_file) && file_exists("/proc/" . trim(file_get_contents($pid_file)))) {
        $online_servers++;
    }
    
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $total_files++;
            $total_size += $file->getSize();
        }
    }
}

$theme = apply_turbo_theme();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>📊 الإحصائيات - تيربو هاوستينج</title>
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
        .stats-box { 
            background: var(--card); 
            padding: 25px; 
            border-radius: 15px;
            border: 2px solid var(--accent);
            box-shadow: var(--glow);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .stat-card { 
            background: #000; 
            padding: 20px; 
            margin: 10px 0; 
            border-radius: 10px; 
            border: 2px solid var(--accent);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            box-shadow: var(--glow);
            transform: scale(1.03);
        }
        .stat-number { 
            font-size: 36px; 
            color: var(--accent);
            text-shadow: var(--glow);
            font-weight: bold;
        }
        .stat-label {
            color: #888;
            margin-top: 5px;
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
        .progress-bar {
            width: 100%;
            height: 20px;
            background: #000;
            border-radius: 10px;
            border: 1px solid var(--accent);
            overflow: hidden;
            margin-top: 10px;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--accent), var(--success));
            transition: width 0.5s ease;
        }
    </style>
</head>
<body>
    <a href="turbo_housting.php">🏠 العودة للوحة التحكم</a>
    <div class="stats-box">
        <h2>📊 الإحصائيات الاحترافية - تيربو هاوستينج</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?= $total_servers ?></div>
                <div class="stat-label">🌐 إجمالي الخوادم</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?= $total_servers * 20 ?>%;"></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $online_servers ?>/<span style="font-size:28px;"><?= $total_servers ?></span></div>
                <div class="stat-label">🟢 الخوادم المتصلة</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?= $total_servers > 0 ? ($online_servers/$total_servers)*100 : 0 ?>%;"></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $total_files ?></div>
                <div class="stat-label">📁 إجمالي الملفات</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?= min(100, $total_files/10) ?>%;"></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= round($total_size / 1024 / 1024, 2) ?> MB</div>
                <div class="stat-label">💾 حجم التخزين</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?= min(100, $total_size/1024/1024) ?>%;"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>