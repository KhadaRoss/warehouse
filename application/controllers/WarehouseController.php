<?php

namespace controllers;

use views\WarehouseView;

class WarehouseController extends Controller
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
    public function index(): string
    {
        return (new WarehouseView($this->args))->render();
    }

    /**
     * @return array
     */
    protected function getStrings(): array
    {
        return ['WAREHOUSE'];
    }
}
