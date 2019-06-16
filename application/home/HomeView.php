<?php

namespace home;

use system\View;

class HomeView extends View
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
        $this->template = 'warehouse.twig';
    }

    /**
     * @param array $output
     */
    public function setOutput(array $output): void
    {
        parent::setOutput($output);
    }
}
