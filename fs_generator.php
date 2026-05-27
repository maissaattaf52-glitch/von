<?php
// FilterScript Generator
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$fs_templates = [
    'afk' => ['name' => 'AFK Detection', 'code' => 'new afk_time[MAX_PLAYERS];'],
    'nametag' => ['name' => '3D Nametag', 'code' => '// 3D text label for players'],
    'pickup' => ['name' => 'Pickups', 'code' => '// Custom pickup system'],
    'weather' => ['name' => 'Weather Time', 'code' => '// Dynamic weather'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['template'], $_POST['name'])) {
    $template = $_POST['template'];
    $name = $_POST['name'];
    $code = $fs_templates[$template]['code'];
    
    $full_code = <<<PAWN
// FilterScript: {$name}
// Template: {$fs_templates[$template]['name']}

#include <a_samp>

{$code}

public OnFilterScriptInit()
{
    print("FilterScript {$name} loaded!");
    return 1;
}
PAWN;
    
    $fs_dir = __DIR__ . "/servers/server1/filterscripts";
    if (!is_dir($fs_dir)) mkdir($fs_dir, 0755, true);
    file_put_contents("{$fs_dir}/{$name}.pwn", $full_code);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد الفلاتر سكربت</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .fs-box { background:#16213e; padding:20px; border-radius:10px; }
        select, input { padding:10px; margin:5px; background:#000; color:#fff; border:1px solid #0f0; }
        button { padding:10px 15px; background:#aa5500; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="fs-box">
        <h2>مولد الفلاتر سكربت</h2>
        <form method="POST">
            <select name="template">
                <?php foreach ($fs_templates as $key => $data): ?>
                <option value="<?= $key ?>"><?= htmlspecialchars($data['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="name" placeholder="اسم الفلاتر" required>
            <button type="submit">إنشاء</button>
        </form>
    </div>
</body>
</html>