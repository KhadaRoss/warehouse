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

        $this->args['active'] = $this->args[0];
        unset($this->args[0]);
    }

    /**
     * @return string
     */
    public function show(): string
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
            'DELETE_HEADLINE',
            'DELETE_MESSAGE_1',
            'DELETE_MESSAGE_2',
            'DELETE_YES',
            'DELETE_NO',
            'FIELD_NEW',
            'FIELD_DELETE',
        ];
    }
}
