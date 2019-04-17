<?php

namespace system\router;

use controllers\Controller;
use controllers\ErrorController;
use Error;

class RouterFactory
{
    const AJAX_CONTROLLER = 'ajax';
    const ERROR_CONTROLLER = 'error';
    const LOGIN_CONTROLLER = 'login';
    const LOGOUT_CONTROLLER = 'logout';
    const REPORTS_CONTROLLER = 'reports';
    const SHELF_CONTROLLER = 'shelf';
    const WAREHOUSE_CONTROLLER = 'warehouse';

    /**
     * @param string $controller
     * @param array $args
     *
     * @return Controller
     */
    public static function getController(string $controller, array $args): Controller
    {
        $controller = 'controllers\\' .  \ucfirst($controller) . 'Controller';

        try {
            return new  $controller($args);
        } catch (Error $e) {
            return (new ErrorController([404]));
        }
    }
}
