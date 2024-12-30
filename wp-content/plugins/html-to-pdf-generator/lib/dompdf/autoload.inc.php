<?php
// Example autoloader to load Dompdf classes
spl_autoload_register(function ($class_name) {
    $base_dir = plugin_dir_path(__FILE__) . 'lib/dompdf/src/';

    // Convert class name to file path
    $file = $base_dir . str_replace('\\', '/', $class_name) . '.php';

    if (file_exists($file)) {
        require_once($file);
    }
});
