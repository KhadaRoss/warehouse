<?php

namespace models;

use entities\Shelf;

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
}