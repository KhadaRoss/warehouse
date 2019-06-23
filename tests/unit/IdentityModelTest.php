<?php

use identity\IdentityModel;
use PHPUnit\Framework\TestCase;
use system\Database;

class IdentityModelTest extends TestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        defined('USER') or define('USER', 'root');
        defined('PASSWORD') or define('PASSWORD', '');
        defined('DSN') or define('DSN', 'mysql:dbname=warehousetest;host=localhost;charset=utf8');
    }

    /**
     * @return void
     */
    public function testIdentityModel(): void
    {
        $database = Database::getConnection();

        $identityModel = new IdentityModel($database, 0, 'guest');
        $this->assertTrue(IdentityModel::get($database) instanceof IdentityModel);

        $this->assertFalse(IdentityModel::isLoggedIn($database));
        $this->assertEquals(0, $identityModel->getUserId());
        $this->assertEquals('guest', $identityModel->getUserName());

        $identityModel = new IdentityModel($database, 1, 'test');
        $this->assertTrue(IdentityModel::isLoggedIn($database));
        $this->assertEquals(1, $identityModel->getUserId());
        $this->assertEquals('test', $identityModel->getUserName());

        IdentityModel::reset($database);
        $this->assertFalse(IdentityModel::isLoggedIn($database));
    }
}
