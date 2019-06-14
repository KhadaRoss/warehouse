<?php

namespace system;

use Slim\Http\Request;
use Slim\Http\Response;

abstract class Controller
{
    /** @var Request */
    protected $request;
    /** @var Response */
    protected $response;
    /** @var array */
    protected $output;

    /**
     * @param Request  $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;

        $this->initStrings();

        return $this;
    }

    /**
     * @param Request  $request
     * @param Response $response
     *
     * @return string
     */
    public function __call(Request $request, Response $response): string
    {
        return $response->withStatus(404)->withRedirect('/error');
    }

    /**
     * @return void
     */
    private function initStrings(): void
    {
        $this->output = (new StringsModel())->getAll(
            \array_merge(
                $this->getGlobalStrings(),
                $this->getChildStrings()
            )
        );
    }

    /**
     * @return array
     */
    private function getGlobalStrings(): array
    {
        return [
            'TITLE',
            'LOGOUT',
            'SEARCH',
            'NEW',
        ];
    }

    /**
     * @return array
     */
    abstract protected function getChildStrings();
}
