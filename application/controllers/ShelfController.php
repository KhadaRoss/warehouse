<?php

namespace controllers;

use views\ShelfView;

class ShelfController extends Controller
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
    public function show    (): string
    {
        return (new ShelfView($this->args))->render();
    }

    /**
     * @return array
     */
    protected function getStrings(): array
    {
        return [
            'SHELF',
        ];
    }
}
