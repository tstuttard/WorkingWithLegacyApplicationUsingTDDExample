<?php

namespace App\Acme;

use PDO;

class PdoCartRepository implements CartRepositoryInterface
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByCustomer(Customer $customer): Cart
    {
        $cartQuery = $this->pdo->prepare(
            'select *, cart_items.id as cart_item_id
from carts
left join cart_items on carts.id = cart_items.cart_id
where customer_id = :customer_id'
        );
        $customerId = $customer->getId();
        $cartQuery->bindParam(':customer_id', $customerId);
        if ($cartQuery->execute()) {
            while ($cartItem = $cartQuery->fetch()) {
                if (!isset($cart)) {
                    $cart = new Cart(
                        $cartItem['id'],
                        $cartItem['customer_id'],
                        $customer->getCountryCode(),
                        $customer->getCurrencyCode()
                    );
                }

                $cart->addCartItem(
                    new CartItem(
                        $cartItem['cart_item_id'],
                        $cartItem['item_name'],
                        $cartItem['item_cost'],
                        $cartItem['item_quantity'],
                        $cartItem['isVatable']
                    )
                );
            }
        }

        return $cart;
    }

    public function addCartItem(int $cartId, CartItem $cartItem)
    {
        $cartItemsInsert = $this->pdo->prepare(
            'INSERT INTO `cart_items` (`cart_id`, `item_name`, `item_cost`, `item_quantity`, `isVatable`)
VALUES (:cartId, :name, :cost, :quantity, :isVatable)'
        );
        $cartItemsInsert->bindValue(':cartId', $cartId);
        $cartItemsInsert->bindValue(':name', $cartItem->getItemName());
        $cartItemsInsert->bindValue(':cost', $cartItem->getCost());
        $cartItemsInsert->bindValue(':quantity', $cartItem->getQuantity());
        $cartItemsInsert->bindValue(':isVatable', $cartItem->isVatable());
        $cartItemsInsert->execute();


        $cartItem->setId($this->pdo->lastInsertId());
    }
}
