<?php

namespace App\Acme;

class TaxCalculator
{
    /**
     * @var string
     */
    private $countryCode;
    /**
     * @var CartItem[]|array
     */
    private $cartItems;

    /**
     * @var float
     */
    private $taxPercentage;
    /**
     * @var int
     */
    private $totalTax;

    /**
     * TaxCalculator constructor.
     * @param string $countryCode
     * @param CartItem[] $cartItems
     */
    public function __construct(string $countryCode, array $cartItems)
    {
        $this->countryCode = $countryCode;
        $this->cartItems = $cartItems;
        $this->totalTax = 0;

        foreach ($this->cartItems as $cartItem) {
            if ($cartItem->isVatable()) {
                $this->totalTax += ceil($cartItem->getQuantity() * $cartItem->getCost() * $this->getTaxPercentage());
            }
        }
    }

    public function getTaxPercentage(): float
    {
        if (!isset($this->taxPercentage)) {
            switch ($this->countryCode) {
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
        }

        return $this->taxPercentage;
    }


    public function getTotalTax(): int
    {
        return $this->totalTax;
    }
}
