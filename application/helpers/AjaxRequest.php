<?php

namespace helpers;

use models\FieldModel;
use models\ProductModel;
use models\ShelfModel;

class AjaxRequest
{
    /**
     * @param array $args
     *
     * @return int
     */
    public function newShelf(array $args): int
    {
        return (new ShelfModel())->add($args['name']);
    }

    /**
     * @param array $args
     *
     * @return bool
     */
    public function deleteShelf(array $args): bool
    {
        return (new ShelfModel())->delete((int)$args['id']);
    }

    /**
     * @param array $args
     *
     * @return int
     */
    public function newField(array $args): int
    {
        return (new FieldModel())->add($args['name'], (int)$args['shelfId']);
    }

    /**
     * @param array $args
     *
     * @return bool
     */
    public function deleteField(array $args): bool
    {
        return (new FieldModel())->delete((int)$args['id']);
    }

    /**
     * @param array $args
     *
     * @return int
     */
    public function productFieldAdd(array $args): int
    {
        return (new ProductModel())->add($args);
    }

    /**
     * @param array $args
     *
     * @return array
     */
    public function getProductsByFieldId(array $args): array
    {
        return (new ProductModel())->getByFieldId((int)$args['id']);
    }

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

    public function deleteProduct(array $args): array
    {
        $productModel = new ProductModel();
        $productModel->delete((int)$args['id']);

        return $productModel->getByFieldId((int)$args['fieldId']);
    }
}
