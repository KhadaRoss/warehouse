<?php
require_once 'base.php';

session_start();

header("Content-Type: text/html; charset=utf-8");
echo (new \system\router\Router())->route();