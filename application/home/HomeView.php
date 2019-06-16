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
        $this->template = 'home.twig';
    }
}
