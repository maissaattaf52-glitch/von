<?php
// SSL Certificate Manager
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$server_name = $_GET['server'] ?? $config['default_server'];
$ssl_dir = __DIR__ . "/servers/{$server_name}/ssl";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['cert_file'], $_FILES['key_file'])) {
    if (!is_dir($ssl_dir)) mkdir($ssl_dir, 0755, true);
    move_uploaded_file($_FILES['cert_file']['tmp_name'], "{$ssl_dir}/cert.pem");
    move_uploaded_file($_FILES['key_file']['tmp_name'], "{$ssl_dir}/key.pem");
    $message = "تم رفع الشهادات";
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>شهادات SSL</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .ssl-box { background:#16213e; padding:20px; border-radius:10px; }
        input { padding:8px; margin:5px; background:#000; color:#fff; border:1px solid #0f0; }
        button { padding:8px 12px; background:#00aa00; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="ssl-box">
        <h2>شهادات SSL - <?= htmlspecialchars($server_name) ?></h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="cert_file" accept=".pem,.crt" required>
            <input type="file" name="key_file" accept=".pem,.key" required>
            <button type="submit">رفع الشهادات</button>
        </form>
    </div>
</body>
</html>