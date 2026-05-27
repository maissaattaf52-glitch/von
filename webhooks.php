<?php
// Webhook system for Discord/Telegram notifications
require_once __DIR__ . '/config.php';

function send_webhook($server, $event, $message) {
    $webhooks_file = __DIR__ . "/servers/{$server}/webhooks.json";
    if (!file_exists($webhooks_file)) return;
    
    $hooks = json_decode(file_get_contents($webhooks_file), true);
    foreach ($hooks as $hook) {
        if ($hook['event'] === $event || $hook['event'] === 'all') {
            switch ($hook['type']) {
                case 'discord':
                    $data = ['content' => $message];
                    break;
                case 'webhook':
                    $data = ['text' => $message];
                    break;
            }
            // POST to webhook URL
            $ch = curl_init($hook['url']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_exec($ch);
            curl_close($ch);
        }
    }
}

function register_webhook($server, $type, $url, $event) {
    $webhooks_file = __DIR__ . "/servers/{$server}/webhooks.json";
    $hooks = file_exists($webhooks_file) ? json_decode(file_get_contents($webhooks_file), true) : [];
    
    $hooks[] = ['type' => $type, 'url' => $url, 'event' => $event];
    file_put_contents($webhooks_file, json_encode($hooks));
}