<?php

namespace system;

use identity\IdentityModel;
use sidebar\SidebarModel;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class Controller
{
    /** @var Request */
    protected $request;
    /** @var Response */
    protected $response;
    /** @var array */
    protected $output;
    /** @var StringsModel */
    private $stringsModel;
    /** @var SidebarModel */
    protected $sidebarModel;

    /**
     * @param Request      $request
     * @param Response     $response
     * @param StringsModel $stringsModel
     */
    public function __construct(Request $request, Response $response, StringsModel $stringsModel)
    {
        $this->stringsModel = $stringsModel;

        $this->request = $request;
        $this->response = $response;

        $this->setOutput();
        $this->initStrings();
    }

    /**
     * @return void
     */
    private function setOutput(): void
    {
        $this->output['URL'] = URL;
        $this->output['LANG'] = SettingsModel::get('CURRENT_LANGUAGE');

        if ($this->sidebarModel !== null) {
            $this->output['SIDEBAR'] = $this->sidebarModel->getTwigData();
        }
    }

    /**
     * @return void
     */
    private function initStrings(): void
    {
        $this->output = \array_merge(
            $this->output,
            $this->stringsModel->getAll($this->getStrings())
        );

        if (IdentityModel::isLoggedIn()) {
            $this->output['JS_STRINGS'] = $this->stringsModel->getAll($this->getGlobalJsStrings());
        }
    }

    /**
     * @return array
     */
    private function getStrings(): array
    {
        return \array_merge(
            $this->getGlobalStrings(),
            $this->getGlobalJsStrings(),
            $this->getChildStrings()
        );
    }

    /**
     * @return array
     */
    private function getGlobalStrings(): array
    {
        return [
            'TITLE',
            'LOGOUT',
            'SEARCH',
            'NEW',
        ];
    }

    /**
     * @return array
     */
    private function getGlobalJsStrings(): array
    {
        return [
            'NEW_PRODUCT',
        ];
    }

    /**
     * @return array
     */
    abstract protected function getChildStrings();
}
