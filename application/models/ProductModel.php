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

    /**
     * @param int $productId
     *
     * @return array
     */
    public function getByProductId(int $productId): array
    {
        $product = $this->prepareAndExecute(
            'SELECT id, fieldId, name, quantity, date, comment FROM products WHERE id = :id LIMIT 1',
            ['id' => $productId]
        )->fetch();

        return [
            'id'       => $product['id'],
            'fieldId'  => $product['fieldId'],
            'name'     => $product['name'],
            'quantity' => $product['quantity'],
            'date'     => $product['date'],
            'comment'  => $product['comment'],
        ];
    }

    /**
     * @param array $args
     */
    public function update(array $args): void
    {
        $this->prepareAndExecute(
            'UPDATE products SET name = :name, quantity = :quantity, date = :date, comment = :comment WHERE id = :id',
            [
                'id'       => $args['id'],
                'name'     => $args['name'],
                'quantity' => $args['quantity'],
                'date'     => $args['date'],
                'comment'  => $args['comment'],
            ]
        );
    }

    /**
     * @param int $productId
     */
    public function delete(int $productId): void
    {
        $this->prepareAndExecute('DELETE FROM products WHERE id = :id', ['id' => $productId]);
    }

    /**
     * @param string $searchTerm
     *
     * @return array
     */
    public function search(string $searchTerm): array
    {
        $query = <<<SQL
SELECT
  p.id as productId,
  p.fieldId as fieldId,
  f.name as fieldName,
  f.shelfId as shelfId,
  s.name as shelfName,
  p.name as productName,
  p.quantity as quantity,
  p.date as date,
  p.comment as comment
FROM products AS p
INNER JOIN fields AS f ON p.fieldId = f.id
INNER JOIN shelves AS s ON f.shelfId = s.id
WHERE p.id LIKE :term
  OR p.fieldId LIKE :term
  OR f.shelfId LIKE :term
  OR p.name LIKE :term
  OR p.quantity LIKE :term
  OR p.date LIKE :term
  OR p.comment LIKE :term
ORDER BY p.name
  ASC;
SQL;

        return $this->prepareAndExecute($query, ['term' => '%' . $searchTerm . '%'])->fetchAll();
    }
}
