<?php

namespace App\Acme;

use PDO;

class PdoCustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById(int $customerId): Customer
    {
        $customerQuery = $this->pdo->prepare('select * from customers where id = :id');
        $customerQuery->bindParam(':id', $customerId);

        if ($customerQuery->execute()) {
            $customer = $customerQuery->fetch();
        }

        return new Customer($customer['id'], $customer['name'], $customer['country'], $customer['currency']);
    }
}
