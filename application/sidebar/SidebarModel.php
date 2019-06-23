<?php

namespace sidebar;

use PDO;
use shelf\Shelf;
use shelf\ShelfModel;
use system\Model;

class SidebarModel extends Model
{
    /** @var Shelf[] */
    private $entries;
    /** @var int */
    private $activeId = 0;

    /**
     * @param PDO        $database
     * @param ShelfModel $shelfModel
     */
    public function __construct(PDO $database, ShelfModel $shelfModel)
    {
        parent::__construct($database);

        $this->entries = $shelfModel->getAll();
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
                'id'    => $entry->getId(),
                'name'  => $entry->getName(),
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
