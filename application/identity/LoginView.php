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

    /**
     * @param array $output
     */
    public function setOutput(array $output): void
    {
        parent::setOutput($output);
    }
}
