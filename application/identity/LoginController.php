<?php

namespace identity;

use Slim\Http\Request;
use Slim\Http\Response;
use system\Controller;

class LoginController extends Controller
{
    /** @var LoginModel */
    private $loginModel;
    /** @var LoginView */
    private $loginView;

    /**
     * @param Request  $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->loginModel = new LoginModel($request);
        $this->loginView = new LoginView();

        parent::__construct($request, $response);
    }

    /**
     * @return string
     */
    public function index(): string
    {
        $this->loginView->setOutput($this->output);

        return $this->loginView->render();
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
     * @return void
     */
    public function authenticate(): void
    {
        $this->loginModel->doLogin();
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
