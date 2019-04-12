<?php

namespace controllers;

use views\ErrorView;

class ErrorController extends Controller
{
    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        parent::__construct($args);
    }

    /**
     * @return string
     */
    public function handle(): string
    {
        return (new ErrorView($this->args))->render();
    }

    /**
     * @return array
     */
    protected function getStrings(): array
    {
        return [
            'ERROR'
        ];
    }
}
