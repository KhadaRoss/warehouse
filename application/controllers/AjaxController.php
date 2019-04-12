<?php

namespace controllers;

use helpers\AjaxRequest;
use helpers\ErrorHandler;
use helpers\Request;

class AjaxController extends Controller
{
    const AJAX_DATA_KEY = 'data';

    /**
     * @var string
     */
    private $function = '';

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        if (!\defined('AJAX_CALL') || !AJAX_CALL) {
            (new ErrorHandler('request Error', 'invalid ajax request'))->printError();
        }

        parent::__construct($args);
        $this->handleIncomingData();
    }

    private function handleIncomingData()
    {
        unset($this->args['strings']);
        $this->function = $this->args[0];
        unset($this->args[0]);
        $this->parameters = (array)json_decode(Request::getInstance()->getPost(self::AJAX_DATA_KEY));
    }

    /**
     * @return string
     */
    public function handle(): string
    {
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
