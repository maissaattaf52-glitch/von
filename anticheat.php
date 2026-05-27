<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/themes.php';
if (!isset($_SESSION['logged_in'])) exit;

$ac_types = [
    'weapon' => '🔫 كشف ذخاخ الأسلحة',
    'health' => '❤️ كشف ذخاخ الصحة',
    'ammo' => '🔫 كشف الذخاخ اللانهائية',
    'teleport' => '🌀 كشف ذخاخ التيليبورت',
    'speed' => '⚡ كشف ذخاخ السرعة',
    'fly' => '✈️ كشف ذخاخ الطيران',
    'money' => '💰 كشف ذخاخ المال',
    'vehicle' => '🚗 كشف ذخاخ المركبات',
    'armor' => '🦺 كشف ذخاخ الدرع',
    'flood' => '🌊 كشف الفيضان الرسائل',
];

$theme = apply_turbo_theme();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ac_type'])) {
    $type = $_POST['ac_type'];
    $code = generate_ac_code($type, $_POST['params'] ?? []);
    file_put_contents(__DIR__ . "/servers/server1/gamemodes/anticheat_{$type}_turbo.pwn", $code);
}

function generate_ac_code($type, $params) {
    $templates = [
        'weapon' => <<<PAWN
// Weapon Hack Detector - TURBO HOSTING EDITION
new LastWeapon[MAX_PLAYERS];
new WeaponTicks[MAX_PLAYERS];
new WeaponCount[MAX_PLAYERS];

public OnPlayerWeaponShot(playerid, weaponid, ammo, clip, hittype, hitid, fX, fY, fZ)
{
    new tick = GetTickCount();
    if (tick - WeaponTicks[playerid] < 30)
    {
        // Suspicious rapid fire - TURBO DETECTION
        WeaponCount[playerid]++;
        if (WeaponCount[playerid] > 10) {
            SendClientMessage(playerid, 0xFF0000FF, "🛑 تم الكشف عن ذخاخ! - TURBO ANTICHEAT");
            BanPlayer(playerid);
            return 0;
        }
    }
    WeaponTicks[playerid] = tick;
    WeaponCount[playerid] = 0;
    return 1;
}

public OnPlayerConnect(playerid) {
    WeaponCount[playerid] = 0;
}
PAWN,
        'health' => <<<PAWN
// Health Hack Detector - TURBO HOSTING EDITION
#define MAX_HEALTH_VALUE 100.0
#define MIN_HEALTH_VALUE 0.0

public OnPlayerUpdate(playerid)
{
    new Float:health;
    GetPlayerHealth(playerid, health);
    
    if (health > MAX_HEALTH_VALUE || health < MIN_HEALTH_VALUE)
    {
        // Invalid health value - TURBO CORRECTION
        SetPlayerHealth(playerid, MAX_HEALTH_VALUE);
        SendClientMessage(playerid, 0xFF0000FF, "🛑 تم تصحيح الصحة تلقائياً!");
        return 0;
    }
    return 1;
}
PAWN,
        'ammo' => <<<PAWN
// Infinite Ammo Detector - TURBO HOSTING EDITION
new AmmoCount[MAX_PLAYERS][57];

public OnPlayerUpdate(playerid) {
    for (new w = 0; w < 57; w++) {
        new ammo = GetPlayerAmmo(playerid, w);
        if (ammo > 9999) {
            SendClientMessage(playerid, 0xFF0000FF, "🛑 ذخاخ الذخاخ اللانهائية!");
            SetPlayerAmmo(playerid, w, AmmoCount[playerid][w]);
            return 0;
        }
        AmmoCount[playerid][w] = ammo;
    }
    return 1;
}
PAWN,
        'teleport' => <<<PAWN
// Teleport Hack Detector - TURBO HOSTING EDITION
new Float:LastPos[MAX_PLAYERS][3];
new Float:LastVelocity[MAX_PLAYERS];

public OnPlayerUpdate(playerid) {
    new Float:x, Float:y, Float:z;
    GetPlayerPos(playerid, x, y, z);
    
    new Float:distance = VectorSize(
        x - LastPos[playerid][0],
        y - LastPos[playerid][1],
        z - LastPos[playerid][2]
    );
    
    if (distance > 50.0 && !IsPlayerInAnyVehicle(playerid)) {
        SendClientMessage(playerid, 0xFF0000FF, "🛑 تم الكشف عن ذخاخ تيليبورت!");
        SetPlayerPos(playerid, LastPos[playerid][0], LastPos[playerid][1], LastPos[playerid][2]);
        return 0;
    }
    
    LastPos[playerid][0] = x;
    LastPos[playerid][1] = y;
    LastPos[playerid][2] = z;
    return 1;
}
PAWN,
        'speed' => <<<PAWN
// Speed Hack Detector - TURBO HOSTING EDITION
new Float:SpeedTick[MAX_PLAYERS];
#define MAX_SPEED 250.0

public OnPlayerUpdate(playerid) {
    new tick = GetTickCount();
    if (tick - SpeedTick[playerid] > 1000) {
        new Float:velocity;
        GetPlayerVelocity(playerid, velocity, 1);
        
        if (velocity > MAX_SPEED && !IsPlayerInAnyVehicle(playerid)) {
            SendClientMessage(playerid, 0xFF0000FF, "🛑 تم الكشف عن ذخاخ السرعة!");
            ResetPlayerWeaponFiringRate(playerid);
        }
        SpeedTick[playerid] = tick;
    }
    return 1;
}
PAWN,
    ];
    
    return $templates[$type] ?? '// No template available';
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>🛡️ مولد Anti-Cheat - تيربو هاوستينج</title>
    <style>
        :root {
            --bg-gradient: <?= $theme['bg_gradient'] ?>;
            --card: <?= $theme['card'] ?>;
            --text: <?= $theme['text'] ?>;
            --accent: <?= $theme['accent'] ?>;
            --success: <?= $theme['success'] ?>;
            --danger: <?= $theme['danger'] ?>;
            --glow: <?= $theme['glow'] ?>;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background: var(--bg-gradient); 
            color: var(--text); 
            padding: 20px;
            min-height: 100vh;
        }
        .ac-box { 
            background: var(--card); 
            padding: 25px; 
            border-radius: 15px;
            border: 2px solid var(--accent);
            box-shadow: var(--glow);
        }
        .cmd-option {
            display: flex;
            align-items: center;
            padding: 15px;
            margin: 8px 0;
            background: #000;
            border-radius: 8px;
            border-right: 3px solid var(--accent);
            transition: all 0.3s ease;
        }
        .cmd-option:hover {
            box-shadow: var(--glow);
        }
        .cmd-option input[type="radio"] {
            margin-left: 10px;
            width: 18px;
            height: 18px;
        }
        select, button { 
            padding: 12px; 
            background: #000; 
            color: var(--text); 
            border: 2px solid var(--accent);
            border-radius: 8px;
            font-size: 14px;
        }
        button {
            background: var(--danger);
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        button:hover {
            box-shadow: var(--glow);
            transform: scale(1.05);
        }
        h2 {
            color: var(--accent);
            text-shadow: var(--glow);
            margin-bottom: 20px;
        }
        a {
            color: var(--accent);
            text-decoration: none;
        }
        a:hover {
            text-shadow: var(--glow);
        }
    </style>
</head>
<body>
    <a href="turbo_housting.php">🏠 العودة للوحة التحكم</a>
    <div class="ac-box">
        <h2>🛡️ مولد Anti-Cheat النهائي - تيربو هاوستينج</h2>
        <form method="POST">
            <?php foreach ($ac_types as $key => $desc): ?>
            <label class="cmd-option">
                <input type="radio" name="ac_type" value="<?= $key ?>" required>
                <span><?= htmlspecialchars($desc) ?></span>
            </label>
            <?php endforeach; ?>
            <button type="submit">🚀 توليد كود الـ Anti-Cheat</button>
        </form>
    </div>
</body>
</html>