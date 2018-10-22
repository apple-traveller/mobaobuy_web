<?php

function classLoader($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $path = str_replace('Logistics' . DIRECTORY_SEPARATOR, '', $path);

    $file = __DIR__ . '/' . $path . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
}
spl_autoload_register('classLoader');
