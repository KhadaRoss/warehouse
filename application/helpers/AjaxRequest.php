<?php

namespace helpers;

use models\FieldModel;
use models\ProductModel;
use models\ShelfModel;

class AjaxRequest
{
    /** @var string */
    private $response = '';

    /**
     * @param string $request
     * @param array $args
     */
    public function __construct(string $request, array $args)
    {
        $this->response = \json_encode($this->$request($args));
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->response;
    }

    /**
     * @param array $args
     *
     * @return int
     */
    private function newShelf(array $args): int
    {
        return (new ShelfModel())->add($args['name']);
    }

    /**
     * @param array $args
     *
     * @return bool
     */
    private function deleteShelf(array $args): bool
    {
        return (new ShelfModel())->delete((int)$args['id']);
    }

    /**
     * @param array $args
     *
     * @return int
     */
    private function newField(array $args): int
    {
        return (new FieldModel())->add($args['name'], (int)$args['shelfId']);
    }

    /**
     * @param array $args
     *
     * @return bool
     */
    private function deleteField(array $args): bool
    {
        return (new FieldModel())->delete((int)$args['id']);
    }

    /**
     * @param array $args
     *
     * @return int
     */
    private function productFieldAdd(array $args): int
    {
        return (new ProductModel())->add($args);
    }

    /**
     * @param array $args
     *
     * @return array
     */
    private function getProductsByFieldId(array $args): array
    {
        return (new ProductModel())->getByFieldId((int)$args['id']);
    }

    /**
     * @param array $args
     *
     * @return array
     */
    private function getProductInformation(array $args): array
    {
        return (new ProductModel())->getByProductId((int)$args['id']);
    }

    /**
     * @param array $args
     *
     * @return int
     */
    private function productFieldUpdate(array $args): int
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
