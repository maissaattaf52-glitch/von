<?php
// Complete Economy System Generator
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$economy_features = [
    'bank' => ['name' => 'البنك', 'code' => 'stock SetPlayerBank(playerid, amount) { BankInfo[playerid][bBalance] = amount; }'],
    'business' => ['name' => 'الأعمال', 'code' => 'stock BuyBusiness(playerid, bizid) { BusinessInfo[bizid][bOwner] = playerid; }'],
    'casino' => ['name' => 'الكازينو', 'code' => 'stock CasinoDice(playerid, bet) { GivePlayerMoney(playerid, bet * 2); }'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = "";
    foreach ($_POST['features'] ?? [] as $feat) {
        $code .= $economy_features[$feat]['code'] . "\n\n";
    }
    file_put_contents(__DIR__ . "/servers/server1/gamemodes/economy.pwn", $code);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد الاقتصاد الكامل</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .eco-box { background:#16213e; padding:20px; border-radius:10px; }
        button { padding:10px 15px; background:#ff6600; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="eco-box">
        <h2>مولد الاقتصاد الكامل</h2>
        <form method="POST">
            <?php foreach ($economy_features as $key => $data): ?>
            <label><input type="checkbox" name="features[]" value="<?= $key ?>"> <?= $data['name'] ?></label><br>
            <?php endforeach; ?>
            <button type="submit">توليد النظام الاقتصادي</button>
        </form>
    </div>
</body>
</html>