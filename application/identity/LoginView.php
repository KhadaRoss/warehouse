<?php

namespace identity;

use system\View;

class LoginView extends View
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
        $this->template = 'login.twig';
    }
}
