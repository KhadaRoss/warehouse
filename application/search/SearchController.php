<?php

namespace search;

use product\ProductModel;
use sidebar\SidebarModel;
use Slim\Http\Request;
use Slim\Http\Response;
use system\Controller;

class SearchController extends Controller
{
    /** @var string */
    private $searchTerm;
    /** @var ProductModel */
    private $productModel;
    /** @var SearchView */
    private $searchView;

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     */
    public function __construct(Request $request, Response $response, array $args)
    {
        $this->productModel = new ProductModel();
        $this->searchView = new SearchView();
        $this->sidebarModel = new SidebarModel();

        $this->searchTerm = $args['searchTerm'] ?? '';

        parent::__construct($request, $response);
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
