<?php
// Complete FS Generator
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$full_templates = [
    'admin' => <<<PAWN
// Admin FS - Complete
#define MAX_ADMIN_LEVEL 10

new PlayerAdminLevel[MAX_PLAYERS];

enum AdminCommands {
    CMD_MUTE,
    CMD_FREEZE,
    CMD_SPECTATE,
    CMD_GOTO,
    CMD_BRING,
    CMD_SLAP,
    CMD_SETTIME,
    CMD_WEATHER
}

stock SetAdminLevel(playerid, level) {
    PlayerAdminLevel[playerid] = level;
}

stock GetAdminLevel(playerid) {
    return PlayerAdminLevel[playerid];
}

stock IsAdminFS(playerid, required_level) {
    return (PlayerAdminLevel[playerid] >= required_level);
}

public OnPlayerCommandText(playerid, cmdtext[]) {
    new cmd[32], params[128];
    sscanf(cmdtext, "s[32]s[128]", cmd, params);
    
    if (IsAdminFS(playerid, 2)) {
        if (strcmp(cmd, "/mute", true) == 0) {
            // Mute player
        } else if (strcmp(cmd, "/freeze", true) == 0) {
            // Freeze player
        }
    }
    return 0;
}
PAWN,
    'factions' => <<<PAWN
// Factions FS - Complete
enum FactionTypes {
    FACTION_POLICE,
    FACTION_MEDIC,
    FACTION_GANG,
    FACTION_MECHANIC
}

new PlayerFaction[MAX_PLAYERS];
new PlayerFactionRank[MAX_PLAYERS];
new FactionSkin[FACTION_MECHANIC+1][5] = {
    {280, 281, 282, 283, 284}, // Police
    {276, 277, 278, 279}, // Medic
    {299, 298, 297, 296}, // Gang
    {591, 592, 593, 594, 595} // Mechanic
};

stock SetFaction(playerid, factionid) {
    PlayerFaction[playerid] = factionid;
}

stock GetFaction(playerid) {
    return PlayerFaction[playerid];
}

public OnPlayerConnect(playerid) {
    SetFaction(playerid, -1);
    return 1;
}
PAWN,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['template'])) {
    $template = $_POST['template'];
    $name = $_POST['fs_name'];
    
    file_put_contents(__DIR__ . "/servers/server1/filterscripts/{$name}.pwn", $full_templates[$template]);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد FS الكامل</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .fs-box { background:#16213e; padding:20px; border-radius:10px; }
        select, input { padding:10px; margin:5px 0; background:#000; color:#fff; border:1px solid #0f0; }
        button { padding:10px 15px; background:#aa5500; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="fs-box">
        <h2>مولد الفلاتر الكامل</h2>
        <form method="POST">
            <select name="template">
                <?php foreach (array_keys($full_templates) as $key): ?>
                <option value="<?= $key ?>"><?= htmlspecialchars($key) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="fs_name" placeholder="اسم الفلاتر" required>
            <button type="submit">إنشاء</button>
        </form>
    </div>
</body>
</html>