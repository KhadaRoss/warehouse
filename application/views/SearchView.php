<?php

namespace views;

class SearchView extends View
{
    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        parent::__construct($args);
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
