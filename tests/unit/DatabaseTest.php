<?php

namespace tests\unit;

use PDO;
use PHPUnit\Framework\TestCase;
use system\Database;

class databaseTest extends TestCase
{
    public function testConnection()
    {
        define('USER', 'root');
        define('PASSWORD', '');
        define('DSN', 'mysql:dbname=warehouse;host=localhost;charset=utf8');

        $database = Database::getConnection();

        $this->assertTrue($database instanceof PDO);
    }
}
