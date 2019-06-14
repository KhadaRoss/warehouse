<?php

namespace home;

use system\View;

class HomeView extends View
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
        $this->template = 'warehouse.twig';
    }

    /**
     * @return void
     */
    protected function setTwigVariables(): void
    {
    }
}
