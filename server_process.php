<?php
// Cross-platform server management functions

function is_server_running($server_dir) {
    $pid_file = "{$server_dir}/samp03svr.pid";
    if (!file_exists($pid_file)) return false;
    
    if (PHP_OS_FAMILY === 'Windows') {
        return true; // Simulated for Windows
    }
    
    $pid = trim(file_get_contents($pid_file));
    return file_exists("/proc/{$pid}");
}

function get_server_process($server_dir) {
    $pid_file = "{$server_dir}/samp03svr.pid";
    if (file_exists($pid_file)) {
        return file_get_contents($pid_file);
    }
    return null;
}

function write_pid($server_dir, $pid = null) {
    if ($pid === null) $pid = getmypid();
    file_put_contents("{$server_dir}/samp03svr.pid", $pid);
}

function start_samp_server($server_dir) {
    if (PHP_OS_FAMILY === 'Windows') {
        // Windows: PowerShell commands
        $log_file = "{$server_dir}/server_log.txt";
        shell_exec("echo $(date) - Server starting... >> {$log_file}");
        write_pid($server_dir);
    } else {
        // Linux: Direct binary execution
        $binary = "{$server_dir}/samp03svr";
        if (file_exists($binary)) {
            exec("cd {$server_dir} && nohup ./samp03svr > server_log.txt 2>&1 & echo $! > samp03svr.pid");
        }
    }
}

function stop_samp_server($server_dir) {
    $pid = get_server_process($server_dir);
    if ($pid) {
        if (PHP_OS_FAMILY === 'Windows') {
            // Simulated - Windows doesn't have direct process kill
            unlink("{$server_dir}/samp03svr.pid");
        } else {
            exec("kill {$pid} 2>/dev/null");
            unlink("{$server_dir}/samp03svr.pid");
        }
    }
}