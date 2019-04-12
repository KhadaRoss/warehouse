<?php

namespace entities;

class Route
{
    /** @var string */
    private $controllerName;

    /** @var string */
    private $controllerMethod;

    /** @var array */
    private $controllerArgs;

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return \trim((string)$this->controllerName);
    }

    /**
     * @param string $ControllerName
     *
     * @return Route
     */
    public function setControllerMethod(string $ControllerName): Route
    {
        $this->controllerMethod = empty($ControllerName) ? 'index' : $ControllerName;

        return $this;
    }

    /**
     * @return string
     */
    public function getControllerMethod(): string
    {
        return \trim((string)$this->controllerMethod);
    }

    /**
     * @param string $controllerName
     *
     * @return Route
     */
    public function setControllerName(string $controllerName): Route
    {
        $this->controllerName = $controllerName;

        return $this;
    }

    /**
     * @return array
     */
    public function getControllerArgs(): array
    {
        return (array)$this->controllerArgs;
    }

    /**
     * @param array $controllerArgs
     *
     * @return Route
     */
    public function setControllerArgs(array $controllerArgs): Route
    {
        $this->controllerArgs = $controllerArgs;

        return $this;
    }
}
