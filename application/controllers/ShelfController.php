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
            'DELETE_SHELF_HEADLINE',
            'DELETE_SHELF_MESSAGE_1',
            'DELETE_SHELF_MESSAGE_2',
            'DELETE_FIELD_HEADLINE',
            'DELETE_FIELD_MESSAGE_1',
            'DELETE_FIELD_MESSAGE_2',
            'DELETE_YES',
            'DELETE_NO',
            'FIELD_NEW',
            'FIELD_DELETE',
            'NEW_PRODUCT',
            'PRODUCT_ADD_HEADER',
            'PRODUCT_NAME',
            'PRODUCT_QUANTITY',
            'PRODUCT_DATE',
            'PRODUCT_COMMENT',
            'PRODUCT_YES',
            'PRODUCT_NO',
            'PRODUCT_INFORMATION',
            'PRODUCT_UPDATE_YES',
        ];
    }
}
