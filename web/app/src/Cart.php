<?php
/**
 * Created by PhpStorm.
 * User: thomasstuttard
 * Date: 06/08/2017
 * Time: 14:17
 */

namespace App\Acme;

class Cart
{

    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $customerId;

    /**
     * @var CartItem[]
     */
    private $items;

    /**
     * @var int
     */
    private $totalCost = 0;
    /**
     * @var int
     */
    private $totalTax = 0;
    /**
     * @var float
     */
    private $taxPercentage;
    /**
     * @var string
     */
    private $currencySymbol;

    public function __construct(int $id, int $customerId, string $countryCode, string $currencyCode)
    {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->items = [];

        switch ($countryCode) {
            case 'GBR':
                $this->taxPercentage = 0.2;
                break;
            case 'FRA':
                $this->taxPercentage = 0.2;
                break;
            default:
                $this->taxPercentage = 0.4;
                break;
        }

        switch ($currencyCode) {
            case 'GBP':
                $this->currencySymbol = '£';
                break;
            case 'EUR':
                $this->currencySymbol = '€';
                break;
            default:
                $this->currencySymbol = '$';
                break;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @return CartItem[]
     */
    public function getCartItems()
    {
        return $this->items;
    }

    public function addCartItem(CartItem $cartItem)
    {
        if ($cartItem->isVatable()) {
            $this->totalTax += ceil($cartItem->getQuantity() * $cartItem->getCost() * $this->taxPercentage);
        }
        $this->totalCost += $cartItem->getCost() * $cartItem->getQuantity();
        $this->items[] = $cartItem;
    }

    public function getTotalCostWithoutTax(): int
    {
        return $this->totalCost;
    }

    public function getTotalCostWithTax(): int
    {
        return $this->totalCost + $this->totalTax;
    }

    public function getTotalTax()
    {
        return $this->totalTax;
    }

    public function getFormattedTotalCostWithoutTax(): string
    {
        return number_format($this->getTotalCostWithoutTax() / 100, 2);
    }

    public function getFormattedTotalTax(): string
    {
        return number_format($this->getTotalTax() / 100, 2);
    }

    public function getFormattedTotalCostWithTax(): string
    {
        return number_format($this->getTotalCostWithTax() / 100, 2);
    }

    public function getCurrencySymbol(): string
    {
        return $this->currencySymbol;
    }
}
