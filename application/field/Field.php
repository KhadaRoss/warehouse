<?php

namespace field;

class Field
{
    /** @var int */
    private $id;
    /** @var int */
    private $shelfId;
    /** @var string */
    private $name;
    /** @var int */
    private $position;

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
     * @return Field
     */
    public function setId(int $id): Field
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getShelfId(): int
    {
        return (int)$this->shelfId;
    }

    /**
     * @param int $shelfId
     *
     * @return Field
     */
    public function setShelfId(int $shelfId): Field
    {
        $this->shelfId = $shelfId;

        return $this;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return trim((string)$this->name);
    }

    /**
     * @param string $name
     *
     * @return Field
     */
    public function setName(string $name): Field
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return (int)$this->position;
    }

    /**
     * @param int $position
     *
     * @return Field
     */
    public function setPosition(int $position): Field
    {
        $this->position = $position;

        return $this;
    }
}
