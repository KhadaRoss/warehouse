<?php

namespace views;

require_once BASE_PATH . 'vendor/Twig.php';

use helpers\CssHelper;
use helpers\JsHelper;
use system\settings\SystemSettings;
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
    protected $output = [];
    /** @var array */
    private $styles = ['warehouse'];
    /** @var array */
    private $scripts = ['warehouse'];

    /**
     * @var string
     */
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
    private function initTwig()
    {
        $this->loader = new Twig_Loader_Filesystem([TEMPLATES]);
        $this->twig = new Twig_Environment($this->loader);
    }

    /**
     * @param array $args
     */
    private function initArgs(array $args)
    {
        $this->args = $args;
        $this->strings = $this->args['strings'];
    }

    /**
     * @return void
     */
    private function initStrings()
    {
        foreach ($this->strings as $id => $string) {
            $this->output[$id] = $string;
        }
    }

    /**
     * @return void
     */
    private function initOutput()
    {
        $this->output['URL'] = URL;
        $this->output['LANG'] = SystemSettings::get('CURRENT_LANGUAGE');
    }

    /**
     * @return void
     */
    abstract protected function setTwigVariables();

    /**
     * @return void
     */
    abstract protected function setTemplate();

    /**
     * @return string
     */
    public function render(): string
    {
        $this->output['ADD_STYLES'] = (new CssHelper())->getStyles($this->styles);
        $this->output['ADD_SCRIPTS'] = (new JsHelper())->getScripts($this->scripts);

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
    protected function addStyles(array $styles)
    {
        $this->styles = \array_merge($this->styles, $styles);
    }

    /**
     * @param array $scripts
     *
     * @return void
     */
    protected function addScripts(array $scripts)
    {
        $this->scripts = \array_merge($this->scripts, $scripts);
    }
}
