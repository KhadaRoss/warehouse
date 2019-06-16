<?php

namespace shelf;

use system\View;

class ShelfView extends View
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
        $this->template = 'shelf.twig';
    }
}
