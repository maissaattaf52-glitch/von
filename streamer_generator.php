<?php
// Streamer Generator
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$object_types = ['dynamic', 'static', 'pickup', 'checkpoint', 'race'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['object_type'];
    $model = $_POST['model'] ?? 1221;
    $count = $_POST['count'] ?? 10;
    
    $code = <<<PAWN
// Streamer Objects - {$type}
new {$type}Objects[{$count}];

public Create{$type}Objects()
{
    for (new i = 0; i < {$count}; i++)
    {
        {$type}Objects[i] = CreateDynamicObject({$model}, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
    }
}

public Destroy{$type}Objects()
{
    for (new i = 0; i < {$count}; i++)
    {
        DestroyDynamicObject({$type}Objects[i]);
    }
}
PAWN;
    
    file_put_contents(__DIR__ . "/servers/server1/gamemodes/streamer_{$type}.pwn", $code);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد Streamer</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .stream-box { background:#16213e; padding:20px; border-radius:10px; }
        input, select { padding:10px; margin:5px; background:#000; color:#fff; border:1px solid #0f0; }
        button { padding:10px 15px; background:#0f3460; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="stream-box">
        <h2>مولد Streamer Objects</h2>
        <form method="POST">
            <select name="object_type">
                <?php foreach ($object_types as $type): ?>
                <option value="<?= $type ?>"><?= htmlspecialchars($type) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="model" placeholder="رقم المودل" value="1221">
            <input type="number" name="count" placeholder="العدد" value="10">
            <button type="submit">إنشاء</button>
        </form>
    </div>
</body>
</html>