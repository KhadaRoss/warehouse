<?php

namespace identity;

use Slim\Http\Request;
use Slim\Http\Response;
use system\Controller;

class LoginController extends Controller
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
     * @return string
     */
    public function index(): string
    {
        return (new LoginView($this->output))->render();
    }

    /**
     * @return string
     */
    public function error(): string
    {
        $this->output['LOGIN_ERROR'] = true;

        return $this->index();
    }

    /**
     * @return Response
     */
    public function authenticate(): Response
    {
        (new LoginModel($this->request))->doLogin();

        return $this->response;
    }

    /**
     * @return array
     */
    protected function getChildStrings(): array
    {
        return [
            'LOGIN',
            'USERNAME',
            'PASSWORD',
            'AUTHENTICATION_FAILED',
        ];
    }
}
