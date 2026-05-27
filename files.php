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

if (!is_dir($server_dir)) {
    mkdir($server_dir, 0755, true);
}

$current_dir = $_GET['dir'] ?? '';
$full_path = $server_dir . ($current_dir ? '/' . $current_dir : '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new_file'], $_POST['file_content'])) {
        $file_name = sanitize_filename($_POST['new_file']);
        file_put_contents($full_path . '/' . $file_name, $_POST['file_content']);
    }
    if (isset($_POST['delete_file'])) {
        unlink($full_path . '/' . $_POST['delete_file']);
    }
}

function get_dir_tree($path) {
    $items = [];
    if (is_dir($path)) {
        foreach (scandir($path) as $item) {
            if ($item !== '.' && $item !== '..') {
                $items[] = [
                    'name' => $item,
                    'is_dir' => is_dir($path . '/' . $item)
                ];
            }
        }
    }
    return $items;
}

$theme = apply_turbo_theme();
$items = get_dir_tree($full_path);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📁 إدارة الملفات - تيربو هاوستينج</title>
    <style>
        :root {
            --turbo-blue: #0000FF;
            --turbo-dark-blue: #000033;
            --turbo-black: #000000;
            --turbo-cyan: #00FFFF;
            --turbo-green: #00FF00;
            --turbo-red: #FF0000;
            --turbo-yellow: #FFFF00;
            --neon-glow: 0 0 20px #00FFFF, 0 0 40px #0088FF;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background: linear-gradient(135deg, var(--turbo-blue) 0%, var(--turbo-dark-blue) 50%, var(--turbo-black) 100%); 
            color: #fff;
            min-height: 100vh;
            padding: 20px;
        }
        .file-manager { 
            background: rgba(0, 0, 102, 0.9); 
            padding: 25px; 
            border-radius: 15px;
            border: 2px solid var(--turbo-cyan);
            box-shadow: var(--neon-glow);
        }
        .file-item { 
            padding: 12px; 
            border-bottom: 1px solid var(--turbo-cyan); 
            display: flex; 
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }
        .file-item:last-child { border-bottom: none; }
        .file-item:hover {
            background: rgba(0, 255, 255, 0.1);
        }
        .file-item a { 
            color: var(--turbo-cyan); 
            text-decoration: none; 
        }
        .btn { 
            padding: 8px 15px; 
            background: var(--turbo-cyan); 
            color: #000; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            margin: 2px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn:hover {
            box-shadow: var(--neon-glow);
            transform: scale(1.05);
        }
        .btn-danger { background: var(--turbo-red); color: #fff; }
        textarea { 
            width: 100%; 
            height: 150px; 
            background: #000; 
            color: var(--turbo-green); 
            border: 2px solid var(--turbo-cyan); 
            padding: 12px; 
            margin: 10px 0;
            font-family: monospace;
            border-radius: 8px;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            background: #000;
            color: var(--turbo-cyan);
            border: 2px solid var(--turbo-cyan);
            border-radius: 8px;
            margin: 10px 0;
        }
        h2 { color: var(--turbo-cyan); text-shadow: var(--neon-glow); margin-bottom: 20px; }
        .path-display {
            background: #000;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid var(--turbo-cyan);
            margin: 10px 0;
            font-family: monospace;
        }
        .stats-row {
            display: flex;
            gap: 15px;
            margin: 15px 0;
        }
        .stat-badge {
            background: #000;
            padding: 5px 15px;
            border-radius: 15px;
            border: 1px solid var(--turbo-cyan);
        }
    </style>
</head>
<body>
    <a href="turbo_housting.php" style="margin-bottom: 20px; display: inline-block;">🏠 العودة للوحة التحكم</a>
    <div class="file-manager">
        <h2>📁 مدير الملفات - <?= htmlspecialchars($server_name) ?> <span class="stat-badge"><?= count($items) ?> عنصر</span></h2>
        
        <div class="path-display">
            📍 المسار الحالي: <?= $current_dir ?: '/' ?>
        </div>
        
        <?php foreach ($items as $item): ?>
        <div class="file-item">
            <span><?= $item['is_dir'] ? '📁' : '📄' ?> <?= htmlspecialchars($item['name']) ?></span>
            <span>
                <?php if ($item['is_dir']): ?>
                <a href="?action=files&server=<?= $server_name ?>&dir=<?= urlencode($current_dir . '/' . $item['name']) ?>" class="btn">🚀 فتح</a>
                <?php endif; ?>
            </span>
        </div>
        <?php endforeach; ?>
        
        <h3 style="color:var(--turbo-cyan); margin-top:20px;">🆕 إنشاء ملف جديد</h3>
        <form method="POST">
            <input type="text" name="new_file" placeholder="📄 اسم الملف (.pwn, .txt, ...)" required>
            <textarea name="file_content" placeholder="💻 محتوى الملف هنا..."></textarea>
            <button type="submit" class="btn">🚀 إنشاء الملف</button>
        </form>
    </div>
</body>
</html>