<?php

namespace App\Acme;

class CartItem
{
    /**
     * @var int|null
     */
    private $id;
    /**
     * @var string
     */
    private $itemName;
    /**
     * @var int
     */
    private $cost;

    /**
     * @var int
     */
    private $quantity;
    /**
     * @var bool
     */
    private $isVatable;


    public function __construct(?int $id, string $itemName, int $cost, int $quantity, bool $isVatable)
    {
        $this->id = $id;
        $this->itemName = $itemName;
        $this->cost = $cost;
        $this->quantity = $quantity;
        $this->isVatable = $isVatable;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function getCost(): int
    {
        return $this->cost;
    }


    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return bool
     */
    public function isVatable(): bool
    {
        return $this->isVatable;
    }

    public function getFormattedTotalCost(): string
    {
        return number_format($this->getCost() * $this->getQuantity() / 100, 2);
    }
}
