<?php

namespace controllers;

use models\StringsModel;
use system\identity\CurrentIdentity;
use system\router\Router;
use system\router\RouterFactory;

abstract class Controller
{
    /** @var array */
    protected $args = [];
    /** @var array  */
    private $strings = ['TITLE', 'LOGOUT', 'SEARCH', 'NEW'];

    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        $this->checkAccess();

        $this->strings = \array_merge($this->strings, $this->getStrings());

        $this->args = $args;
        $this->getStringsFromDb();
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return string
     */
    public function __call($name, $arguments): string
    {
        return (new ErrorController([404]))->handle();
    }

    /**
     * @return array
     */
    abstract protected function getStrings();

    /**
     * @return void
     */
    private function getStringsFromDb():void
    {
        $this->args['strings'] = (new StringsModel())->getAll($this->strings);
    }

    /**
     * @return void
     */
    private function checkAccess(): void
    {
        if (!$this instanceof LoginController && !CurrentIdentity::getIdentity()->isLoggedIn()) {
            Router::redirect(RouterFactory::LOGIN_CONTROLLER);
        }
    }
}
