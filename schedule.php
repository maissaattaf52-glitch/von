<?php
// Scheduled Tasks Manager
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['logged_in'])) exit;

$tasks_file = __DIR__ . '/scheduled_tasks.json';
$tasks = file_exists($tasks_file) ? json_decode(file_get_contents($tasks_file), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = [
        'id' => uniqid(),
        'name' => $_POST['name'] ?? '',
        'schedule' => $_POST['schedule'] ?? 'daily',
        'command' => $_POST['command'] ?? '',
        'active' => isset($_POST['active'])
    ];
    $tasks[] = $task;
    file_put_contents($tasks_file, json_encode($tasks));
}

function run_scheduled_tasks() {
    global $tasks_file;
    $tasks = file_exists($tasks_file) ? json_decode(file_get_contents($tasks_file), true) : [];
    foreach ($tasks as $task) {
        if ($task['active'] && should_run_task($task)) {
            exec($task['command']);
        }
    }
}

function should_run_task($task) {
    // Simplified - would check last run time in production
    return true;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>المهام المجدولة</title>
    <style>
        body { font-family: Arial; background:#1a1a2e; color:#fff; padding:20px; }
        .tasks-box { background:#16213e; padding:20px; border-radius:10px; }
        .task-item { padding:10px; background:#000; margin:5px 0; border-radius:5px; }
        input, select { padding:8px; margin:5px; background:#000; color:#fff; border:1px solid #0f0; }
        button { padding:8px 12px; background:#0f3460; color:#fff; border:none; cursor:pointer; }
    </style>
</head>
<body>
    <a href="index.php">العودة للوحة التحكم</a>
    <div class="tasks-box">
        <h2>المهام المجدولة</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="اسم المهمة" required>
            <select name="schedule">
                <option value="daily">يومي</option>
                <option value="weekly">أسبوعي</option>
                <option value="monthly">شهري</option>
            </select>
            <input type="text" name="command" placeholder="الأمر" required>
            <label><input type="checkbox" name="active"> نشط</label>
            <button type="submit">إضافة</button>
        </form>
        <h3 style="margin-top:20px;">المهام الحالية</h3>
        <?php foreach ($tasks as $task): ?>
        <div class="task-item">
            <?= htmlspecialchars($task['name']) ?> - <?= $task['schedule'] ?> - <?= $task['active'] ? 'نشط' : 'معطل' ?>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>