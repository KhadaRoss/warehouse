<?php

namespace views;

class ErrorView extends View
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
        $this->template = 'error.twig';
    }

    /**
     * @return void
     */
    protected function setTwigVariables()
    {
        $this->addStyles(['error']);
    }
}
