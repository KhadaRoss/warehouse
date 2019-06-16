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
