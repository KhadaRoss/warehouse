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
     */
    public function __construct(Request $request,
        Response $response,
        StringsModel $stringsModel,
        callable $resetIdentity
    ) {
        $this->resetIdentity = $resetIdentity;

        parent::__construct($request, $response, $stringsModel);
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
