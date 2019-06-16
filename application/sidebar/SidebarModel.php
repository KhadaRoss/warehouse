<?php

namespace sidebar;

use shelf\Shelf;
use shelf\ShelfModel;

class SidebarModel
{
    /** @var Shelf[] */
    private $entries;
    /** @var int */
    private $activeId = 0;

    public function __construct()
    {
        $this->entries = (new ShelfModel())->getAll();
    }

    /**
     * @param int $activeId
     *
     * @return SidebarModel
     */
    public function setActiveId(int $activeId): SidebarModel
    {
        $this->activeId = $activeId;

        return $this;
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
