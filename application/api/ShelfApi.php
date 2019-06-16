<?php

namespace api;

use shelf\ShelfModel;
use Slim\Http\Request;
use Slim\Http\Response;

class ShelfApi extends Api
{
    /** @var ShelfModel */
    private $shelfModel;

    /**
     * @param Request  $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->shelfModel = new ShelfModel();

        parent::__construct($request, $response);
    }

    /**
     * @param array $args
     *
     * @return int
     */
    public function newShelf(array $args): int
    {
        return $this->shelfModel->add($args['name']);
    }

    /**
     * @param array $args
     *
     * @return bool
     */
    public function deleteShelf(array $args): bool
    {
        return $this->shelfModel->delete((int)$args['id']);
    }
}
