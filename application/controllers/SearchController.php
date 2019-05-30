<?php

namespace controllers;

use models\ProductModel;
use views\SearchView;

class SearchController extends Controller
{
    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        parent::__construct($args);

        $this->args['search'] = \str_replace('~', ' ', $this->args[0]);
        unset($this->args[0]);
    }

    /**
     * @return string
     */
    public function product(): string
    {
        $this->args['products'] = (new ProductModel())->search($this->args['search']);

        return (new SearchView($this->args))->render();
    }

    /**
     * @return array
     */
    protected function getStrings(): array
    {
        return [
            'SEARCH_HEADLINE',
            'PRODUCT_DATE',
            'FIELD',
            'SHELF',
        ];
    }
}
