<?php

namespace views;

class LoginView extends View
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
        $this->template = 'login.twig';
    }

    /**
     * @return void
     */
    protected function setTwigVariables()
    {
        $this->addStyles(['login']);
    }
}
