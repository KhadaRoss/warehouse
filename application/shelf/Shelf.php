<?php

namespace shelf;

class Shelf
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->id;
    }

    /**
     * @param int $id
     *
     * @return Shelf
     */
    public function setId(int $id): Shelf
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return trim((string)$this->name);
    }

    /**
     * @param string $name
     *
     * @return Shelf
     */
    public function setName(string $name): Shelf
    {
        $this->name = $name;

        return $this;
    }
}
