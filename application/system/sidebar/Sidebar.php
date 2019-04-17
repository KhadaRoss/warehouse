<?php

namespace system\sidebar;

use entities\Shelf;
use models\ShelfModel;

class Sidebar
{
    /** @var Shelf[] */
    private $entries;

    public function __construct()
    {
        $this->entries = (new ShelfModel())->getAll();
    }

    /**
     * @return array
     */
    public function getTwigData(): array
    {
        $data = [];

        foreach ($this->entries as $entry) {
            $data[] = [
                'id'   => $entry->getId(),
                'name' => $entry->getName(),
            ];
        }

        return $data;
    }
}
