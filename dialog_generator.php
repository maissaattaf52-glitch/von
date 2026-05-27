<?php
// Dialog/ComboBox Generator
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dialog_id = $_POST['dialog_id'] ?? 1;
    $title = $_POST['title'] ?? 'Dialog';
    $items = $_POST['items'] ?? '';
    
    $code = <<<PAWN
// Dialog: {$title}
public OnDialogResponse(playerid, dialogid, response, listitem, inputtext[])
{
    if (dialogid == {$dialog_id})
    {
        if (response)
        {
            // Player selected: listitem
            switch (listitem)
            {
                {$items}
            }
        }
        return 1;
    }
    return 0;
}

// Show dialog
public ShowMyDialog(playerid)
{
    ShowPlayerDialog(playerid, {$dialog_id}, DIALOG_STYLE_LIST, "{$title}", "Select:", "OK", "Cancel");
}
PAWN;
    
    file_put_contents(__DIR__ . "/servers/server1/gamemodes/dialog_{$dialog_id}.pwn", $code);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مولد الديالوج</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .dialog-box { background:#16213e; padding:20px; border-radius:10px; }
        input, textarea { width:100%; padding:10px; margin:5px 0; background:#000; color:#fff; border:1px solid #0f0; }
        button { padding:10px 15px; background:#00aa00; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="dialog-box">
        <h2>مولد الديالوج</h2>
        <form method="POST">
            <input type="number" name="dialog_id" placeholder="رقم الديالوج" value="1000" required>
            <input type="text" name="title" placeholder="عنوان الديالوج" required>
            <textarea name="items" placeholder="case 0: // Do something break;"></textarea>
            <button type="submit">إنشاء</button>
        </form>
    </div>
</body>
</html>