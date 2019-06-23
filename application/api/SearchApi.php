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
     * @param Request      $request
     * @param Response     $response
     * @param ProductModel $productModel
     */
    public function __construct(Request $request, Response $response, ProductModel $productModel)
    {
        $this->productModel = $productModel;

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
