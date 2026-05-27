<?php
// Email/Telegram Alert System
function send_alert($type, $message, $server = '') {
    $alerts = [
        'email' => [
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'username' => 'your@email.com',
            'password' => 'app_password',
            'to' => 'admin@email.com'
        ],
        'telegram' => [
            'bot_token' => 'BOT_TOKEN',
            'chat_id' => 'CHAT_ID'
        ]
    ];
    
    switch ($type) {
        case 'email':
            $headers = "From: {$alerts['email']['username']}\r\n";
            mail($alerts['email']['to'], "SA-MP Alert: $server", $message, $headers);
            break;
            
        case 'telegram':
            $url = "https://api.telegram.org/bot{$alerts['telegram']['bot_token']}/sendMessage";
            $data = ['chat_id' => $alerts['telegram']['chat_id'], 'text' => $message];
            file_get_contents($url . '?' . http_build_query($data));
            break;
    }
}

// Call this when server actions happen
function notify_server_action($server, $action) {
    if (isset($_GET['notify_email'])) {
        send_alert('email', "Server {$server}: {$action}", $server);
    }
}