<?php

namespace identity;

use system\View;

class LoginView extends View
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
        $this->template = 'login.twig';
    }
}
