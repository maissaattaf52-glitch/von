<?php
require_once __DIR__ . '/config.php';
$secret = enable_2fa('admin');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>المصادقة الثنائية</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; text-align:center; }
        .verify-box { background:#16213e; padding:40px; border-radius:10px; max-width:400px; margin:50px auto; }
        input { padding:15px; font-size:24px; text-align:center; width:200px; background:#000; color:#fff; border:2px solid #0f0; }
        button { padding:15px 30px; font-size:18px; background:#0f3460; color:#fff; border:none; cursor:pointer; margin-top:10px; }
    </style>
</head>
<body>
    <div class="verify-box">
        <h2>المصادقة الثنائية</h2>
        <p>رمز التحقق: <strong><?= $secret ?></strong></p>
        <form method="POST">
            <input type="text" name="code" placeholder="000000" maxlength="6" required>
            <br><button type="submit">تحقق</button>
        </form>
    </div>
</body>
</html>