<?php
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$server_name = $_GET['server'] ?? $config['default_server'];

$messages = [
    ['from' => 'System', 'message' => 'مرحباً بك في لوحة التحكم', 'time' => date('H:i')],
    ['from' => 'Admin', 'message' => 'تم تشغيل الخادم', 'time' => date('H:i', strtotime('-5 min'))],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    // Save message to file
    $msg_data = ['from' => 'Admin', 'message' => $_POST['message'], 'time' => date('H:i')];
    file_put_contents(__DIR__ . "/logs/messages.log", json_encode($msg_data) . "\n", FILE_APPEND);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الرسائل الداخلية</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .chat-box { background:#16213e; padding:20px; border-radius:10px; height:400px; overflow-y:auto; }
        .message { margin:10px 0; padding:10px; background:#000; border-radius:5px; }
        .message .from { color:#0f0; font-weight:bold; }
        .msg-form { margin-top:20px; display:flex; gap:10px; }
        .msg-form input { flex:1; padding:10px; background:#000; color:#fff; border:1px solid #0f0; }
        .msg-form button { padding:10px 20px; background:#0f3460; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="chat-box" id="chatBox">
        <?php foreach ($messages as $msg): ?>
        <div class="message">
            <span class="from"><?= htmlspecialchars($msg['from']) ?>:</span>
            <?= htmlspecialchars($msg['message']) ?>
            <small style="float:left;color:#888;"><?= $msg['time'] ?></small>
        </div>
        <?php endforeach; ?>
    </div>
    <form method="POST" class="msg-form">
        <input type="text" name="message" placeholder="اكتب رسالة..." required>
        <button type="submit">إرسال</button>
    </form>
    <script>
        document.getElementById('chatBox').scrollTop = 9999;
    </script>
</body>
</html>