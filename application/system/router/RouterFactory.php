<?php

namespace system\router;

use controllers\Controller;
use controllers\ErrorController;
use Error;

class RouterFactory
{
    const ERROR_CONTROLLER = 'error';
    const WAREHOUSE_CONTROLLER = 'warehouse';
    const REPORTS_CONTROLLER = 'reports';
    const AJAX_CONTROLLER = 'ajax';

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
