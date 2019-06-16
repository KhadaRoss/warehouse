<?php

namespace api;

use Slim\Http\Request;
use Slim\Http\Response;

class Api
{
    /** @var Request */
    protected $request;
    /** @var Response */
    protected $response;

    /**
     * @param Request  $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param array $data
     *
     * @return string
     */
    protected function asJson(array $data): string
    {
        return \json_encode($data);
    }
}
