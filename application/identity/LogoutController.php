<?php

namespace identity;

use Slim\Http\Request;
use Slim\Http\Response;
use system\Controller;

class LogoutController extends Controller
{
    /**
     * @param Request  $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        IdentityModel::reset();
    }

    /**
     * @return array
     */
    protected function getChildStrings(): array
    {
        return [];
    }
}
