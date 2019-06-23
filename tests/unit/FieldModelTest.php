<?php

use field\FieldModel;
use PHPUnit\Framework\TestCase;
use system\Database;

class FieldModelTest extends TestCase
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
    public function testFieldModel(): void
    {
        $fieldModel = new FieldModel(Database::getConnection());

        $newFieldId = 1;
        $newFieldName = 'test';

        $shelfId = $fieldModel->add($newFieldName, $newFieldId);

        $this->assertIsInt($shelfId);
        $this->assertGreaterThan(0, $shelfId);

        $fieldData = $fieldModel->getTwigDataByShelfId($newFieldId);

        $this->assertEquals(reset($fieldData)['name'], $newFieldName);

        $fieldModel->delete((int)reset($fieldData)['id']);

        $this->assertEmpty($fieldModel->getTwigDataByShelfId($newFieldId));
    }
}
