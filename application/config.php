<?php

error_reporting(E_ALL);

spl_autoload_register(
    function ($class) {
        $require = APPLICATION_PATH . str_replace('\\', '/', $class) . '.php';
        if (file_exists($require)) {
            require_once $require;
        }
    }
);