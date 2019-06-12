<?php

namespace views;

use helpers\CssHelper;
use helpers\JsHelper;
use models\SettingsModel;
use models\SidebarModel;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

abstract class View
{
    /** @var FilesystemLoader */
    protected $loader;
    /** @var Environment */
    protected $twig;
    /** @var array */
    protected $args = [];
    /** @var array */
    protected $strings = [];
    /** @var array */
    protected $jsStrings = [];
    /** @var array */
    protected $output = [];
    /** @var array */
    private $styles = [];
    /** @var array */
    private $scripts = [];
    /** @var string */
    protected $template;

    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        $this->setTemplate();

        $this->initTwig();
        $this->initArgs($args);
        $this->initOutput();
        $this->initStrings();

        $this->setTwigVariables();
    }

    /**
     * @return void
     */
    private function initTwig(): void
    {
        $this->loader = new FilesystemLoader([TEMPLATES]);
        $this->twig = new Environment($this->loader);
    }

    /**
     * @param array $args
     *
     * @return void
     */
    private function initArgs(array $args): void
    {
        $this->args = $args;
        $this->strings = $this->args['strings'];
    }

    /**
     * @return void
     */
    private function initStrings(): void
    {
        foreach ($this->strings as $id => $string) {
            $this->output[$id] = $string;
        }
    }

    /**
     * @return void
     */
    private function initOutput(): void
    {
        $this->output['URL'] = URL;
        $this->output['LANG'] = SettingsModel::get('CURRENT_LANGUAGE');
    }

    /**
     * @return void
     */
    abstract protected function setTwigVariables(): void;

    /**
     * @return void
     */
    abstract protected function setTemplate(): void;

    /**
     * @return string
     */
    public function render(): string
    {
        if (!$this instanceof LoginView) {
            $this->output['SIDEBAR'] = (new SidebarModel($this->args['active'] ?? 0))->getTwigData();
            $this->addStyles(['warehouse', 'sidebar']);
            $this->addScripts(['sidebar']);
        }

        $this->output['ADD_STYLES'] = (new CssHelper())->getStyles($this->styles);
        $this->output['ADD_SCRIPTS'] = (new JsHelper())->getScripts($this->scripts);
        $this->output['JS_STRINGS'] = \json_encode($this->getJsStrings());

        try {
            return $this->twig->render($this->template, $this->output);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param array $styles
     *
     * @return void
     */
    protected function addStyles(array $styles): void
    {
        $this->styles = \array_merge($this->styles, $styles);
    }

    /**
     * @param array $scripts
     *
     * @return void
     */
    protected function addScripts(array $scripts): void
    {
        $this->scripts = \array_merge($this->scripts, $scripts);
    }

    /**
     * @param array $strings
     */
    protected function addJsStrings(array $strings): void
    {
        $this->jsStrings = \array_merge($this->jsStrings, $strings);
    }

    /**
     * @return array
     */
    private function getJsStrings(): array
    {
        $strings = [];

        return \array_merge($this->jsStrings, $strings);
    }
}
