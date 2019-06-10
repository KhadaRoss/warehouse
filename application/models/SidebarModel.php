<?php

namespace models;

use entities\Shelf;

class SidebarModel
{
    /** @var Shelf[] */
    private $entries;
    /** @var int */
    private $activeId;

    public function __construct(int $activeId)
    {
        $this->activeId = $activeId;
        $this->entries = (new ShelfModel())->getAll();
    }

    /**
     * @return array
     */
    public function getTwigData(): array
    {
        $data = [];

        foreach ($this->entries as $entry) {
            $menuEntry = [
                'id'   => $entry->getId(),
                'name' => $entry->getName(),
                'class' => '',
            ];

            if ($this->activeId === $entry->getId()) {
                $menuEntry['class'] = 'active';
            }

            $data[] = $menuEntry;
        }

        return $data;
    }
}
