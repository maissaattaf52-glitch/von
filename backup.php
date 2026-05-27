<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/themes.php';
require_once __DIR__ . '/security.php';
if (!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['backup'])) {
        $backup_dir = __DIR__ . "/backups";
        if (!is_dir($backup_dir)) mkdir($backup_dir, 0755, true);
        
        $zip_file = "{$backup_dir}/{$server_name}_" . date('Y-m-d_H-i-s') . ".zip";
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE);
        
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($server_dir));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $zip->addFile($file->getPathname(), str_replace($server_dir . DIRECTORY_SEPARATOR, '', $file->getPathname()));
            }
        }
        $zip->close();
        $message = "🚀 تم إنشاء النسخة الاحتياطية بنجاح!";
    }
    
    if (isset($_POST['restore'], $_POST['backup_file'])) {
        $zip = new ZipArchive();
        $zip->open(__DIR__ . "/backups/{$_POST['backup_file']}");
        $zip->extractTo($server_dir);
        $zip->close();
        $message = "🔄 تم استعادة البيانات بنجاح!";
    }
}

function get_backups() {
    $backups = [];
    $backup_dir = __DIR__ . "/backups";
    if (is_dir($backup_dir)) {
        foreach (glob("{$backup_dir}/*.zip") as $file) {
            $stats = stat($file);
            $backups[] = [
                'name' => basename($file),
                'size' => round(filesize($file)/1024/1024, 2),
                'date' => date('Y-m-d H:i:s', $stats['mtime'])
            ];
        }
    }
    return $backups;
}

$theme = apply_turbo_theme();
$backups = get_backups();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💾 النسخ الاحتياطية - تيربو هاوستينج</title>
    <style>
        :root {
            --turbo-blue: #0000FF;
            --turbo-dark-blue: #000033;
            --turbo-black: #000000;
            --turbo-cyan: #00FFFF;
            --turbo-magenta: #FF00FF;
            --turbo-green: #00FF00;
            --turbo-yellow: #FFFF00;
            --turbo-red: #FF0000;
            --neon-glow: 0 0 20px #00FFFF, 0 0 40px #0088FF;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background: linear-gradient(135deg, var(--turbo-blue) 0%, var(--turbo-dark-blue) 50%, var(--turbo-black) 100%); 
            color: #fff;
            min-height: 100vh;
            padding: 20px;
        }
        .backup-box { 
            background: rgba(0, 0, 102, 0.8); 
            padding: 25px; 
            border-radius: 15px;
            border: 2px solid var(--turbo-cyan);
            box-shadow: var(--neon-glow);
        }
        .backup-section {
            margin: 20px 0;
            padding: 15px;
            background: #000;
            border-radius: 10px;
            border: 1px solid var(--turbo-cyan);
        }
        .backup-item { 
            padding: 15px; 
            background: #000; 
            margin: 10px 0; 
            border-radius: 8px;
            border-right: 4px solid var(--turbo-cyan);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }
        .backup-item:hover {
            box-shadow: var(--neon-glow);
        }
        button { 
            padding: 12px 25px; 
            background: var(--turbo-green); 
            color: #000; 
            border: 2px solid var(--turbo-cyan);
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        button:hover {
            box-shadow: var(--neon-glow);
            transform: scale(1.03);
        }
        .btn-restore { 
            background: var(--turbo-yellow); 
            color: #000; 
        }
        .btn-danger {
            background: var(--turbo-red);
            color: #fff;
        }
        select {
            padding: 10px;
            background: #000;
            color: var(--turbo-cyan);
            border: 2px solid var(--turbo-cyan);
            border-radius: 8px;
            margin: 5px;
        }
        a { color: var(--turbo-cyan); text-decoration: none; }
        a:hover { text-shadow: var(--neon-glow); }
        h2 { color: var(--turbo-cyan); text-shadow: var(--neon-glow); margin-bottom: 20px; }
        .stat-badge {
            background: var(--turbo-black);
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 12px;
            color: var(--turbo-green);
        }
    </style>
</head>
<body>
    <a href="turbo_housting.php" style="margin-bottom: 20px; display: inline-block;">🏠 العودة للوحة التحكم</a>
    <div class="backup-box">
        <h2>💾 النسخ الاحتياطية - تيربو هاوستينج <span class="stat-badge"><?= count($backups) ?> نسخة</span></h2>
        <?php if ($message): ?>
        <div style="background:var(--turbo-green); color:#000; padding:15px; border-radius:10px; margin-bottom:20px; font-weight:bold;">
            <?= $message ?>
        </div>
        <?php endif; ?>
        
        <div class="backup-section">
            <h3 style="color:var(--turbo-cyan); margin-bottom:15px;">📦 إنشاء نسخة احتياطية جديدة</h3>
            <form method="POST">
                <button type="submit" name="backup">🚀 إنشاء نسخة احتياطية الآن</button>
            </form>
        </div>
        
        <div class="backup-section">
            <h3 style="color:var(--turbo-cyan); margin-bottom:15px;">🔄 استعادة من نسخة</h3>
            <form method="POST">
                <select name="backup_file" required>
                    <option value="">🔄 اختر ملف النسخة الاحتياطية</option>
                    <?php foreach ($backups as $backup): ?>
                    <option value="<?= $backup['name'] ?>"><?= $backup['name'] ?> (<?= $backup['size'] ?> MB)</option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="restore" class="btn-restore">🔄 استعادة</button>
            </form>
        </div>
        
        <div class="backup-section">
            <h3 style="color:var(--turbo-cyan); margin-bottom:15px;">📁 النسخ المتوفرة</h3>
            <?php foreach (array_reverse($backups) as $backup): ?>
            <div class="backup-item">
                <div>
                    <strong>📄 <?= htmlspecialchars($backup['name']) ?></strong>
                    <small style="display:block; color:#888;">📅 <?= $backup['date'] ?> | 💾 <?= $backup['size'] ?> MB</small>
                </div>
                <a href="?restore=1&backup_file=<?= urlencode($backup['name']) ?>" style="margin:0; padding:8px 15px;">🔄</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>