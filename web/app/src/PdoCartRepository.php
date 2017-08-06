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

    public function findByCustomerId(int $customerId): Cart
    {
        $cartQuery = $this->pdo->prepare(
            'select *, cart_items.id as cart_item_id
from carts
left join cart_items on carts.id = cart_items.cart_id
where customer_id = :customer_id'
        );
        $cartQuery->bindParam(':customer_id', $customerId);
        if ($cartQuery->execute()) {
            while ($cartItem = $cartQuery->fetch()) {
                if (!isset($cart)) {
                    $cart = new Cart($cartItem['id'], $cartItem['customer_id']);
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
}
