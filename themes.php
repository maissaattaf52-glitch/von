<?php
// Theme Manager with Turbo Hosting Theme
session_start();

$themes = [
    'dark' => [
        'bg' => '#1a1a2e',
        'sidebar' => '#16213e',
        'card' => '#0f3460',
        'text' => '#fff',
        'accent' => '#0f0'
    ],
    'light' => [
        'bg' => '#f0f0f0',
        'sidebar' => '#e0e0e0',
        'card' => '#d0d0d0',
        'text' => '#000',
        'accent' => '#0066cc'
    ],
    'turbo' => [
        'bg_gradient' => 'linear-gradient(135deg, #0000ff 0%, #000033 50%, #000000 100%)',
        'sidebar' => '#000080',
        'card' => '#000066',
        'text' => '#ffffff',
        'accent' => '#00ffff',
        'highlight' => '#ff00ff',
        'success' => '#00ff00',
        'warning' => '#ffff00',
        'danger' => '#ff0000',
        'glow' => '0 0 20px #00ffff, 0 0 40px #0088ff'
    ]
];

function current_theme() {
    return $_SESSION['theme'] ?? 'turbo';
}

function apply_theme($theme_name) {
    global $themes;
    $_SESSION['theme'] = $theme_name;
    return $themes[$theme_name] ?? $themes['turbo'];
}

function apply_turbo_theme() {
    global $themes;
    $_SESSION['theme'] = 'turbo';
    return $themes['turbo'];
}

function get_theme_css() {
    $theme = apply_turbo_theme();
    return "--bg-gradient: {$theme['bg_gradient']}; --sidebar: {$theme['sidebar']}; --card: {$theme['card']}; --text: {$theme['text']}; --accent: {$theme['accent']};";
}