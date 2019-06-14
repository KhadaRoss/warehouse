<?php

namespace error;

class ErrorHandler
{
    /** @var string */
    private $message;
    /** @var string */
    private $headline;

    /**
     * @param string $headline
     * @param string $message
     */
    public function __construct(string $headline, string $message)
    {
        $this->message = $message;
        $this->headline = $headline;
    }

    /**
     * @return void
     */
    public function printError(): void
    {
        echo $this->headline . '<br><br>' . $this->message;
        exit;
    }
}
