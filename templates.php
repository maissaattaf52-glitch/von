<?php
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";

$templates = [
    'onplayerconnect' => "public OnPlayerConnect(playerid)\n{\n    SendClientMessage(playerid, 0xFFFFFFFF, \"Welcome to server!\");\n    return 1;\n}",
    'onplayercommand' => "public OnPlayerCommandText(playerid, cmdtext[])\n{\n    if (strcmp(cmdtext, \"/help\", true) == 0)\n    {\n        SendClientMessage(playerid, 0xFFFFFFFF, \"Commands: /help\");\n        return 1;\n    }\n    return 0;\n}",
    'chatcommand' => "public OnPlayerCommandText(playerid, cmdtext[])\n{\n    if (strfind(cmdtext, \"/\", false) == 0)\n    {\n        // Command handled\n        return 1;\n    }\n    return 0;\n}",
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['template'], $_POST['filename'])) {
    $filename = sanitize_filename($_POST['filename']);
    $content = $_POST['template'];
    if ($filename) {
        file_put_contents("{$server_dir}/gamemodes/{$filename}.pwn", $content);
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قوالب الأكواد</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .templates-box { background:#16213e; padding:20px; border-radius:10px; }
        textarea { width:100%; height:150px; background:#000; color:#fff; border:1px solid #0f0; padding:10px; }
        button { padding:10px 15px; background:#00aa00; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="templates-box">
        <h2>قوالب الأكواد - <?= htmlspecialchars($server_name) ?></h2>
        <form method="POST">
            <select name="template" onchange="updateTemplate(this.value)">
                <option value="">اختر قالب</option>
                <?php foreach ($templates as $key => $code): ?>
                <option value="<?= $key ?>"><?= htmlspecialchars(str_replace('_', ' ', $key)) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="filename" placeholder="اسم الملف بدون الامتداد" value="new_code" required>
            <textarea name="content" id="templateCode"></textarea>
            <button type="submit">إنشاء ملف</button>
        </form>
    </div>
    <script>
    const templates = <?= json_encode($templates) ?>;
    function updateTemplate(val) {
        if (templates[val]) {
            document.getElementById('templateCode').value = templates[val];
        }
    }
    </script>
</body>
</html>