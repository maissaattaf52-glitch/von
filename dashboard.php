<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تربو هاوستينج - لوحة التحكم الاحترافية</title>
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #0000ff 0%, #000033 50%, #000000 100%);
            --sidebar: #000080;
            --card: #000066;
            --text: #ffffff;
            --accent: #00ffff;
            --success: #00ff00;
            --warning: #ffff00;
            --danger: #ff0000;
            --glow: 0 0 20px #00ffff, 0 0 40px #0088ff;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background: var(--bg-gradient); 
            color: var(--text);
            min-height: 100vh;
            animation: bgPulse 15s infinite alternate;
        }
        @keyframes bgPulse {
            0% { filter: hue-rotate(0deg); }
            100% { filter: hue-rotate(360deg); }
        }
        .sidebar { 
            width: 260px; 
            height: 100vh; 
            background: var(--sidebar); 
            float: right; 
            padding: 20px; 
            position: fixed;
            box-shadow: 5px 0 25px rgba(0,0,255,0.5);
        }
        .sidebar h2 { 
            margin-bottom: 20px; 
            color: var(--accent);
            text-shadow: var(--glow);
            font-size: 24px;
            text-align: center;
        }
        .sidebar ul { list-style: none; }
        .sidebar li { margin: 8px 0; }
        .sidebar a { 
            color: var(--text); 
            text-decoration: none; 
            padding: 12px 15px; 
            display: block; 
            border-radius: 8px; 
            transition: all 0.3s ease;
            border-right: 3px solid transparent;
        }
        .sidebar a:hover { 
            background: var(--card);
            border-right-color: var(--accent);
            transform: translateX(-5px);
            box-shadow: var(--glow);
        }
        .main { margin-right: 280px; padding: 20px; }
        .header {
            background: var(--card);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            border: 2px solid var(--accent);
            box-shadow: var(--glow);
        }
        .header h1 {
            color: var(--accent);
            text-shadow: var(--glow);
            margin-bottom: 10px;
        }
        .server-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .server-card { 
            background: var(--card); 
            padding: 20px; 
            margin: 10px 0; 
            border-radius: 15px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            border: 2px solid var(--accent);
            transition: all 0.3s ease;
            animation: cardGlow 2s infinite alternate;
        }
        @keyframes cardGlow {
            0% { box-shadow: 0 0 10px rgba(0,255,255,0.3); }
            100% { box-shadow: 0 0 30px rgba(0,255,255,0.6); }
        }
        .server-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--glow);
        }
        .status-online { 
            color: var(--success); 
            text-shadow: 0 0 10px var(--success);
            font-weight: bold;
        }
        .status-offline { 
            color: var(--danger); 
            text-shadow: 0 0 10px var(--danger);
            font-weight: bold;
        }
        .btn { 
            padding: 10px 20px; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            margin: 5px; 
            transition: all 0.3s ease;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-start { background: var(--success); color: #000; }
        .btn-stop { background: var(--danger); color: #fff; }
        .btn-restart { background: var(--warning); color: #000; }
        .btn:hover {
            transform: scale(1.1);
            box-shadow: var(--glow);
        }
        .console { 
            background: #000; 
            color: var(--success); 
            padding: 15px; 
            height: 400px; 
            overflow-y: auto; 
            font-family: 'Courier New', monospace; 
            border-radius: 10px; 
            margin-top: 20px;
            border: 2px solid var(--accent);
        }
        .console-output {
            animation: typeIn 0.1s ease-out;
        }
        @keyframes typeIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .command-form { margin-top: 10px; display: flex; gap: 10px; }
        .command-form input { 
            flex: 1; 
            padding: 12px; 
            background: #000; 
            color: var(--success); 
            border: 2px solid var(--accent); 
            border-radius: 8px;
            font-family: monospace;
            font-size: 14px;
        }
        .command-form button { 
            padding: 12px 25px; 
            background: var(--sidebar); 
            color: var(--text); 
            border: 2px solid var(--accent); 
            border-radius: 8px; 
            cursor: pointer;
            font-weight: bold;
        }
        .logout { 
            position: fixed; 
            top: 20px; 
            left: 20px; 
            background: var(--danger); 
            color: #fff; 
            padding: 10px 20px; 
            text-decoration: none; 
            border-radius: 8px;
            z-index: 1000;
            border: 2px solid var(--accent);
        }
        .turbo-badge {
            display: inline-block;
            background: linear-gradient(45deg, var(--accent), #ff00ff);
            color: #000;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <a href="?action=logout" class="logout">تسجيل الخروج</a>
    <div class="sidebar">
        <h2>🚀 تيربو هاوستينج</h2>
        <ul>
            <li><a href="turbo_housting.php">🏠 الرئيسية</a></li>
            <li><a href="?action=install">🚀 إنشاء خادم جديد</a></li>
            <li><a href="files.php?server=<?= $server_name ?>">📁 إدارة الملفات</a></li>
            <li><a href="editor.php?server=<?= $server_name ?>">💻 محرر الأكواد</a></li>
            <li><a href="plugins.php?server=<?= $server_name ?>">🔌 الإضافات</a></li>
            <li><a href="commands.php?server=<?= $server_name ?>">⚡ الأوامر السريعة</a></li>
            <li><a href="players.php?server=<?= $server_name ?>">👥 اللاعبين</a></li>
            <li><a href="stats.php">📊 الإحصائيات</a></li>
            <li><a href="backup.php?server=<?= $server_name ?>">💾 النسخ الاحتياطية</a></li>
            <li><a href="rules.php?server=<?= $server_name ?>">📜 القوانين</a></li>
            <li><a href="settings.php?server=<?= $server_name ?>">⚙️ الإعدادات</a></li>
            <li><a href="maps.php?server=<?= $server_name ?>">🗺️ الخرائط</a></li>
            <li><a href="templates.php?server=<?= $server_name ?>">📋 قوالب الأكواد</a></li>
            <li><a href="messages.php?server=<?= $server_name ?>">📩 الرسائل</a></li>
            <li><a href="notifications.php?server=<?= $server_name ?>">🔔 الإشعارات</a></li>
            <li><a href="activity_log.php">📝 سجل النشاط</a></li>
        </ul>
        <h3 style="margin-top:30px; color:var(--accent);">🌐 الخوادم</h3>
        <ul>
            <?php foreach (list_servers() as $srv): ?>
            <li><a href="index.php?server=<?= $srv ?>"><?= htmlspecialchars($srv) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="main">
        <div class="header">
            <h1><span class="turbo-badge">TURBO</span>إدارة الخوادم</h1>
        </div>
        <?php foreach (list_servers() as $srv): ?>
        <div class="server-card">
            <div>
                <h3 style="color:var(--accent);"><?= htmlspecialchars($srv) ?></h3>
                <p>الحالة: <span class="<?= get_server_status($srv)['status'] === 'online' ? 'status-online' : 'status-offline' ?>">
                    <?= get_server_status($srv)['status'] === 'online' ? '🟢 متصل' : '🔴 معطل' ?>
                </span> | اللاعبين: <?= get_server_status($srv)['players'] ?></p>
            </div>
            <div>
                <a href="?action=start&server=<?= $srv ?>" class="btn btn-start">تشغيل</a>
                <a href="?action=stop&server=<?= $srv ?>" class="btn btn-stop">إيقاف</a>
                <a href="?action=restart&server=<?= $srv ?>" class="btn btn-restart">إعادة تشغيل</a>
            </div>
        </div>
        <?php endforeach; ?>

        <h2 style="margin-top:30px; color:var(--accent);">🖥️ الكونسول</h2>
        <div class="console" id="console">
            <?php if (isset($response)): ?>
            <div class="console-output"><?= htmlspecialchars($response) ?></div>
            <?php endif; ?>
        </div>
        <form method="POST" class="command-form">
            <input type="hidden" name="action" value="command">
            <input type="text" name="command" placeholder="أدخل الأمر هنا... (مثال: /players, /kick)" required>
            <button type="submit">إرسال</button>
        </form>
    </div>
    <script>
        const console = document.getElementById('console');
        console.scrollTop = console.scrollHeight;
    </script>
</body>
</html>