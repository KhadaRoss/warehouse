<?php

namespace tests\unit;

use PDO;
use PHPUnit\Framework\TestCase;
use system\Database;

class databaseTest extends TestCase
{
    public function testConnection()
    {
        defined('USER') or define('USER', 'root');
        defined('PASSWORD') or define('PASSWORD', '');
        defined('DSN') or define('DSN', 'mysql:dbname=warehousetest;host=localhost;charset=utf8');

        $database = Database::getConnection();

        $this->assertTrue($database instanceof PDO);
    }
}
