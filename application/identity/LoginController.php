<?php

namespace identity;

use sidebar\SidebarModel;
use Slim\Http\Request;
use Slim\Http\Response;
use system\Controller;

class LoginController extends Controller
{
    /** @var LoginView */
    private $loginView;

    /**
     * @param Request      $request
     * @param Response     $response
     */
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response, new SidebarModel());

        $this->loginView = new LoginView();
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
        (new LoginModel($this->request))->doLogin();
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
