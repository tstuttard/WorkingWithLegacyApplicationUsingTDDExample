<?php

namespace App\Acme;

interface CustomerRepositoryInterface
{
    public function findById(int $customerId): Customer;
}
