<?php

namespace controllers;

use models\IdentityModel;
use system\router\Router;
use system\router\RouterFactory;

class LogoutController extends Controller
{
    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        parent::__construct($args);

        new IdentityModel(IdentityModel::GUEST_USER_ID, IdentityModel::GUEST_USER_NAME);
        Router::redirect(RouterFactory::LOGIN_CONTROLLER);
    }

    /**
     * @return string
     */
    public function index(): string
    {
        return '';
    }

    /**
     * @return array
     */
    protected function getStrings(): array
    {
        return [];
    }
}
