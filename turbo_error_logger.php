<?php
// Turbo Error Logger - Professional Error Tracking
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/themes.php';

$log_dir = __DIR__ . '/logs';
if (!is_dir($log_dir)) mkdir($log_dir, 0755, true);

$error_log = "{$log_dir}/errors_turbo.log";
$access_log = "{$log_dir}/access_turbo.log";
$security_log = "{$log_dir}/security_turbo.log";

function log_error($message, $file = 'errors_turbo.log') {
    global $log_dir;
    $entry = date('[Y-m-d H:i:s] ') . "🚨 " . $message . "\n";
    file_put_contents("{$log_dir}/{$file}", $entry, FILE_APPEND);
}

function log_access($message, $file = 'access_turbo.log') {
    global $log_dir;
    $entry = date('[Y-m-d H:i:s] ') . "🌐 " . $_SERVER['REMOTE_ADDR'] . " - " . $message . "\n";
    file_put_contents("{$log_dir}/{$file}", $entry, FILE_APPEND);
}

function log_security($message, $file = 'security_turbo.log') {
    global $log_dir;
    $entry = date('[Y-m-d H:i:s] ') . "🛡️ " . $message . "\n";
    file_put_contents("{$log_dir}/{$file}", $entry, FILE_APPEND);
}

// Log current access
log_access("تم الوصول للوحة التحكم");

$theme = apply_turbo_theme();

// Get log sizes
$log_stats = [
    'errors' => file_exists($error_log) ? filesize($error_log) : 0,
    'access' => file_exists($access_log) ? filesize($access_log) : 0,
    'security' => file_exists($security_log) ? filesize($security_log) : 0,
];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>🚨 تيربو لوغر - تسجيل الأخطاء</title>
    <style>
        :root {
            --turbo-blue: #0000FF;
            --turbo-dark-blue: #000033;
            --turbo-black: #000000;
            --turbo-cyan: #00FFFF;
            --turbo-magenta: #FF00FF;
            --turbo-green: #00FF00;
            --turbo-red: #FF0000;
            --neon-glow: 0 0 20px #00FFFF, 0 0 40px #0088FF;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background: linear-gradient(135deg, var(--turbo-blue) 0%, var(--turbo-dark-blue) 50%, var(--turbo-black) 100%); 
            color: #fff;
            min-height: 100vh;
            padding: 20px;
        }
        .log-section {
            background: rgba(0, 0, 102, 0.8);
            padding: 20px;
            border-radius: 15px;
            border: 2px solid var(--turbo-cyan);
            margin: 15px 0;
            box-shadow: var(--neon-glow);
        }
        .log-section h2 {
            color: var(--turbo-cyan);
            text-shadow: var(--neon-glow);
            margin-bottom: 15px;
        }
        .log-entry {
            padding: 10px;
            margin: 5px 0;
            background: #000;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
            border-right: 3px solid var(--turbo-red);
        }
        .log-entry.success { border-right-color: var(--turbo-green); }
        .log-entry.security { border-right-color: var(--turbo-magenta); }
        .stat-box {
            display: inline-block;
            padding: 10px 20px;
            background: #000;
            border-radius: 10px;
            margin: 5px;
            border: 1px solid var(--turbo-cyan);
        }
        a { color: var(--turbo-cyan); text-decoration: none; }
    </style>
</head>
<body>
    <a href="turbo_housting.php">🏠 العودة للوحة التحكم</a>
    
    <div class="log-section">
        <h2>🚨 تيربو لوغر - تسجيل الأخطاء الاحترافي</h2>
        
        <div class="stat-box">🐛 أخطاء النظام: <?= round($log_stats['errors']/1024, 1) ?> KB</div>
        <div class="stat-box">🌐 طلبات الوصول: <?= round($log_stats['access']/1024, 1) ?> KB</div>
        <div class="stat-box">🛡️ أحداث الأمان: <?= round($log_stats['security']/1024, 1) ?> KB</div>
    </div>
    
    <div class="log-section">
        <h2>🛡️ سجلات الأمان الأخيرة</h2>
        <?php 
        $sec_logs = file_exists($security_log) ? array_slice(file($security_log), -10) : ['لا توجد سجلات أمان'];
        foreach ($sec_logs as $log): ?>
        <div class="log-entry security"><?= htmlspecialchars($log) ?></div>
        <?php endforeach; ?>
    </div>
    
    <div class="log-section">
        <h2>🌐 سجلات الوصول الأخيرة</h2>
        <?php 
        $acc_logs = file_exists($access_log) ? array_slice(file($access_log), -10) : ['لا توجد سجلات وصول'];
        foreach ($acc_logs as $log): ?>
        <div class="log-entry success"><?= htmlspecialchars($log) ?></div>
        <?php endforeach; ?>
    </div>
</body>
</html>