<?php

namespace controllers;

use system\identity\CurrentIdentity;

class LogoutController extends Controller
{
    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        CurrentIdentity::getIdentity()->logout();

        parent::__construct($args);
    }

    /**
     * @return string
     */
    public function index(): string
    {
        return '';
    }

    /**
     * @return array
     */
    protected function getStrings(): array
    {
        return [];
    }
}
