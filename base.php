<?php

define('URL', 'http://localhost/warehouse/');
define('BASE_PATH', realpath(dirname(__FILE__)) . '/');
define('APPLICATION_PATH', BASE_PATH . 'application/');
define('TEMPLATES', BASE_PATH . 'templates/');

define('USER', 'root');
define('PASSWORD', '');
define('DSN', 'mysql:dbname=warehouse;host=localhost;charset=utf8');

ini_set("default_charset", 'utf-8');

require_once APPLICATION_PATH . 'config.php';
