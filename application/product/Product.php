<?php

namespace product;

class Product
{
    /** @var int */
    private $productId;
    /** @var int */
    private $fieldId;
    /** @var int */
    private $shelfId;
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
    public function getProductId(): int
    {
        return (int)$this->productId;
    }

    /**
     * @param int $productId
     *
     * @return Product
     */
    public function setProductId(int $productId): Product
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * @return int
     */
    public function getFieldId(): int
    {
        return (int)$this->fieldId;
    }

    /**
     * @param int $fieldId
     *
     * @return Product
     */
    public function setFieldId(int $fieldId): Product
    {
        $this->fieldId = $fieldId;

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
     * @return Product
     */
    public function setShelfId(int $shelfId): Product
    {
        $this->shelfId = $shelfId;

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
        return trim((string)$this->quantity);
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
