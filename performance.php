<?php
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";

function get_performance_stats($server_dir) {
    $stats = [
        'cpu' => rand(5, 50),
        'memory' => rand(100, 500),
        'disk_io' => rand(1, 20),
        'network_in' => rand(1000, 50000),
        'network_out' => rand(500, 30000),
    ];
    return $stats;
}

$perf = get_performance_stats($server_dir);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مراقبة الأداء</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .perf-box { background:#16213e; padding:20px; border-radius:10px; }
        .perf-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:15px; }
        .perf-card { background:#000; padding:15px; border-radius:5px; text-align:center; }
        .perf-value { font-size:32px; color:#0f0; margin:10px 0; }
        .perf-bar { height:10px; background:#333; border-radius:5px; overflow:hidden; }
        .perf-fill { height:100%; background:#0f0; transition:width 0.3s; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="perf-box">
        <h2>مراقبة الأداء - <?= htmlspecialchars($server_name) ?></h2>
        <div class="perf-grid">
            <div class="perf-card">
                <div>المعالج (CPU)</div>
                <div class="perf-value"><?= $perf['cpu'] ?>%</div>
                <div class="perf-bar"><div class="perf-fill" style="width:<?= $perf['cpu'] ?>%"></div></div>
            </div>
            <div class="perf-card">
                <div>الذاكرة (MB)</div>
                <div class="perf-value"><?= $perf['memory'] ?></div>
                <div class="perf-bar"><div class="perf-fill" style="width:<?= min(100, $perf['memory']/5) ?>%"></div></div>
            </div>
            <div class="perf-card">
                <div>الشبكة (bytes/s)</div>
                <div class="perf-value" id="netIn"><?= $perf['network_in'] ?></div>
                <div class="perf-bar"><div class="perf-fill" style="width:<?= min(100, $perf['network_in']/500) ?>%"></div></div>
            </div>
        </div>
        <script>
        function updatePerf() {
            fetch('api.php?action=perf&server=<?= $server_name ?>')
                .then(r => r.json())
                .then(data => {
                    if (data.cpu) document.querySelector('.perf-value').textContent = data.cpu + '%';
                });
        }
        setInterval(updatePerf, 5000);
        </script>
    </div>
</body>
</html>