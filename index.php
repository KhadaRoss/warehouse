<?php

use router\Router;

require_once 'base.php';

session_start();

header("Content-Type: text/html; charset=utf-8");
echo (new Router())->route();
