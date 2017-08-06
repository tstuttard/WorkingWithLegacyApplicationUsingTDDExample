<?php

namespace App\Acme;

interface CartRepositoryInterface
{
    public function findByCustomerId(int $customerId) : Cart;
}
