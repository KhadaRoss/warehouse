<?php

use field\FieldModel;
use PHPUnit\Framework\TestCase;
use product\ProductModel;
use shelf\ShelfModel;
use system\Database;

class ProductModelTest extends TestCase
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
    public function testProductModel(): void
    {
        $database = Database::getConnection();
        $productModel = new ProductModel($database);

        $shelfModel = new ShelfModel($database);
        $shelfId = $shelfModel->add('testShelf');

        $fieldModel = new FieldModel($database);
        $fieldId = $fieldModel->add('testField', $shelfId);

        $data = [
            'name'         => 'testName',
            'quantity'     => '1kg',
            'fieldId'      => (string)$fieldId,
            'date'         => '22.03.2018',
            'productGroup' => 'testProductGroup',
            'comment'      => 'testComment',
        ];

        $productId = $productModel->add($data);

        $this->assertIsInt($productId);
        $this->assertGreaterThan(0, $productId);

        $product = $productModel->getByProductId($productId);
        $this->assertEquals(
            $product,
            array_merge($data, ['id' => $productId])
        );

        $dataUpdate = [
            'id'           => $productId,
            'name'         => 'testName2',
            'quantity'     => '2kg',
            'date'         => '22.03.2019',
            'productGroup' => 'testProductGroup2',
            'comment'      => 'testComment2',
        ];

        $this->assertEquals(
            $productModel->getByProductId($productId),
            [
                'id'           => $productId,
                'fieldId'      => $fieldId,
                'name'         => 'testName',
                'quantity'     => '1kg',
                'date'         => '22.03.2018',
                'productGroup' => 'testProductGroup',
                'comment'      => 'testComment',
            ]
        );

        $productModel->update($dataUpdate);

        $groups = $productModel->searchGroup('test');
        $this->assertEquals(reset($groups), $dataUpdate['productGroup']);

        $products = $productModel->search('test');
        $this->assertEquals(
            reset($products),
            [
                'productId'    => $productId,
                'fieldId'      => $fieldId,
                'fieldName'    => 'testField',
                'shelfId'      => $shelfId,
                'shelfName'    => 'testShelf',
                'productName'  => 'testName2',
                'productGroup' => 'testProductGroup2',
                'quantity'     => '2kg',
                'date'         => '22.03.2019',
                'comment'      => 'testComment2',
            ]
        );

        $productModel->delete($productId);
        $fieldModel->delete($fieldId);
        $shelfModel->delete($shelfId);

        $this->assertEmpty($productModel->getByProductId($productId));
        $this->assertEmpty($fieldModel->getTwigDataByShelfId($shelfId));
        $this->assertEmpty($shelfModel->get($shelfId)->getId());
    }
}
