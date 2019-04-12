<?php

namespace system\router;

use controllers\Controller;
use entities\Route;

class Router
{
    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $basePath;

    /**
     * @var Route
     */
    private $route;

    /**
     * @var Controller
     */
    private $controller;

    public function __construct()
    {
        $this->setInformation();
        $this->setController();
    }

    /**
     * @return void
     */
    private function setInformation()
    {
        $this->basePath = \strtolower(
            \implode('/', \array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/'
        );
        $this->uri = substr($_SERVER['REQUEST_URI'], strlen($this->basePath));
        $this->setRouteInformation();
    }

    /**
     * @return void
     */
    private function setRouteInformation()
    {
        $routeInformation = \explode('/', $this->uri);

        $this->route = (new Route())
            ->setControllerName($this->handleLandingPage(\array_shift($routeInformation)))
            ->setControllerMethod((string)\array_shift($routeInformation))
            ->setControllerArgs(\array_values($routeInformation));
    }

    /**
     * @param string $controllerName
     *
     * @return string
     */
    private function handleLandingPage(string $controllerName): string
    {
        if (empty($controllerName)) {
            self::redirect(RouterFactory::WAREHOUSE_CONTROLLER, '');
        }

        return $controllerName;
    }

    /**
     * return void
     */
    private function setController()
    {
        $this->controller = RouterFactory::getController(
            $this->route->getControllerName(),
            $this->route->getControllerArgs()
        );
    }

    /**
     * @return string
     */
    public function route(): string
    {
        return $this->controller->{$this->route->getControllerMethod()}();
    }

    /**
     * @param string $controllerName Use RouterFactory constants
     * @param string $method
     * @param array $controllerArgs
     */
    public static function redirect(string $controllerName, string $method ,array $controllerArgs = [])
    {
        $uri = \URL . $controllerName . '/' . $method;

        if (!empty($controllerArgs)) {
            $uri .= '/' . \implode('/', $controllerArgs);
        }

        \header('Location: ' . $uri);
        exit;
    }
}
