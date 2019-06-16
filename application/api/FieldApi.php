<?php

namespace api;

use field\FieldModel;
use product\ProductModel;
use Slim\Http\Request;
use Slim\Http\Response;

class FieldApi extends Api
{
    /** @var FieldModel */
    private $fieldModel;
    /** @var ProductModel */
    private $productModel;

    public function __construct(Request $request, Response $response)
    {
        $this->fieldModel = new FieldModel();
        $this->productModel = new ProductModel();

        parent::__construct($request, $response);
    }

    /**
     * @return string
     */
    public function newField(): string
    {
        $name = $this->request->getParsedBodyParam('name');
        $shelfId = (int)$this->request->getParsedBodyParam('shelfId');

        $newId = $this->fieldModel->add($name, $shelfId);

        return $this->asJson(['id' => $newId]);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function deleteField(int $id): bool
    {
        $success = $this->fieldModel->delete($id);

        return $this->asJson(['success' => $success]);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function getProductsByFieldId(int $id): string
    {
        return $this->asJson($this->productModel->getByFieldId($id));
    }
}
