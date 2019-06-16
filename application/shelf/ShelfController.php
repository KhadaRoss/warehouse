<?php

namespace shelf;

use field\FieldModel;
use sidebar\SidebarModel;
use Slim\Http\Request;
use Slim\Http\Response;
use system\Controller;

class ShelfController extends Controller
{
    /** @var int */
    private $activeId;
    /** @var FieldModel */
    private $fieldModel;
    /** @var ShelfModel */
    private $shelfModel;
    /** @var ShelfView */
    private $shelfView;

    /**
     * @param Request  $request
     * @param Response $response
     * @param int      $activeId
     */
    public function __construct(Request $request, Response $response, int $activeId)
    {
        $this->fieldModel = new FieldModel();
        $this->shelfModel = new ShelfModel();
        $this->shelfView = new ShelfView();
        $this->sidebarModel = new SidebarModel();

        $this->activeId = $activeId;
        $this->sidebarModel->setActiveId($this->activeId);

        parent::__construct($request, $response);
    }

    /**
     * @return string
     */
    public function show(): string
    {
        $this->output['CURRENT_SHELF'] = $this->activeId;
        $this->output['CURRENT_SHELF_NAME'] = $this->shelfModel->get($this->activeId)->getName();
        $this->output['FIELDS'] = $this->fieldModel->getTwigDataByShelfId($this->activeId);

        $this->shelfView->setOutput($this->output);

        return $this->shelfView->render();
    }

    /**
     * @return array
     */
    protected function getChildStrings(): array
    {
        return [
            'SHELF',
            'DELETE_SHELF_HEADLINE',
            'DELETE_SHELF_MESSAGE_1',
            'DELETE_SHELF_MESSAGE_2',
            'DELETE_FIELD_HEADLINE',
            'DELETE_FIELD_MESSAGE_1',
            'DELETE_FIELD_MESSAGE_2',
            'DELETE_YES',
            'DELETE_NO',
            'FIELD_NEW',
            'FIELD_DELETE',
            'NEW_PRODUCT',
            'PRODUCT_ADD_HEADER',
            'PRODUCT_NAME',
            'PRODUCT_QUANTITY',
            'PRODUCT_DATE',
            'PRODUCT_GROUP',
            'PRODUCT_COMMENT',
            'PRODUCT_YES',
            'PRODUCT_NO',
            'PRODUCT_INFORMATION',
            'PRODUCT_UPDATE_YES',
        ];
    }
}
