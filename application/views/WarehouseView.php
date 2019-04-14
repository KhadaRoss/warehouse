<?php

namespace views;

class WarehouseView extends View
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
    protected function setTemplate()
    {
        $this->template = 'warehouse.twig';
    }

    /**
     * @return void
     */
    protected function setTwigVariables()
    {
    }
}
