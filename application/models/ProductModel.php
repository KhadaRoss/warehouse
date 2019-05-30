<?php

namespace models;

class ProductModel extends Model
{
    /**
     * @param array $data
     *
     * @return int
     */
    public function add(array $data): int
    {
        $this->prepareAndExecute(
            'INSERT INTO products (fieldId, name, quantity, date, comment) VALUES (:fieldId, :name, :quantity, :date, :comment)',
            [
                'name'     => $data['name'],
                'quantity' => $data['quantity'],
                'fieldId'  => $data['fieldId'],
                'date'     => $data['date'],
                'comment'  => $data['comment'],
            ]
        );

        return (int)$this->prepareAndExecute('SELECT MAX(id) as id FROM products')->fetch()['id'];
    }

    /**
     * @param int $fieldId
     *
     * @return array
     */
    public function getByFieldId(int $fieldId): array
    {
        $query = <<<SQL
SELECT id, fieldId, name, quantity, date, comment FROM products WHERE fieldId = :fieldId ORDER BY name ASC
SQL;

        $products = $this->prepareAndExecute($query, ['fieldId' => $fieldId])->fetchAll();

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'id'       => $product['id'],
                'fieldId'  => $product['fieldId'],
                'name'     => $product['name'],
                'quantity' => $product['quantity'],
                'date'     => $product['date'],
                'comment'  => $product['comment'],
            ];
        }

        return $data;
    }
}
