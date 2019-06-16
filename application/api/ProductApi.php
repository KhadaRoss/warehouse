<?php

namespace api;

use product\ProductModel;
use Slim\Http\Request;
use Slim\Http\Response;

class ProductApi extends Api
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
     * @return string
     */
    public function new(): string
    {
        $newProductId = $this->productModel->add($this->request->getParsedBody());

        return $this->asJson(['id' => $newProductId]);
    }

    /**
     * @return string
     */
    public function update(): string
    {
        $newProductId = $this->productModel->update($this->request->getParsedBody());

        return $this->asJson(['id' => $newProductId]);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function get(int $id): string
    {
        $product = $this->productModel->getByProductId($id);

        return $this->asJson($product);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function delete(int $id): string
    {
        $success = $this->productModel->delete($id);

        return $this->asJson(['success' => $success]);
    }
}
