<?php

use PHPUnit\Framework\TestCase;
use shelf\ShelfModel;
use system\Database;

class ShelfModelTest extends TestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        define('USER', 'root');
        define('PASSWORD', '');
        define('DSN', 'mysql:dbname=warehousetest;host=localhost;charset=utf8');
    }

    /**
     * @return void
     */
    public function testShelfModel(): void
    {
        $database = Database::getConnection();
        $shelfModel = new ShelfModel($database);

        $shelfId_1 = $shelfModel->add('testShelf1');
        $shelfId_2 = $shelfModel->add('testShelf2');

        $shelf1 = $shelfModel->get($shelfId_1);
        $shelf2 = $shelfModel->get($shelfId_2);

        $this->assertEquals($shelfId_1, $shelf1->getId());
        $this->assertEquals($shelfId_2, $shelf2->getId());
        $this->assertEquals('testShelf1', $shelf1->getName());
        $this->assertEquals('testShelf2', $shelf2->getName());

        $this->assertEquals(
            $shelfModel->getAll(),
            [$shelf1, $shelf2]
        );

        $shelfModel->delete($shelfId_1);
        $shelfModel->delete($shelfId_2);
    }
}
