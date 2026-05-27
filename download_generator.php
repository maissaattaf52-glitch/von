<?php
// Loading Screen Generator for SA-MP
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download'])) {
    $server_name = $_GET['server'] ?? $config['default_server'];
    $server_dir = __DIR__ . "/servers/{$server_name}";
    
    $dlc = <<<PAWN
// Loading Screen by SA-MP Panel
#define DOWNLOAD_MESSAGE "Loading..."

public OnPlayerConnect(playerid)
{
    ShowPlayerDialog(playerid, 1, DIALOG_STYLE_MSGBOX, "Loading", DOWNLOAD_MESSAGE, "OK", "");
    SetTimerEx("PlayerLoaded", 5000, false, "i", playerid);
    return 1;
}

forward PlayerLoaded(playerid);
public PlayerLoaded(playerid)
{
    // Player ready
}
PAWN;
    
    file_put_contents("{$server_dir}/gamemodes/loading.pwn", $dlc);
    file_put_contents("{$server_dir}/download_url.txt", $_POST['url'] ?? '');
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد شاشة التحميل</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .dlc-box { background:#16213e; padding:20px; border-radius:10px; }
        input { width:100%; padding:10px; margin:5px 0; background:#000; color:#fff; border:1px solid #0f0; }
        button { padding:10px; background:#0066ff; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="dlc-box">
        <h2>مولد شاشة التحميل (Download)</h2>
        <form method="POST">
            <input type="url" name="url" placeholder="رابط تحميل الملفات" required>
            <button type="submit" name="download">إنشاء نظام التحميل</button>
        </form>
    </div>
</body>
</html>