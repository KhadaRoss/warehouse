<?php

namespace error;

use system\View;

class ErrorView extends View
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
