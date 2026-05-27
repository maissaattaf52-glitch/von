<?php
// Complete FS Integration Generator
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$fs_categories = [
    'admin' => ['Admin FS', 'adminfs'],
    'donate' => ['Donate System', 'donatefs'],
    'business' => ['Business System', 'bizfs'],
    'house' => ['House System', 'housefs'],
    'garage' => ['Garage System', 'garagefs'],
    'bank' => ['Bank System', 'bankfs'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected = $_POST['fs_types'] ?? [];
    $code = "// Combined FilterScripts\n\n";
    
    foreach ($selected as $fs) {
        $code .= "// {$fs_categories[$fs][0]}\n";
        $code .= "#include <{$fs_categories[$fs][1]}>\n\n";
    }
    
    file_put_contents(__DIR__ . "/servers/server1/filterscripts/integrated.pwn", $code);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد FS المتكامل</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .fs-box { background:#16213e; padding:20px; border-radius:10px; }
        button { padding:10px 15px; background:#aa5500; color:#fff; border:none; cursor:pointer; margin-top:10px; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="fs-box">
        <h2>مولد FS المتكامل (تكامل متعدد)</h2>
        <form method="POST">
            <?php foreach ($fs_categories as $key => $data): ?>
            <label><input type="checkbox" name="fs_types[]" value="<?= $key ?>"> <?= $data[0] ?></label><br>
            <?php endforeach; ?>
            <button type="submit">توليد الكود المدمج</button>
        </form>
    </div>
</body>
</html>