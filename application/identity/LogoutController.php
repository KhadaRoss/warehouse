<?php

namespace identity;

use Slim\Http\Request;
use Slim\Http\Response;
use system\Controller;
use system\StringsModel;

class LogoutController extends Controller
{
    /** @var callable */
    private $resetIdentity;

    /**
     * @param Request      $request
     * @param Response     $response
     * @param StringsModel $stringsModel
     * @param callable     $resetIdentity
     * @param bool         $isLoggedIn
     */
    public function __construct(
        Request $request,
        Response $response,
        StringsModel $stringsModel,
        callable $resetIdentity,
        bool $isLoggedIn
    ) {
        $this->resetIdentity = $resetIdentity;

        parent::__construct($request, $response, $stringsModel, $isLoggedIn);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $reset = $this->resetIdentity;

        $reset();
    }

    /**
     * @return array
     */
    protected function getChildStrings(): array
    {
        return [];
    }
}
