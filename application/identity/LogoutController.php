<?php

namespace identity;

use router\Router;
use router\RouterFactory;
use system\Controller;

class LogoutController extends Controller
{
    /**
     * @param array $request
     */
    public function __construct(array $request)
    {
        parent::__construct($request);

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
    protected function getChildStrings(): array
    {
        return [];
    }
}
