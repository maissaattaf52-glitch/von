<?php
// Complete Player System Generator
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$systems = [
    'register' => ['name' => 'نظام التسجيل', 'code' => <<<PAWN
// Player Registration System
#define REGISTER_DIALOG 1000

enum PlayerData {
    pID,
    pName,
    pPassword,
    pCash,
    pScore,
    pAdmin
}

new PlayerInfo[MAX_PLAYERS][PlayerData];

stock RegisterPlayer(playerid, password[])
{
    // Check if exists
    // Insert to database
    PlayerInfo[playerid][pCash] = 50000;
    PlayerInfo[playerid][pScore] = 0;
    SendClientMessage(playerid, 0x00FF00FF, "Registered successfully!");
}
PAWN],
    'login' => ['name' => 'نظام الدخول', 'code' => <<<PAWN
// Player Login System
stock LoginPlayer(playerid, password[])
{
    // Verify password
    // Load data from database
    SendClientMessage(playerid, 0x00FF00FF, "Logged in!");
}
PAWN],
    'save' => ['name' => 'نظام الحفظ', 'code' => <<<PAWN
// Auto Save System
#define SAVE_TIMER 120000

public OnGameModeInit()
{
    SetTimer("AutoSave", SAVE_TIMER, true);
    return 1;
}

forward AutoSave();
public AutoSave()
{
    for (new i = 0; i < MAX_PLAYERS; i++)
    {
        if (IsPlayerConnected(i))
        {
            SavePlayerData(i);
        }
    }
}

stock SavePlayerData(playerid)
{
    // Save to database
    new query[256];
    format(query, sizeof(query), "UPDATE players SET cash = %d, score = %d WHERE id = %d", 
           PlayerInfo[playerid][pCash], PlayerInfo[playerid][pScore], playerid);
    mysql_query(query);
}
PAWN],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codes = "";
    foreach ($_POST['systems'] ?? [] as $sys) {
        $codes .= $systems[$sys]['code'] . "\n\n";
    }
    file_put_contents(__DIR__ . "/servers/server1/gamemodes/player_system.pwn", $codes);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد نظام اللاعبين الكامل</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .player-box { background:#16213e; padding:20px; border-radius:10px; }
        button { padding:10px 15px; background:#0066ff; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="player-box">
        <h2>مولد نظام اللاعبين الكامل</h2>
        <form method="POST">
            <?php foreach ($systems as $key => $data): ?>
            <label><input type="checkbox" name="systems[]" value="<?= $key ?>"> <?= $data['name'] ?></label><br>
            <?php endforeach; ?>
            <button type="submit">توليد النظام الكامل</button>
        </form>
    </div>
</body>
</html>