<?php
// Ultimate Gang System Generator
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$gang_features = [
    'create' => ['cmd' => '/gangcreate', 'desc' => 'إنشاء عصابة'],
    'invite' => ['cmd' => '/ganginvite', 'desc' => 'دعوة للعصابة'],
    'kick' => ['cmd' => '/gangkick', 'desc' => 'طرد من العصابة'],
    'leave' => ['cmd' => '/gangleave', 'desc' => 'مغادرة العصابة'],
    'rank' => ['cmd' => '/gangrank', 'desc' => 'ترقية عضو'],
    'spawn' => ['cmd' => '/gangspawn', 'desc' => 'موقع تجمع العصابة'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = "// Gang System - Generated\n\n";
    
    foreach ($_POST['features'] ?? [] as $feat) {
        $code .= <<<PAWN
public OnPlayerCommandText(playerid, cmdtext[])
{
    if (IsPlayerInGang(playerid))
    {
        if (strcmp(cmdtext, "{$gang_features[$feat]['cmd']}", true) == 0)
        {
            // {$gang_features[$feat]['desc']}
            return 1;
        }
    }
    return 0;
}

PAWN;
    }
    
    file_put_contents(__DIR__ . "/servers/server1/gamemodes/gang_system.pwn", $code);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد نظام العصابات النهائي</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .gang-box { background:#16213e; padding:20px; border-radius:10px; }
        button { padding:10px; background:#aa0000; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="gang-box">
        <h2>مولد نظام العصابات النهائي</h2>
        <form method="POST">
            <?php foreach ($gang_features as $key => $data): ?>
            <label><input type="checkbox" name="features[]" value="<?= $key ?>"> <?= $data['desc'] ?> (<?= $data['cmd'] ?>)</label><br>
            <?php endforeach; ?>
            <button type="submit">توليد نظام العصابات</button>
        </form>
    </div>
</body>
</html>