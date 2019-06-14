<?php

namespace error;

use system\Controller;

class ErrorController extends Controller
{
    /**
     * @param array $request
     */
    public function __construct(array $request)
    {
        parent::__construct($request);
    }

    /**
     * @return string
     */
    public function handle(): string
    {
        return (new ErrorView($this->request))->render();
    }

    /**
     * @return array
     */
    protected function getChildStrings(): array
    {
        return [
            'ERROR',
        ];
    }
}
