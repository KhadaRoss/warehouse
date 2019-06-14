<?php

namespace home;

use system\Controller;

class HomeController extends Controller
{
    const CONTROLLER_KEY = 'home';

    /**
     * @param array $request
     */
    public function __construct(array $request)
    {
        parent::__construct($request);
    }

    /**
     * @return string
     */
    public function index(): string
    {
        return (new HomeView($this->request))->render();
    }

    /**
     * @return array
     */
    protected function getChildStrings(): array
    {
        return [
            'WAREHOUSE',
        ];
    }
}
