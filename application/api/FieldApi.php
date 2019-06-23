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

    /**
     * @param Request      $request
     * @param Response     $response
     * @param FieldModel   $fieldModel
     * @param ProductModel $productModel
     */
    public function __construct(
        Request $request,
        Response $response,
        FieldModel $fieldModel,
        ProductModel $productModel
    ) {
        $this->fieldModel = $fieldModel;
        $this->productModel = $productModel;

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
