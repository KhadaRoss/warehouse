<?php

namespace helpers;

use PDO;
use PDOException;

class Database
{
    /** @var PDO  */
    private $db;
    /** @var Database */
    private static $instance;
    /** @var array  */
    private $options = [
        PDO::ATTR_EMULATE_PREPARES   => true,
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    private function __construct()
    {
        try {
            $this->db = (new PDO(\DSN, \USER, \PASSWORD, $this->options));
        } catch (PDOException $e) {
            (new ErrorHandler('Connection failed', $e->getMessage()))->printError();
        }
    }

    /**
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (!isset(static::$instance)) {
            static::$instance = new self();
        }

        return static::$instance->db;
    }
}
