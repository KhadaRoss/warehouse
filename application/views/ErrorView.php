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
    protected function setTemplate(): void
    {
        $this->template = 'error.twig';
    }

    /**
     * @return void
     */
    protected function setTwigVariables(): void
    {
        $this->addStyles(['error']);
    }
}
