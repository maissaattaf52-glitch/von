<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/themes.php';
if (!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}

$server_name = $_GET['server'] ?? $config['default_server'];
$server_dir = __DIR__ . "/servers/{$server_name}";

function get_players_data($server_name) {
    return [
        ['id' => 0, 'name' => 'Player_1', 'ping' => rand(30, 150), 'score' => rand(0, 50)],
        ['id' => 1, 'name' => 'Player_2', 'ping' => rand(30, 150), 'score' => rand(0, 50)],
        ['id' => 2, 'name' => 'Player_3', 'ping' => rand(30, 150), 'score' => rand(0, 50)],
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $player_id = $_POST['player_id'] ?? '';
    // Simulated actions
}

$theme = apply_turbo_theme();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>👥 إدارة اللاعبين - تيربو هاوستينج</title>
    <style>
        :root {
            --bg-gradient: <?= $theme['bg_gradient'] ?>;
            --card: <?= $theme['card'] ?>;
            --text: <?= $theme['text'] ?>;
            --accent: <?= $theme['accent'] ?>;
            --success: <?= $theme['success'] ?>;
            --warning: <?= $theme['warning'] ?>;
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
        .players-box { 
            background: var(--card); 
            padding: 25px; 
            border-radius: 15px;
            border: 2px solid var(--accent);
            box-shadow: var(--glow);
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td { 
            padding: 12px; 
            text-align: center; 
            border: 1px solid var(--accent); 
        }
        th { 
            background: var(--sidebar); 
            color: var(--text);
        }
        .btn { 
            padding: 8px 15px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            margin: 2px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-kick { 
            background: var(--warning); 
            color: #000; 
        }
        .btn-ban { 
            background: var(--danger); 
            color: #fff; 
        }
        .btn:hover {
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
        .ping-good { color: var(--success); }
        .ping-medium { color: var(--warning); }
        .ping-bad { color: var(--danger); }
    </style>
</head>
<body>
    <a href="turbo_housting.php">🏠 العودة للوحة التحكم</a>
    <div class="players-box">
        <h2>👥 إدارة اللاعبين - <?= htmlspecialchars($server_name) ?> <span style="font-size:14px; color:#888;">(مُحدث كل 5 ثواني)</span></h2>
        <table>
            <tr>
                <th>🆔 الآي دي</th>
                <th>👤 الاسم</th>
                <th>📶 البنج</th>
                <th>🏆 النقاط</th>
                <th>⚙️ الإجراءات</th>
            </tr>
            <?php foreach (get_players_data($server_name) as $player): 
                $ping_class = $player['ping'] < 80 ? 'ping-good' : ($player['ping'] < 120 ? 'ping-medium' : 'ping-bad');
            ?>
            <tr>
                <td><?= $player['id'] ?></td>
                <td><?= htmlspecialchars($player['name']) ?></td>
                <td class="<?= $ping_class ?>"><?= $player['ping'] ?> ms</td>
                <td><?= $player['score'] ?></td>
                <td>
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="action" value="kick">
                        <input type="hidden" name="player_id" value="<?= $player['id'] ?>">
                        <button type="submit" class="btn btn-kick">🚪 Kick</button>
                    </form>
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="action" value="ban">
                        <input type="hidden" name="player_id" value="<?= $player['id'] ?>">
                        <button type="submit" class="btn btn-ban">🔨 Ban</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>