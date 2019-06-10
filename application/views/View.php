<?php

namespace views;

require_once BASE_PATH . 'vendor/Twig.php';

use helpers\CssHelper;
use helpers\JsHelper;
use models\SettingsModel;
use models\SidebarModel;
use Twig_Environment;
use Twig_Loader_Filesystem;

abstract class View
{
    /** @var Twig_Loader_Filesystem */
    protected $loader;
    /** @var Twig_Environment */
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
        $this->loader = new Twig_Loader_Filesystem([TEMPLATES]);
        $this->twig = new Twig_Environment($this->loader);
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
        } catch (\Twig_Error_Runtime | \Twig_Error_Loader | \Twig_Error_Syntax $e) {
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
