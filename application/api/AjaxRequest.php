<?php

namespace api;

use product\ProductModel;

class AjaxRequest
{
    /**
     * @param array $args
     *
     * @return array
     */
    public function getProductInformation(array $args): array
    {
        return (new ProductModel())->getByProductId((int)$args['id']);
    }

    /**
     * @param array $args
     *
     * @return int
     */
    public function productFieldUpdate(array $args): int
    {
        (new ProductModel())->update($args);

        return (int)$args['id'];
    }

    /**
     * @param array $args
     *
     * @return array
     */
    public function deleteProduct(array $args): array
    {
        $productModel = new ProductModel();
        $productModel->delete((int)$args['id']);

        return $productModel->getByFieldId((int)$args['fieldId']);
    }

    /**
     * @param array $args
     *
     * @return array
     */
    public function searchGroup(array $args): array
    {
        return (new ProductModel())->searchGroup($args['search']);
    }
}
