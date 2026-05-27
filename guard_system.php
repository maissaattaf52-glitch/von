<?php
// Ultimate Guard System Generator - Anti-Cheat Protection
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$guard_options = [
    'flyhack' => ['name' => 'حجب الطيرة', 'code' => <<<PAWN
// Fly Hack Detection
new Float:LastZ[MAX_PLAYERS];
new LastTick[MAX_PLAYERS];

public OnPlayerUpdate(playerid)
{
    new tick = GetTickCount();
    new Float:x, Float:y, Float:z;
    GetPlayerPos(playerid, x, y, z);
    
    if (tick - LastTick[playerid] > 0)
    {
        Float:speed = (z - LastZ[playerid]) * 1000 / (tick - LastTick[playerid]);
        if (speed > 50.0)
        {
            // Too fast up - possible flyhack
            SetPlayerPos(playerid, x, y, LastZ[playerid]);
        }
    }
    
    LastZ[playerid] = z;
    LastTick[playerid] = tick;
    return 1;
}
PAWN],
    'weaponhack' => ['name' => 'حجب الذخائر', 'code' => <<<PAWN
// Weapon Hack Prevention
new LastAmmo[MAX_PLAYERS][50];
new AmmoResetTick[MAX_PLAYERS];

public OnPlayerWeaponShot(playerid, weaponid, ammo, clip, hittype, hitid, fX, fY, fZ)
{
    if (ammo < 0 && LastAmmo[playerid][weaponid] > 1000)
    {
        // Infinite ammo hack detected
        ResetPlayerWeapons(playerid);
        return 0;
    }
    LastAmmo[playerid][weaponid] = ammo;
    return 1;
}
PAWN],
    'teleport' => ['name' => 'منع التليب', 'code' => <<<PAWN
// Teleport Hack Prevention
new Float:LastPos[MAX_PLAYERS][3];
new Tick[MAX_PLAYERS];

public OnPlayerUpdate(playerid)
{
    new tick = GetTickCount();
    new Float:x, Float:y, Float:z;
    GetPlayerPos(playerid, x, y, z);
    
    Float:dist = VectorSize(x - LastPos[playerid][0], y - LastPos[playerid][1], z - LastPos[playerid][2]);
    if (dist > 50.0 && tick - Tick[playerid] < 1000)
    {
        // Sudden large distance - teleport hack
        SetPlayerPos(playerid, LastPos[playerid][0], LastPos[playerid][1], LastPos[playerid][2]);
        return 0;
    }
    
    LastPos[playerid][0] = x;
    LastPos[playerid][1] = y;
    LastPos[playerid][2] = z;
    Tick[playerid] = tick;
    return 1;
}
PAWN],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['protections'])) {
    $code = "// Ultimate Guard System\n\n";
    foreach ($_POST['protections'] ?? [] as $prot) {
        $code .= $guard_options[$prot]['code'] . "\n\n";
    }
    file_put_contents(__DIR__ . "/servers/server1/gamemodes/guard_system.pwn", $code);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد نظام الحراسة النهائي</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .guard-box { background:#16213e; padding:20px; border-radius:10px; }
        button { padding:10px; background:#aa0000; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="guard-box">
        <h2>مولد نظام الحراسة النهائي</h2>
        <form method="POST">
            <?php foreach ($guard_options as $key => $data): ?>
            <label><input type="checkbox" name="protections[]" value="<?= $key ?>"> <?= $data['name'] ?></label><br>
            <?php endforeach; ?>
            <button type="submit">توليد جميع الحمايات</button>
        </form>
    </div>
</body>
</html>