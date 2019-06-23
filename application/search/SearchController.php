<?php

namespace search;

use product\ProductModel;
use sidebar\SidebarModel;
use Slim\Http\Request;
use Slim\Http\Response;
use system\Controller;
use system\StringsModel;

class SearchController extends Controller
{
    /** @var string */
    private $searchTerm;
    /** @var ProductModel */
    private $productModel;
    /** @var SearchView */
    private $searchView;

    /**
     * @param Request      $request
     * @param Response     $response
     * @param array        $args
     * @param StringsModel $stringsModel
     * @param ProductModel $productModel
     * @param SearchView   $searchView
     * @param SidebarModel $sidebarModel
     * @param bool         $isLoggedIn
     */
    public function __construct(
        Request $request,
        Response $response,
        array $args,
        StringsModel $stringsModel,
        ProductModel $productModel,
        SearchView $searchView,
        SidebarModel $sidebarModel,
        bool $isLoggedIn
    ) {
        $this->productModel = $productModel;
        $this->searchView = $searchView;
        $this->sidebarModel = $sidebarModel;

        $this->searchTerm = $args['searchTerm'] ?? '';

        parent::__construct($request, $response, $stringsModel, $isLoggedIn);
    }

    /**
     * @return string
     */
    public function index(): string
    {
        $this->output['PRODUCTS'] = $this->productModel->search($this->searchTerm);
        $this->output['SEARCH_TERM'] = $this->searchTerm;

        $this->searchView->setOutput($this->output);

        return $this->searchView->render();
    }

    /**
     * @return array
     */
    protected function getChildStrings(): array
    {
        return [
            'SEARCH_HEADLINE',
            'PRODUCT_DATE',
            'FIELD',
            'SHELF',
        ];
    }
}
