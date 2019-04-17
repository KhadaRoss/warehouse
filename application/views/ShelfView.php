<?php

namespace views;

class ShelfView extends View
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
        $this->template = 'shelf.twig';
    }

    /**
     * @return void
     */
    protected function setTwigVariables(): void
    {
        $this->addStyles(['shelf']);
    }
}
