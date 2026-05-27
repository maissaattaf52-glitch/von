<?php
// Auto-backup cron script
require_once __DIR__ . '/config.php';

$backup_dir = __DIR__ . '/backups';
if (!is_dir($backup_dir)) {
    mkdir($backup_dir, 0755, true);
}

$servers_dir = __DIR__ . '/servers';
foreach (glob($servers_dir . '/*', GLOB_ONLYDIR) as $server_dir) {
    $server_name = basename($server_dir);
    $zip_file = "{$backup_dir}/{$server_name}_auto_" . date('Y-m-d') . ".zip";
    
    $zip = new ZipArchive();
    if ($zip->open($zip_file, ZipArchive::CREATE) === TRUE) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($server_dir));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $local = str_replace($server_dir . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $zip->addFile($file->getPathname(), $local);
            }
        }
        $zip->close();
    }
}

// Clean old backups (keep 7 days)
foreach (glob($backup_dir . '/*.zip') as $backup) {
    if (filemtime($backup) < time() - 7 * 24 * 3600) {
        unlink($backup);
    }
}