<?php

namespace api;

use product\ProductModel;
use Slim\Http\Request;
use Slim\Http\Response;

class ProductApi extends Api
{
    /** @var ProductModel */
    private $productModel;

    public function __construct(Request $request, Response $response)
    {
        $this->productModel = new ProductModel();

        parent::__construct($request, $response);
    }

    /**
     * @return string
     */
    public function newProduct(): string
    {
        $newProductId = $this->productModel->add($this->request->getParsedBody());

        return $this->asJson(['id' => $newProductId]);
    }
}
