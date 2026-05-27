<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/panel_core.php';

if (!isset($_SESSION['logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
        if ($_POST['username'] === $config['auth']['username'] && $_POST['password'] === $config['auth']['password']) {
            $_SESSION['logged_in'] = true;
            $_SESSION['turbo_mode'] = true;
            header('Location: turbo_housting.php');
            exit;
        } else {
            $error = 'بيانات الدخول غير صحيحة';
        }
    }
    include 'login.php';
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: index.php');
    exit;
}

$action = $_GET['action'] ?? 'dashboard';
$server_name = $_GET['server'] ?? $config['default_server'];
$response = '';

switch ($action) {
    case 'start':
        exec("php scripts/start_server.php {$server_name} > /dev/null 2>&1 &");
        $response = "🚀 جاري تشغيل الخادم بوضع تيربو...";
        break;
    case 'stop':
        exec("php scripts/stop_server.php {$server_name}");
        $response = "🛑 تم إيقاف الخادم";
        break;
    case 'restart':
        exec("php scripts/stop_server.php {$server_name}");
        exec("php scripts/start_server.php {$server_name} > /dev/null 2>&1 &");
        $response = "🔄 جاري إعادة تشغيل الخادم...";
        break;
    case 'command':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['command'])) {
            $response = "⚡ " . send_command($server_name, $_POST['command']);
        }
        break;
    case 'install':
        include 'install.php';
        exit;
        break;
    case 'turbo':
        header('Location: turbo_housting.php');
        exit;
        break;
}

include 'dashboard.php';
?>