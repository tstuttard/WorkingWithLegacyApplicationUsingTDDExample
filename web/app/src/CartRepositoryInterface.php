<?php

namespace App\Acme;

interface CartRepositoryInterface
{
    public function findByCustomer(Customer $customer) : Cart;

    public function addCartItem(int $cartId, CartItem $cartItem);
}
