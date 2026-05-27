<?php
http_response_code(403);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>محظور</title>
    <style>
        body { font-family: Arial; background:#8B0000; color:#fff; display:flex; align-items:center; justify-content:center; height:100vh; text-align:center; }
        .block-box { padding:40px; background:#000; border-radius:10px; }
    </style>
</head>
<body>
    <div class="block-box">
        <h1>تم حظرك</h1>
        <p>تم رصد محاولة اختراق أو سلوك مشبوه.</p>
        <p>تم إبلاغ المسؤول.</p>
    </div>
</body>
</html>