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
     * @return string
     */
    public function newShelf(): string
    {
        $name = $this->request->getParsedBodyParam('name');
        $newId = $this->shelfModel->add($name);

        return $this->asJson(['id' => $newId, 'name' => $name]);
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
