<?php

namespace system;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

abstract class View implements ViewInterface
{
    /** @var Environment */
    protected $twig;
    /** @var array */
    protected $output = [];
    /** @var string */
    protected $template;

    public function __construct()
    {
        $this->initTwig();
        $this->setTemplate();
    }

    /**
     * @return void
     */
    private function initTwig(): void
    {
        $loader = new FilesystemLoader([TEMPLATES]);
        $this->twig = new Environment($loader);
    }

    /**
     * @param array $output
     */
    public function setOutput(array $output): void
    {
        $this->output = $output;
    }

    /**
     * @return void
     */
    abstract protected function setTemplate(): void;

    /**
     * @return string
     */
    public function render(): string
    {
        try {
            return $this->twig->render($this->template, $this->output);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $e->getMessage();
        }
    }
}
