<?php
// Complete Protection Code Generator
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$protection_types = [
    'vehicle' => ['name' => 'Vehicle Hacks Prevention', 'code' => <<<PAWN
// Vehicle Hack Protection
new LastVehicleHealth[MAX_PLAYERS];
new VehicleHealthTicks[MAX_PLAYERS];

public OnVehicleHealthUpdate(vehicleid, playerid)
{
    new health = GetVehicleHealth(vehicleid);
    if (health < 0.0)
    {
        SetVehicleHealth(vehicleid, 1000.0);
        return 0;
    }
    return 1;
}

stock CheckVehicleHack(playerid)
{
    new vehicleid = GetPlayerVehicleID(playerid);
    if (vehicleid != INVALID_VEHICLE_ID)
    {
        // Check for godmode, speed hacks, etc.
    }
}
PAWN],
    'sync' => ['name' => 'Sync Protection', 'code' => <<<PAWN
// Sync Protection
new PlayerSyncTick[MAX_PLAYERS];
new Float:LastPosX[MAX_PLAYERS][3];

public OnPlayerUpdate(playerid)
{
    new tick = GetTickCount();
    new Float:pos[3];
    GetPlayerPos(playerid, pos[0], pos[1], pos[2]);
    
    // Position sync check
    if (tick - PlayerSyncTick[playerid] < 1000)
    {
        new Float:dist = VectorSize(pos[0] - LastPosX[playerid][0], pos[1] - LastPosX[playerid][1], pos[2] - LastPosX[playerid][2]);
        if (dist > 50.0)
        {
            // Teleport hack
            SetPlayerPos(playerid, LastPosX[playerid][0], LastPosX[playerid][1], LastPosX[playerid][2]);
            return 0;
        }
    }
    
    PlayerSyncTick[playerid] = tick;
    LastPosX[playerid][0] = pos[0];
    LastPosX[playerid][1] = pos[1];
    LastPosX[playerid][2] = pos[2];
    return 1;
}
PAWN],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['protection'])) {
    $prot = $_POST['protection'];
    file_put_contents(__DIR__ . "/servers/server1/gamemodes/anti_{$prot}.pwn", $protection_types[$prot]['code']);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد الحماية الكامل</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .prot-box { background:#16213e; padding:20px; border-radius:10px; }
        button { padding:10px 15px; background:#aa0000; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="prot-box">
        <h2>مولد حماية الخادم الكامل</h2>
        <form method="POST">
            <select name="protection">
                <?php foreach ($protection_types as $key => $data): ?>
                <option value="<?= $key ?>"><?= htmlspecialchars($data['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">توليد حماية</button>
        </form>
    </div>
</body>
</html>