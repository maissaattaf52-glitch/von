<?php
// Real PAWN Compiler Wrapper (for Linux/Windows)
function compile_pawn($source_file, $output_file = null) {
    $compiler = __DIR__ . '/bin/pawncc';
    if (!file_exists($compiler)) {
        return ['success' => false, 'error' => 'Compiler not found'];
    }
    
    $output = shell_exec("\"{$compiler}\" \"{$source_file}\" -o{$output_file}");
    return trim($output) ? ['success' => true, 'output' => $output] : ['success' => false, 'error' => $output];
}

function compile_with_include($source, $includes = []) {
    $include_flags = implode(' ', array_map(fn($i) => "-i{$i}", $includes));
    $command = "pawncc \"{$source}\" {$include_flags}";
    return shell_exec($command);
}
?>