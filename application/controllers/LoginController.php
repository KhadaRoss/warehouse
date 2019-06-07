<?php

namespace controllers;

use helpers\Request;
use system\identity\CurrentIdentity;
use system\identity\Login;
use system\router\Router;
use system\router\RouterFactory;
use views\LoginView;

class LoginController extends Controller
{
    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        parent::__construct($args);
    }

    /**
     * @return string
     */
    public function index(): string
    {
        if (CurrentIdentity::getIdentity()->isLoggedIn()) {
            Router::redirect(RouterFactory::WAREHOUSE_CONTROLLER);
        }

        return (new LoginView($this->args))->render();
    }

    /**
     * @return string
     */
    public function authenticate(): string
    {
        $request = Request::getInstance();

        (new Login(
            $request->getPost('username'),
            $request->getPost('password'))
        )->doLogin();

        if (CurrentIdentity::getIdentity()->isLoggedIn()) {
            Router::redirect(RouterFactory::WAREHOUSE_CONTROLLER);
        }

        return (new LoginView($this->args))->render();
    }

    /**
     * @return array
     */
    protected function getStrings(): array
    {
        return [
            'LOGIN',
            'USERNAME',
            'PASSWORD',
        ];
    }
}
