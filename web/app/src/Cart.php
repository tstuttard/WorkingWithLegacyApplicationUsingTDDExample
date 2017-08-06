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

    public function __construct(int $id, int $customerId)
    {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->items = [];
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
        $this->items[] = $cartItem;
    }
}
