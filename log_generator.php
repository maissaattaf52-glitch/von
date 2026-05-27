<?php
// Complete Log Generator
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $log_type = $_POST['log_type'];
    $code = <<<PAWN
// Log System - {$log_type}
{$log_type}Log(playerid, action[])
{
    new query[256];
    format(query, sizeof(query), "INSERT INTO logs (player, action, time) VALUES ('%s', '%s', NOW())", 
           PlayerName[playerid], action);
    mysql_query(query);
}

public OnPlayerCommandText(playerid, cmdtext[])
{
    {$log_type}Log(playerid, cmdtext);
    return 0;
}
PAWN;
    
    file_put_contents(__DIR__ . "/servers/server1/gamemodes/log_{$log_type}.pwn", $code);
}

$log_types = ['MySQL', 'File', 'SQLite'];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد السجلات الكامل</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .log-box { background:#16213e; padding:20px; border-radius:10px; }
        button { padding:10px 15px; background:#00aa00; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="log-box">
        <h2>مولد نظام السجلات الكامل</h2>
        <form method="POST">
            <select name="log_type">
                <?php foreach ($log_types as $type): ?>
                <option value="<?= strtolower($type) ?>"><?= $type ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">توليد نظام السجلات</button>
        </form>
    </div>
</body>
</html>