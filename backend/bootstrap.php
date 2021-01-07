<?php

/**
 * Autoloader
 */
define('SOURCE_DIRECTORY', 'src' . DIRECTORY_SEPARATOR);

spl_autoload_register(function ($class) {
    
    $file = $class.".php";
    if (file_exists($file)) {
        require $file;
    }

    $file = SOURCE_DIRECTORY . str_replace('\\', DIRECTORY_SEPARATOR, $file);
    
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});

require('config.php');
require('src/Application.php');

$app = new Application($config);