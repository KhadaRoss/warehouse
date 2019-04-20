<?php

namespace helpers;

class AjaxRequest
{
    /** @var string */
    private $response = '';

    /**
     * @param string $request
     * @param array $args
     */
    public function __construct(string $request, array $args)
    {
        $this->response = \json_encode($this->$request($args));
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->response;
    }

    /**
     * @param array $args
     *
     * @return int
     */
    private function newShelf(array $args): int
    {
        echo $args['name']; exit;

        return 1;
    }

    private function searchShelf(array $args): array
    {
        echo $args['name']; exit;

        return [];
    }
}
