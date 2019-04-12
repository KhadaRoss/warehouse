<?php

namespace helpers;

class Request
{
    /** @var Request */
    private static $instance;
    /** @var array */
    private $get;
    /** @var array */
    private $post;

    private function __construct()
    {
        $this->get = &$_GET;
        $this->post = &$_POST;

        self::$instance = $this;
    }

    /**
     * @return Request
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function isSetPost(string $key): bool
    {
        return isset($this->post[$key]);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getPost(string $key): string
    {
        return $this->post[$key] ?? '';
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function isSetGet(string $key): bool
    {
        return isset($this->get[$key]);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getGet(string $key): string
    {
        return $this->get[$key] ?? '';
    }
}
