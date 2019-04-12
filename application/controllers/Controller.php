<?php

namespace controllers;

use models\StringsModel;

abstract class Controller
{
    /**
     * @var array
     */
    protected $args = [];

    /**
     * @var array
     */
    private $strings = ['TITLE'];

    /**
     * @param array $args
     */
    public function __construct(array $args)
    {
        $this->strings = \array_merge($this->strings, $this->getStrings());

        $this->args = $args;
        $this->getStringsFromDb();
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return string
     */
    public function __call($name, $arguments): string
    {
        return (new ErrorController([404]))->handle();
    }

    /**
     * @return array
     */
    abstract protected function getStrings();

    /**
     * @return void
     */
    private function getStringsFromDb()
    {
        $this->args['strings'] = (new StringsModel())->getAll($this->strings);
    }
}
