<?php
// Ultimate Server Panel Control (comprehensive)
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/security_advanced.php';

// Main panel initialization
class UltimatePanel {
    private $servers_dir;
    private $log_dir;
    
    public function __construct() {
        $this->servers_dir = __DIR__ . '/servers';
        $this->log_dir = __DIR__ . '/logs';
        
        // Initialize security
        secure_headers();
        
        // Initialize hooks
        $this->init_hooks();
    }
    
    private function init_hooks() {
        // Register shutdown function
        register_shutdown_function([$this, 'cleanup']);
        
        // Error handler
        set_error_handler([$this, 'error_handler']);
    }
    
    public function error_handler($errno, $errstr, $errfile, $errline) {
        $error = date('Y-m-d H:i:s') . " - $errno - $errstr in $errfile:$errline\n";
        file_put_contents($this->log_dir . '/php_errors.log', $error, FILE_APPEND);
        return true;
    }
    
    public function cleanup() {
        // Cleanup temporary files
    }
    
    public function get_system_info() {
        return [
            'php_version' => PHP_VERSION,
            'os' => PHP_OS_FAMILY,
            'memory_usage' => memory_get_usage(),
            'disk_free' => disk_free_space(__DIR__),
        ];
    }
}