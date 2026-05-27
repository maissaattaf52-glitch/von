<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سجل النشاط</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .log-box { background:#16213e; padding:20px; border-radius:10px; }
        .log-entry { padding:10px; background:#000; margin:5px 0; border-radius:5px; font-family:monospace; font-size:12px; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="log-box">
        <h2>سجل النشاط</h2>
        <?php foreach (get_activity_logs() as $log): ?>
        <div class="log-entry">
            [<?= $log->timestamp ?? '' ?>] <?= htmlspecialchars($log->action ?? '') ?> - خادم: <?= htmlspecialchars($log->server ?? '') ?> - IP: <?= htmlspecialchars($log->ip ?? '') ?>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>