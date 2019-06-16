<?php

namespace api;

use Slim\Http\Request;
use Slim\Http\Response;

class Api
{
    /** @var Request */
    private $request;
    /** @var Response */
    private $response;

    /**
     * @param Request  $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
