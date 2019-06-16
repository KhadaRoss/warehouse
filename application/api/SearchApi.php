<?php

namespace api;

use product\ProductModel;
use Slim\Http\Request;
use Slim\Http\Response;

class SearchApi extends Api
{
    /** @var ProductModel */
    private $productModel;

    /**
     * @param Request  $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->productModel = new ProductModel();

        parent::__construct($request, $response);
    }

    /**
     * @param string $searchTerm
     *
     * @return string
     */
    public function get(string $searchTerm): string
    {
        $search = $this->productModel->searchGroup($searchTerm);

        return $this->asJson($search);
    }
}
