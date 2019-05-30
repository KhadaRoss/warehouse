<?php

namespace entities;

class Product
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $quantity;
    /** @var string */
    private $date;
    /** @var string */
    private $comment;

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
     * @return Product
     */
    public function setId(int $id): Product
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
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuantity(): string
    {
        return (string)$this->quantity;
    }

    /**
     * @param string $quantity
     *
     * @return Product
     */
    public function setQuantity(string $quantity): Product
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return trim((string)$this->date);
    }

    /**
     * @param string $date
     *
     * @return Product
     */
    public function setDate(string $date): Product
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return trim((string)$this->comment);
    }

    /**
     * @param string $comment
     *
     * @return Product
     */
    public function setComment(string $comment): Product
    {
        $this->comment = $comment;

        return $this;
    }
}
