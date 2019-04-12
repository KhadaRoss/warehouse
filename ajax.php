<?php

define('AJAX_CALL', true);

require_once 'base.php';

session_start();

header('Content-type: application/json; charset=utf-8');
echo (new \system\router\Router())->route();