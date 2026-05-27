<?php
// Turbo Logger - Advanced Logging System
session_start();

$log_types = [
    'INFO' => ['icon' => 'ℹ️', 'color' => '#00FFFF', 'label' => 'معلومات'],
    'SUCCESS' => ['icon' => '✅', 'color' => '#00FF00', 'label' => 'نجاح'],
    'WARNING' => ['icon' => '⚠️', 'color' => '#FFFF00', 'label' => 'تحذير'],
    'ERROR' => ['icon' => '❌', 'color' => '#FF0000', 'label' => 'خطأ'],
    'TURBO' => ['icon' => '🚀', 'color' => '#FF00FF', 'label' => 'تيربو'],
];

function log_turbo($message, $type = 'INFO', $file = 'turbo.log') {
    $log_dir = __DIR__ . '/logs';
    if (!is_dir($log_dir)) mkdir($log_dir, 0755, true);
    
    $log_entry = date('[Y-m-d H:i:s] ') . "[{$type}] " . $message . "\n";
    file_put_contents("{$log_dir}/{$file}", $log_entry, FILE_APPEND);
}

function read_turbo_logs($file = 'turbo.log', $lines = 100) {
    $log_file = __DIR__ . "/logs/{$file}";
    if (!file_exists($log_file)) return [];
    
    $content = file($log_file);
    return array_slice($content, -$lines);
}

function get_log_stats() {
    $log_dir = __DIR__ . '/logs';
    $stats = [
        'total_logs' => 0,
        'total_size' => 0,
        'today_logs' => 0
    ];
    
    foreach (glob("{$log_dir}/*.log") as $log) {
        $stats['total_logs']++;
        $stats['total_size'] += filesize($log);
        if (filemtime($log) > strtotime('today')) {
            $stats['today_logs']++;
        }
    }
    
    return $stats;
}

// Write initial logs
log_turbo("تم تحميل نظام التيربو لوجر!", 'TURBO');
log_turbo("جاهز للاتصال بأقصى سرعة", 'INFO');
log_turbo("MAXIMUM PERFORMANCE MODE ACTIVATED", 'SUCCESS');

$log_stats = get_log_stats();
$recent_logs = read_turbo_logs();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 تيربو لوقر - لوحة التحكم الاحترافية</title>
    <style>
        :root {
            --turbo-blue: #0000FF;
            --turbo-dark-blue: #000033;
            --turbo-black: #000000;
            --turbo-cyan: #00FFFF;
            --turbo-magenta: #FF00FF;
            --turbo-green: #00FF00;
            --turbo-yellow: #FFFF00;
            --turbo-red: #FF0000;
            --neon-glow: 0 0 20px #00FFFF, 0 0 40px #0088FF;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background: linear-gradient(135deg, var(--turbo-blue) 0%, var(--turbo-dark-blue) 50%, var(--turbo-black) 100%); 
            color: #fff;
            min-height: 100vh;
            padding: 20px;
        }
        .log-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .log-header {
            background: rgba(0, 0, 102, 0.8);
            padding: 25px;
            border-radius: 15px;
            border: 2px solid var(--turbo-cyan);
            margin-bottom: 20px;
            box-shadow: var(--neon-glow);
        }
        .log-header h1 {
            color: var(--turbo-cyan);
            text-shadow: var(--neon-glow);
            margin-bottom: 10px;
        }
        .log-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .stat-item {
            background: #000;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid var(--turbo-cyan);
        }
        .stat-value {
            font-size: 28px;
            color: var(--turbo-cyan);
            font-weight: bold;
            text-shadow: var(--neon-glow);
        }
        .stat-label {
            font-size: 14px;
            color: #aaa;
            margin-top: 5px;
        }
        .log-content {
            background: rgba(0, 0, 102, 0.8);
            border-radius: 15px;
            padding: 20px;
            border: 2px solid var(--turbo-cyan);
            box-shadow: var(--neon-glow);
            max-height: 60vh;
            overflow-y: auto;
        }
        .log-line {
            padding: 8px;
            margin: 5px 0;
            background: #000;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            border-right: 3px solid var(--turbo-cyan);
            transition: all 0.3s ease;
        }
        .log-line:hover {
            box-shadow: var(--neon-glow);
        }
        .log-type {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: bold;
            margin-left: 10px;
        }
        .log-turbo { color: var(--turbo-magenta); background: rgba(255,0,255,0.2); }
        .log-success { color: var(--turbo-green); background: rgba(0,255,0,0.2); }
        .log-warning { color: var(--turbo-yellow); background: rgba(255,255,0,0.2); }
        .log-error { color: var(--turbo-red); background: rgba(255,0,0,0.2); }
        .log-info { color: var(--turbo-cyan); background: rgba(0,255,255,0.2); }
        .log-controls {
            margin: 20px 0;
            display: flex;
            gap: 10px;
        }
        .log-controls input, .log-controls button {
            padding: 10px;
            background: #000;
            color: var(--turbo-cyan);
            border: 2px solid var(--turbo-cyan);
            border-radius: 8px;
            font-family: monospace;
        }
        .log-controls button {
            background: var(--turbo-cyan);
            color: #000;
            font-weight: bold;
            cursor: pointer;
        }
        .log-controls button:hover {
            box-shadow: var(--neon-glow);
        }
        a { color: var(--turbo-cyan); text-decoration: none; }
        a:hover { text-shadow: var(--neon-glow); }
    </style>
</head>
<body>
    <div class="log-container">
        <div class="log-header">
            <h1>📝 تيربو لوقر - نظام التسجيل الاحترافي</h1>
            <p>مراقبة كاملة للوحة التحكم - TURBO HOSTING</p>
            
            <div class="log-stats">
                <div class="stat-item">
                    <div class="stat-value"><?= $log_stats['total_logs'] ?></div>
                    <div class="stat-label">📁 إجمالي السجلات</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?= round($log_stats['total_size']/1024, 1) ?> KB</div>
                    <div class="stat-label">💾 حجم السجلات</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?= $log_stats['today_logs'] ?></div>
                    <div class="stat-label">📅 سجلات اليوم</div>
                </div>
            </div>
        </div>
        
        <div class="log-controls">
            <input type="text" placeholder="بحث في السجلات..." id="searchInput">
            <button onclick="location.reload()">🔄 تحديث السجلات</button>
            <button onclick="downloadLogs()">💾 تحميل السجلات</button>
        </div>
        
        <div class="log-content" id="logContent">
            <?php foreach ($recent_logs as $log): 
                $log_type = strpos($log, '[TURBO]') ? 'log-turbo' : 
                          (strpos($log, '[SUCCESS]') ? 'log-success' : 
                          (strpos($log, '[WARNING]') ? 'log-warning' : 
                          (strpos($log, '[ERROR]') ? 'log-error' : 'log-info')));
            ?>
            <div class="log-line <?= $log_type ?>"><?= htmlspecialchars($log) ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <script>
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const search = e.target.value.toLowerCase();
            document.querySelectorAll('.log-line').forEach(line => {
                line.style.display = line.textContent.toLowerCase().includes(search) ? 'block' : 'none';
            });
        });
        
        function downloadLogs() {
            alert('🚀 سيتم تحميل السجلات قريباً!');
        }
        
        // Auto scroll to bottom
        const logContent = document.getElementById('logContent');
        logContent.scrollTop = logContent.scrollHeight;
    </script>
</body>
</html>