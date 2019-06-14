<?php

namespace shelf;

use system\Model;

class ShelfModel extends Model
{
    /**
     * @return Shelf[]
     */
    public function getAll(): array
    {
        $shelves = $this->prepareAndExecute('SELECT * FROM shelves');
        $entities = [];

        foreach ($shelves->fetchAll() as $shelf) {
            $entities[] = (new Shelf())
                ->setId($shelf['id'])
                ->setName($shelf['name']);
        }

        return $entities;
    }

    /**
     * @param int $id
     *
     * @return Shelf
     */
    public function get(int $id): Shelf
    {
        $shelf = $this->prepareAndExecute(
            'SELECT * FROM shelves WHERE id = :id',
            ['id' => $id]
        )->fetch();


        $entity = new Shelf();

        if ($shelf) {
            $entity->setId($shelf['id']);
            $entity->setName($shelf['name']);
        }

        return $entity;
    }

    /**
     * @param string $name
     *
     * @return int
     */
    public function add(string $name): int
    {
        $this->prepareAndExecute(
            'INSERT INTO shelves (name) VALUES (:name)',
            ['name' => $name]
        );

        return (int)$this->prepareAndExecute('SELECT MAX(id) AS id FROM shelves')->fetch()['id'];
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $fields = $this->prepareAndExecute(
            'SELECT id FROM fields WHERE shelfId = :shelfId',
            ['shelfId' => $id]
        )->fetchAll();

        $fieldsToDelete = [];
        foreach ($fields as $field) {
            $fieldsToDelete[] = (int)$field['id'];
        }

        if (!empty($fieldsToDelete)) {
            $in = \implode(',', $fieldsToDelete);
            $this->prepareAndExecute("DELETE FROM products WHERE fieldId IN({$in})");
        }

        $this->prepareAndExecute(
            'DELETE FROM fields WHERE shelfId = :shelfId',
            ['shelfId' => $id]
        );

        return (int)$this->prepareAndExecute(
            'DELETE FROM shelves WHERE id = :id',
            ['id' => $id]
        )->rowCount() > 0;
    }
}
