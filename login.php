<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تربو هاوستينج - تسجيل الدخول</title>
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #0000ff 0%, #000033 50%, #000000 100%);
            --sidebar: #000080;
            --card: #000066;
            --text: #ffffff;
            --accent: #00ffff;
            --glow: 0 0 20px #00ffff, 0 0 40px #0088ff;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background: var(--bg-gradient); 
            color: var(--text); 
            min-height: 100vh;
            animation: bgPulse 10s infinite alternate;
        }
        @keyframes bgPulse {
            0% { filter: hue-rotate(0deg); }
            100% { filter: hue-rotate(360deg); }
        }
        .login-box { 
            width: 340px; 
            margin: 100px auto; 
            padding: 30px; 
            background: var(--card); 
            border-radius: 15px;
            border: 2px solid var(--accent);
            box-shadow: var(--glow);
        }
        .login-box h2 {
            color: var(--accent);
            text-shadow: var(--glow);
            margin-bottom: 25px;
            font-size: 28px;
        }
        .login-box input { 
            width:100%; 
            padding:12px; 
            margin:10px 0; 
            border:2px solid var(--accent); 
            border-radius:8px;
            background:#000;
            color:var(--text);
            font-size:14px;
        }
        .login-box input::placeholder {
            color:#666;
        }
        .login-box button { 
            width:100%; 
            padding:12px; 
            background:var(--sidebar); 
            color:var(--text); 
            border:2px solid var(--accent); 
            border-radius:8px; 
            cursor:pointer;
            font-weight:bold;
            font-size:16px;
            text-transform:uppercase;
            letter-spacing:1px;
            transition:all 0.3s ease;
        }
        .login-box button:hover {
            box-shadow: var(--glow);
            transform:scale(1.02);
        }
        .turbo-powered {
            text-align: center;
            margin-top: 20px;
            color: var(--accent);
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2 style="text-align:center;">🚀 تيربو هاوستينج</h2>
        <form method="POST">
            <?php if (isset($error)): ?>
            <p style="color:#ff0000; text-align:center; margin-bottom:15px;"><?= $error ?></p>
            <?php endif; ?>
            <input type="text" name="username" placeholder="اسم المستخدم" required>
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <button type="submit">دخول للوحة</button>
        </form>
        <p class="turbo-powered">⚡ مدعوم بأقوى تكنولوجيا تيربو هاوستينج ⚡</p>
    </div>
</body>
</html>