<?php

namespace identity;

use Slim\Http\Request;
use Slim\Http\Response;
use system\Controller;
use system\StringsModel;

class LoginController extends Controller
{
    /** @var LoginModel */
    private $loginModel;
    /** @var LoginView */
    private $loginView;

    /**
     * @param Request      $request
     * @param Response     $response
     * @param StringsModel $stringsModel
     * @param LoginModel   $loginModel
     * @param LoginView    $loginView
     * @param bool         $isLoggedIn
     */
    public function __construct(
        Request $request,
        Response $response,
        StringsModel $stringsModel,
        LoginModel $loginModel,
        LoginView $loginView,
        bool $isLoggedIn
    ) {
        $this->loginModel = $loginModel;
        $this->loginView = $loginView;

        parent::__construct($request, $response, $stringsModel, $isLoggedIn);
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
            'LOGIN_BUTTON',
            'USERNAME',
            'PASSWORD',
            'AUTHENTICATION_FAILED',
        ];
    }
}
