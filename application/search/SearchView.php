<?php

namespace search;

use system\View;

class SearchView extends View
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function setTemplate(): void
    {
        $this->template = 'search.twig';
    }

    /**
     * @return void
     */
    protected function setTwigVariables(): void
    {

    }
}
