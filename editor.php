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
$file_path = $_GET['file'] ?? '';
$file_content = '';
$error = '';

if ($file_path && file_exists($server_dir . '/' . $file_path)) {
    $file_content = file_get_contents($server_dir . '/' . $file_path);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'], $_POST['file_content'])) {
    if ($file_path) {
        file_put_contents($server_dir . '/' . $file_path, $_POST['file_content']);
    }
}

function get_file_tree($path) {
    $items = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $relative = str_replace($path . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $items[] = $relative;
        }
    }
    return $items;
}

$theme = apply_turbo_theme();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💻 محرر الأكواد - تيربو هاوستينج</title>
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
            margin: 0;
            min-height: 100vh;
        }
        .editor-container { 
            display: flex; 
            flex-direction: column;
            min-height: 100vh;
        }
        .file-tree { 
            width: 100%;
            background: var(--card); 
            padding: 15px; 
            border: 2px solid var(--accent);
            box-shadow: var(--glow);
        }
        .editor { 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
        }
        .editor-header { 
            padding: 15px; 
            background: var(--accent);
            color: #000;
            font-weight: bold;
        }
        .editor-header a {
            color: #000;
            text-decoration: none;
        }
        .file-tree a { 
            display: block; 
            color: var(--text); 
            padding: 10px; 
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .file-tree a:hover { 
            background: var(--accent);
            color: #000;
            box-shadow: var(--glow);
        }
        textarea { 
            flex: 1; 
            width: 100%; 
            background: #000; 
            color: var(--success); 
            border: 2px solid var(--accent); 
            padding: 15px; 
            font-family: 'Courier New', monospace; 
            font-size: 14px; 
            resize: none;
        }
        .btn-save { 
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
        .btn-save:hover {
            box-shadow: var(--glow);
            transform: scale(1.03);
        }
        h3 {
            color: var(--accent);
            text-shadow: var(--glow);
            margin-bottom: 10px;
        }
        .top-bar {
            background: var(--card);
            padding: 15px 20px;
            border-bottom: 2px solid var(--accent);
        }
        .top-bar h2 {
            color: var(--accent);
            text-shadow: var(--glow);
        }
    </style>
</head>
<body>
    <div class="editor-container">
        <div class="top-bar">
            <h2>💻 محرر الأكواد - تيربو هاوستينج <span style="font-size:14px; color:#888;">| خادم: <?= htmlspecialchars($server_name) ?></span></h2>
        </div>
        <div class="file-tree">
            <h3>📁 الملفات (<?= count(get_file_tree($server_dir)) ?>)</h3>
            <?php foreach (get_file_tree($server_dir) as $file): ?>
                <?php if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['pwn', 'inc', 'txt', 'cfg'])): ?>
                <a href="?server=<?= $server_name ?>&file=<?= urlencode($file) ?>">📄 <?= htmlspecialchars($file) ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="editor">
            <div class="editor-header">
                📝 <?= htmlspecialchars($file_path) ?: 'اختر ملفاً للتحرير' ?>
            </div>
            <form method="POST">
                <textarea name="file_content" <?= !$file_path ? 'disabled placeholder="اختر ملفاً من القائمة على اليسار..."' : '' ?>><?= htmlspecialchars($file_content) ?></textarea>
                <?php if ($file_path): ?>
                <button type="submit" name="save" value="1" class="btn-save">💾 حفظ الكود</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>