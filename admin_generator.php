<?php
// Admin System Generator
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$ranks = [
    'player' => ['level' => 0, 'color' => 0xFFFFFF],
    'helper' => ['level' => 1, 'color' => 0x00FF00],
    'admin' => ['level' => 2, 'color' => 0xFF0000],
    'owner' => ['level' => 3, 'color' => 0xFFFF00],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = <<<PAWN
// Admin System
enum AdminRanks { 
    PLAYER,
    HELPER,
    ADMIN,
    OWNER
}

new PlayerRank[MAX_PLAYERS] = {PLAYER, ...};

stock IsAdmin(playerid)
{
    return (PlayerRank[playerid] >= HELPER);
}

stock IsOwner(playerid)
{
    return (PlayerRank[playerid] == OWNER);
}

stock SendAdminMessage(color, message[])
{
    for (new i = 0; i < MAX_PLAYERS; i++)
    {
        if (IsPlayerAdmin(i))
        {
            SendClientMessage(i, color, message);
        }
    }
}

public OnPlayerConnect(playerid)
{
    // Check admin from database
    return 1;
}
PAWN;
    
    file_put_contents(__DIR__ . "/servers/server1/gamemodes/admin_system.pwn", $code);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد نظام الإدارة</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .admin-box { background:#16213e; padding:20px; border-radius:10px; }
        button { padding:10px 15px; background:#aa0000; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="admin-box">
        <h2>مولد نظام الإدارة (Admin System)</h2>
        <form method="POST">
            <button type="submit">توليد نظام الإدارة الكامل</button>
        </form>
    </div>
</body>
</html>