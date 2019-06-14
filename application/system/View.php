<?php

namespace system;

use identity\LoginView;
use sidebar\SidebarModel;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

abstract class View
{
    /** @var Environment */
    protected $twig;
    /** @var array */
    protected $output = [];
    /** @var string */
    protected $template;

    /**
     * @param array $output
     */
    public function __construct(array $output)
    {
        $this->initTwig();
        $this->initOutput($output);

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
    private function initOutput(array $output): void
    {
        $this->output = $output;
        $this->output['URL'] = URL;
        $this->output['LANG'] = SettingsModel::get('CURRENT_LANGUAGE');

        if (!$this instanceof LoginView) {
            $this->output['SIDEBAR'] = (new SidebarModel($this->args['active'] ?? 0))->getTwigData();
        }
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
