<?php

use Slim\App;
use Slim\Container;
use Slim\Exception\MethodNotAllowedException;
use Slim\Exception\NotFoundException;

require 'base.php';

require APPLICATION_PATH . 'config.php';
require BASE_PATH . 'vendor/autoload.php';

session_start();

$container = new Container();

require APPLICATION_PATH . 'settings.php';

$app = new App($container);

require APPLICATION_PATH . 'dependencies.php';
require APPLICATION_PATH . 'routes.php';

try {
    $app->run();
} catch (\Exception | MethodNotAllowedException | NotFoundException $e) {
    echo $e->getMessage();
}
