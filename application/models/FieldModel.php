<?php

namespace models;

class FieldModel extends Model
{
    /**
     * @param string $name
     * @param int $shelfId
     *
     * @return int
     */
    public function add(string $name, int $shelfId): int
    {

        $position = $this->prepareAndExecute(
            'SELECT (MAX(position) + 100) as position FROM fields WHERE shelfId = :shelfId',
            ['shelfId' => $shelfId]
        )->fetch()['position'];

        $this->prepareAndExecute(
            'INSERT INTO fields (shelfId, name, position) VALUES (:shelfId, :name, :position)',
            [
                'name'     => $name,
                'shelfId'  => $shelfId,
                'position' => $position ?? 100
            ]
        );

        return (int)$this->prepareAndExecute('SELECT MAX(id) as id FROM fields')->fetch()['id'];
    }

    /**
     * @param int $shelfId
     *
     * @return array
     */
    public function getTwigDataByShelfId(int $shelfId): array
    {
        $fields = $this->prepareAndExecute(
            'SELECT id, name FROM fields WHERE shelfId = :shelfId ORDER BY position',
            ['shelfId' => $shelfId]
        )->fetchAll();

        $data = [];

        foreach ($fields as $field) {
            $data[] = [
                'id' => $field['id'],
                'name' => $field['name']
            ];
        }

        return $data;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $this->prepareAndExecute('DELETE FROM products WHERE fieldId = :fieldId', ['fieldId' => $id]);

        return (int)$this->prepareAndExecute(
            'DELETE FROM fields WHERE id = :id',
            ['id' => $id]
        )->rowCount() > 0;
    }
}
