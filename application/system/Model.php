<?php

namespace system;

use PDO;
use PDOStatement;

abstract class Model
{
    /** @var PDO */
    protected $db;

    /**
     * @param PDO $database
     */
    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    /**
     * @param string $query
     * @param array  $placeholders
     *
     * @return PDOStatement
     */
    public function prepareAndExecute(string $query, array $placeholders = []): PDOStatement
    {
        $statement = $this->db->prepare($query);

        foreach ($placeholders as $key => $placeholder) {
            $placeholders[':' . $key] = $placeholder;
            unset($placeholders[$key]);
        }

        $statement->execute($placeholders);

        return $statement;
    }
}
