<?php

namespace models;

use helpers\Database;
use PDO;
use PDOStatement;

abstract class Model
{
    /**
     * @var PDO
     */
    protected $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * @param string $query
     * @param array $placeholders
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
