<?php

namespace helpers;

class AjaxRequest
{
    /**
     * @var string
     */
    private $response = '';

    /**
     * @param string $request
     * @param array $args
     */
    public function __construct(string $request, array $args) {
        $this->response = \json_encode($this->$request($args));
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->response;
    }
}
