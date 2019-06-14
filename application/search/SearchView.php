<?php

namespace search;

use system\View;

class SearchView extends View
{
    /**
     * @param array $output
     */
    public function __construct(array $output)
    {
        parent::__construct($output);
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
        $this->output['PRODUCTS'] = $this->args['products'];
        $this->output['SEARCH_TERM'] = $this->args['search'];
        $this->addStyles(['search']);
        $this->addScripts(['search']);
    }
}
