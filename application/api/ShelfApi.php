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
     * @param Request    $request
     * @param Response   $response
     * @param ShelfModel $shelfModel
     */
    public function __construct(Request $request, Response $response, ShelfModel $shelfModel)
    {
        $this->shelfModel = $shelfModel;

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
     * @param int $id
     *
     * @return string
     */
    public function deleteShelf(int $id): string
    {
        $success = $this->shelfModel->delete($id);

        return $this->asJson(['success' => $success]);
    }

    /**
     * @return string
     */
    public function getAll(): string
    {
        return $this->asJson(['shelves' => $this->shelfModel->getAllShelvesWithFields()]);
    }
}
