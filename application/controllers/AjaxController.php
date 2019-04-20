<?php

namespace controllers;

use helpers\AjaxRequest;
use helpers\ErrorHandler;
use helpers\Request;

class AjaxController extends Controller
{
    /** @var string */
    private $function = '';
    /** @var array */
    private $parameters = [];

    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        parent::__construct($args);

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
            (new ErrorHandler('error', 'bad request'))->printError();
        }

        return (new AjaxRequest($this->function, $this->parameters))->render();
    }

    /**
     * @return array
     */
    protected function getStrings(): array
    {
        return [];
    }
}
