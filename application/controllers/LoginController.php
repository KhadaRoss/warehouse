<?php
/**
 * @copyright Copyright (c) rexx systems GmbH
 *
 * @link https://www.rexx-systems.com
 *
 * This software is protected by copyright.
 *
 * It is not permitted to copy, present, send, lease and / or lend the website
 * or individual parts thereof without the consent of the copyright holder.
 *
 * Contravention of this law will result in proceedings under criminal
 * or civil law.
 *
 * All rights reserved.
 */

namespace controllers;

use views\LoginView;

class LoginController extends Controller
{
    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        parent::__construct($args);
    }

    /**
     * @return string
     */
    public function index(): string
    {
        return (new LoginView($this->args))->render();
    }

    protected function getStrings()
    {
        return [
            'LOGIN'
        ];
    }
}
