<?php
define('ROOT_PATH', dirname(__FILE__));

function __LoadClass($sClass)
{
    $paths = array(
        '',
        'src' . DIRECTORY_SEPARATOR,
        'tests' . DIRECTORY_SEPARATOR,
        'controllers' . DIRECTORY_SEPARATOR
    );

    foreach ($paths as $path) {
        $localFile = ROOT_PATH . DIRECTORY_SEPARATOR . $path . str_replace('\\', DIRECTORY_SEPARATOR, $sClass) . '.php';
        if (file_exists($localFile)) {
            require_once $localFile;
            break;
        }
    }
}

spl_autoload_register('__LoadClass');

