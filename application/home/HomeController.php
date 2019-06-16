<?php

namespace home;

use sidebar\SidebarModel;
use Slim\Http\Request;
use Slim\Http\Response;
use system\Controller;

class HomeController extends Controller
{
    /** @var HomeView */
    private $homeView;

    /**
     * @param Request  $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->homeView = new HomeView();
        $this->sidebarModel = new SidebarModel();

        parent::__construct($request, $response);
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
