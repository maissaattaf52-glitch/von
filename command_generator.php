<?php
// Command Generator for Quick Commands
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$commands = [
    'kill' => ['pattern' => '/kill [playerid]', 'handler' => 'SetPlayerHealth(playerid, 0.0);'],
    'heal' => ['pattern' => '/heal [playerid]', 'handler' => 'SetPlayerHealth(playerid, 100.0);'],
    'armour' => ['pattern' => '/armour [playerid]', 'handler' => 'SetPlayerArmour(playerid, 100.0);'],
    'weapon' => ['pattern' => '/weapon [playerid] [weaponid] [ammo]', 'handler' => 'GivePlayerWeapon(playerid, weaponid, ammo);'],
    'goto' => ['pattern' => '/goto [playerid]', 'handler' => 'SetPlayerPos(playerid, ...);'],
    'bring' => ['pattern' => '/bring [playerid]', 'handler' => 'SetPlayerPos(playerid, ...);'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['command_name'])) {
    $cmd = $_POST['command_name'];
    $pattern = $_POST['pattern'];
    $handler = $_POST['handler'];
    
    $output = <<<PAWN
// Command: {$cmd}
public OnPlayerCommandText(playerid, cmdtext[])
{
    if (strcmp(cmdtext, "{$pattern}", true) == 0)
    {
        {$handler}
        return 1;
    }
    return 0;
}
PAWN;
    
    file_put_contents(__DIR__ . "/servers/server1/gamemodes/{$cmd}.pwn", $output);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد الأوامر</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .cmd-box { background:#16213e; padding:20px; border-radius:10px; }
        input, textarea { width:100%; padding:10px; margin:5px 0; background:#000; color:#fff; border:1px solid #0f0; }
        button { padding:10px 15px; background:#0f3460; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="cmd-box">
        <h2>مولد الأوامر السريعة</h2>
        <form method="POST">
            <input type="text" name="command_name" placeholder="اسم الأمر (مثلاً: kill)" required>
            <input type="text" name="pattern" placeholder="نمط الأمر (مثلاً: /kill [playerid])" required>
            <textarea name="handler" placeholder="كود التنفيذ..." required></textarea>
            <button type="submit">إنشاء الأمر</button>
        </form>
    </div>
</body>
</html>