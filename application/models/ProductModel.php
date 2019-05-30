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
            'INSERT INTO products (name, quantity, date, comment) VALUES (:name, :quantity, :date, :comment)',
            [
                'name'     => $data['name'],
                'quantity' => $data['quantity'],
                'date'     => $data['date'],
                'comment'  => $data['comment'],
            ]
        );

        return (int)$this->prepareAndExecute('SELECT MAX(id) as id FROM products')->fetch()['id'];
    }
}
