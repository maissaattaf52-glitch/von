<?php
// Ultimate Chat System Generator
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$chat_features = [
    'me' => ['cmd' => '/me', 'desc' => 'أمر المي'],
    'do' => ['cmd' => '/do', 'desc' => 'أمر الدو'],
    'b' => ['cmd' => '/b', 'desc' => 'الكلام باللون الأزرق'],
    'w' => ['cmd' => '/w', 'desc' => 'الكلام باللون الأبيض'],
    'r' => ['cmd' => '/r', 'desc' => 'الريفع'],
    'pm' => ['cmd' => '/pm', 'desc' => 'رسالة خاصة'],
    're' => ['cmd' => '/re', 'desc' => 'الرد على الرسالة الخاصة'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = "// Chat System - Generated\n\n";
    
    foreach ($_POST['features'] ?? [] as $feat) {
        $code .= <<<PAWN
public OnPlayerCommandText(playerid, cmdtext[])
{
    if (strcmp(cmdtext, "{$chat_features[$feat]['cmd']}", true) == 0)
    {
        // {$chat_features[$feat]['desc']}
        return 1;
    }
    return 0;
}

PAWN;
    }
    
    file_put_contents(__DIR__ . "/servers/server1/gamemodes/chat_system.pwn", $code);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد نظام الدردشة النهائي</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .chat-box { background:#16213e; padding:20px; border-radius:10px; }
        button { padding:10px; background:#0066ff; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="chat-box">
        <h2>مولد نظام الدردشة النهائي</h2>
        <form method="POST">
            <?php foreach ($chat_features as $key => $data): ?>
            <label><input type="checkbox" name="features[]" value="<?= $key ?>"> <?= $data['desc'] ?> (<?= $data['cmd'] ?>)</label><br>
            <?php endforeach; ?>
            <button type="submit">توليد نظام الدردشة</button>
        </form>
    </div>
</body>
</html>