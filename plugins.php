<?php
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";

function get_plugins($server_dir) {
    $plugins = [];
    $filterscripts = "{$server_dir}/filterscripts";
    $plugins_dir = "{$server_dir}/plugins";
    
    if (is_dir($filterscripts)) {
        foreach (glob("{$filterscripts}/*.amx") as $file) {
            $plugins[] = ['type' => 'filterscript', 'name' => basename($file), 'path' => $file];
        }
    }
    
    if (is_dir($plugins_dir)) {
        foreach (glob("{$plugins_dir}/*.dll") as $file) {
            $plugins[] = ['type' => 'plugin', 'name' => basename($file), 'path' => $file];
        }
        foreach (glob("{$plugins_dir}/*.so") as $file) {
            $plugins[] = ['type' => 'plugin', 'name' => basename($file), 'path' => $file];
        }
    }
    return $plugins;
}

function get_gamemodes($server_dir) {
    $modes = [];
    $gamemodes = "{$server_dir}/gamemodes";
    if (is_dir($gamemodes)) {
        foreach (glob("{$gamemodes}/*.amx") as $file) {
            $modes[] = basename($file);
        }
    }
    return $modes;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['plugin_file'])) {
        $type = $_POST['plugin_type'];
        $target_dir = $type === 'filterscript' ? "{$server_dir}/filterscripts" : "{$server_dir}/plugins";
        if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);
        move_uploaded_file($_FILES['plugin_file']['tmp_name'], $target_dir . '/' . $_FILES['plugin_file']['name']);
    }
    if (isset($_POST['delete_plugin'])) {
        unlink($_POST['plugin_path']);
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الإضافات</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .plugin-box { background:#16213e; padding:20px; border-radius:10px; margin:10px 0; }
        .plugin-item { padding:10px; background:#000; margin:5px 0; border-radius:5px; }
        .btn { padding:5px 10px; border:none; border-radius:3px; cursor:pointer; margin:2px; }
        .btn-upload { background:#00aa00; color:#fff; }
        .btn-delete { background:#aa0000; color:#fff; }
        input, select { padding:8px; margin:5px; background:#000; color:#fff; border:1px solid #0f0; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="plugin-box">
        <h2>الإضافات - <?= htmlspecialchars($server_name) ?></h2>
        <h3>رفع إضافة جديدة</h3>
        <form method="POST" enctype="multipart/form-data">
            <select name="plugin_type">
                <option value="filterscript">فلتر سكربت (.amx)</option>
                <option value="plugin">بلوجين (.dll/.so)</option>
            </select>
            <input type="file" name="plugin_file" required>
            <button type="submit" class="btn btn-upload">رفع</button>
        </form>
        <h3>الفلتر سكربتات</h3>
        <?php foreach (array_filter(get_plugins($server_dir), fn($p) => $p['type'] === 'filterscript') as $plugin): ?>
        <div class="plugin-item">
            📄 <?= htmlspecialchars($plugin['name']) ?>
            <form method="POST" style="display:inline">
                <input type="hidden" name="delete_plugin" value="1">
                <input type="hidden" name="plugin_path" value="<?= $plugin['path'] ?>">
                <button type="submit" class="btn btn-delete">حذف</button>
            </form>
        </div>
        <?php endforeach; ?>
        <h3>البلوجينات</h3>
        <?php foreach (array_filter(get_plugins($server_dir), fn($p) => $p['type'] === 'plugin') as $plugin): ?>
        <div class="plugin-item">
            🔌 <?= htmlspecialchars($plugin['name']) ?>
            <form method="POST" style="display:inline">
                <input type="hidden" name="delete_plugin" value="1">
                <input type="hidden" name="plugin_path" value="<?= $plugin['path'] ?>">
                <button type="submit" class="btn btn-delete">حذف</button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>