<?php
// PHP Configuration for SA-MP Panel
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Session settings
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

// File upload limits
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');

// Memory limit
ini_set('memory_limit', '256M');

// Time limits
ini_set('max_execution_time', 300);
set_time_limit(0);

// Opcache for performance
if (function_exists('opcache_reset')) {
    opcache_reset();
}