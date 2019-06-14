<?php

namespace shelf;

use system\Controller;

class ShelfController extends Controller
{
    /**
     * @param array $request
     */
    public function __construct(array $request)
    {
        parent::__construct($request);

        $this->request['active'] = $this->request[0];
        unset($this->request[0]);
    }

    /**
     * @return string
     */
    public function show(): string
    {
        return (new ShelfView($this->request))->render();
    }

    /**
     * @return array
     */
    protected function getChildStrings(): array
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
            'PRODUCT_GROUP',
            'PRODUCT_COMMENT',
            'PRODUCT_YES',
            'PRODUCT_NO',
            'PRODUCT_INFORMATION',
            'PRODUCT_UPDATE_YES',
        ];
    }
}
