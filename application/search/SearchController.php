<?php

namespace search;

use product\ProductModel;
use system\Controller;

class SearchController extends Controller
{
    /**
     * @param array $request
     */
    public function __construct(array $request)
    {
        parent::__construct($request);

        $this->request['search'] = \str_replace('~', ' ', $this->request[0]);
        unset($this->request[0]);
    }

    /**
     * @return string
     */
    public function product(): string
    {
        $this->request['products'] = (new ProductModel())->search($this->request['search']);

        return (new SearchView($this->request))->render();
    }

    /**
     * @return array
     */
    protected function getChildStrings(): array
    {
        return [
            'SEARCH_HEADLINE',
            'PRODUCT_DATE',
            'FIELD',
            'SHELF',
        ];
    }
}
