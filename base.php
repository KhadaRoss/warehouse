<?php

define('URL', 'http://localhost/warehouse/');
define('BASE_PATH', realpath(dirname(__FILE__)) . '/');
define('APPLICATION_PATH', BASE_PATH . 'application/');
define('TEMPLATES', BASE_PATH . 'templates/');

define('USER', 'root');
define('PASSWORD', '');
define('DSN', 'mysql:dbname=warehouse;host=localhost;charset=utf8');

ini_set("default_charset", 'utf-8');

$isAjax = define(
    'IS_AJAX',
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
);

require_once APPLICATION_PATH . 'config.php';
require_once BASE_PATH . 'vendor/autoload.php';
