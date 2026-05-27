<?php
// Multi-language support
session_start();

$lang = $_SESSION['lang'] ?? 'ar';
$langs = [
    'ar' => [
        'dashboard' => 'لوحة التحكم',
        'servers' => 'الخوادم',
        'players' => 'اللاعبين',
        'plugins' => 'الإضافات',
        'settings' => 'الإعدادات',
        'login' => 'تسجيل الدخول',
        'logout' => 'تسجيل الخروج',
        'start' => 'تشغيل',
        'stop' => 'إيقاف',
        'restart' => 'إعادة تشغيل',
    ],
    'en' => [
        'dashboard' => 'Dashboard',
        'servers' => 'Servers',
        'players' => 'Players',
        'plugins' => 'Plugins',
        'settings' => 'Settings',
        'login' => 'Login',
        'logout' => 'Logout',
        'start' => 'Start',
        'stop' => 'Stop',
        'restart' => 'Restart',
    ],
];

function __($key) {
    global $lang, $langs;
    return $langs[$lang][$key] ?? $key;
}

function set_language($lang_code) {
    global $lang;
    $lang = $lang_code;
    $_SESSION['lang'] = $lang_code;
}