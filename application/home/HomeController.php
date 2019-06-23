<?php

namespace home;

use sidebar\SidebarModel;
use Slim\Http\Request;
use Slim\Http\Response;
use system\Controller;
use system\StringsModel;

class HomeController extends Controller
{
    /** @var HomeView */
    private $homeView;

    /**
     * @param Request      $request
     * @param Response     $response
     * @param StringsModel $stringsModel
     * @param HomeView     $homeView
     * @param SidebarModel $sidebarModel
     */
    public function __construct(
        Request $request,
        Response $response,
        StringsModel $stringsModel,
        HomeView $homeView,
        SidebarModel $sidebarModel
    ) {
        $this->homeView = $homeView;
        $this->sidebarModel = $sidebarModel;

        parent::__construct($request, $response, $stringsModel);
    }

    /**
     * @return string
     */
    public function index(): string
    {
        $this->homeView->setOutput($this->output);

        return $this->homeView->render();
    }

    /**
     * @return array
     */
    protected function getChildStrings(): array
    {
        return [
            'WAREHOUSE',
        ];
    }
}
