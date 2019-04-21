<?php

namespace helpers;

use models\FieldModel;
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
     * @return array
     */
    private function searchShelf(array $args): array
    {
        echo $args['name']; exit;

        return [];
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
}
