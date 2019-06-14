<?php

namespace api;

use error\ErrorHandler;
use helpers\Request;
use system\Controller;

class AjaxController extends Controller
{
    /** @var string */
    private $function = '';
    /** @var array */
    private $parameters = [];

    /**
     * @param array $request
     */
    public function __construct(array $request)
    {
        parent::__construct($request);

        $this->handleIncomingData();
    }

    /**
     * @return void
     */
    private function handleIncomingData(): void
    {
        $request = Request::getInstance();
        $this->function = $request->getPost('function');
        $this->parameters = $request->getPost('parameters');
    }

    /**
     * @return string
     */
    public function index(): string
    {
        if (empty($this->function) || !\is_string($this->function) || !\is_array($this->parameters)) {
            return (new ErrorHandler('error', 'bad request'))->printError();
        }

        return \json_encode((new AjaxRequest())->{$this->function}($this->parameters));
    }

    /**
     * @return array
     */
    protected function getChildStrings(): array
    {
        return [];
    }
}
