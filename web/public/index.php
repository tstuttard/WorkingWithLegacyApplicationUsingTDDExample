<?php

include '../app/vendor/autoload.php';
$foo = new App\Acme\Foo();

try {
    $dsn = 'mysql:host=mysql;dbname=test;charset=utf8;port=3306';
    $pdo = new PDO($dsn, 'dev', 'dev');
    $cartQuery = $pdo->query('select * from cart left join cart_items on cart.id = cart_items.cart_id');
    $cart = $cartQuery->fetchAll();
    $cartTotal = 0;

} catch (PDOException $e) {
    echo $e->getMessage();
}

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Docker <?php echo $foo->getName(); ?></title>
        <style>
            .cart {
                width: 200px;
            }

            .cart-item {
                margin-bottom: 10px;
            }

            .cart-item-list {
                display: inline;
            }

            .cart-item-price {
                display: inline;
            }
        </style>
    </head>
    <body>
        <h1>Legacy Online Shop</h1>

        <div class="cart">
            <?php foreach ($cart as $cartItem):
                $cartTotal += $cartItem['item_cost'] * $cartItem['item_quantity'];
            ?>
            <div class="cart-item" id="cart-item-<?php $cartItem['id'] ?>"">
                <div class="cart-item-list">
                    <?php echo $cartItem['item_name'] ?> x <?php echo $cartItem['item_quantity'] ?>
                </div>
                <div class="cart-item-price">
                    £ <?php echo number_format($cartItem['item_quantity'] * $cartItem['item_cost'] / 100, 2) ?>
                </div>
            </div>
            <?php endforeach; ?>
            <div class="cart-total">Total: £ <?php echo number_format($cartTotal / 100, 2) ?></div>
        </div>
    </body>
</html>
