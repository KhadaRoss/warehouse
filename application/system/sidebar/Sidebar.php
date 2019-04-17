<?php

namespace system\sidebar;

use entities\Shelf;
use models\ShelfModel;

class Sidebar
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
