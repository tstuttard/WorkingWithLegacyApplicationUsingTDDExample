<?php

include __DIR__ . '/../app/vendor/autoload.php';
$foo = new App\Acme\Foo();

try {
    $dsn = 'mysql:host=mysql;dbname=test;charset=utf8;port=3306';
    $pdo = new PDO($dsn, 'dev', 'dev');
    $customerId = 1;
    $customerQuery = $pdo->prepare('select * from customers where id = :id');
    $customerQuery->bindParam(':id', $customerId);
    if ($customerQuery->execute()) {
        $customer = $customerQuery->fetch();
    }

    $cartQuery = $pdo->prepare('select *, cart_items.id as cart_item_id
from carts
left join cart_items on carts.id = cart_items.cart_id
where customer_id = :customer_id');
    $cartQuery->bindParam(':customer_id', $customerId);

    if ($cartQuery->execute()) {
        $cart = $cartQuery->fetchAll();
    }
    $cartTotal = 0;
    $totalVatable = 0;
    switch ($customer['currency']) {
        case 'GBP':
            $tax = 0.2;
            $currencySymbol = '£';
            break;
        case 'EUR':
            $tax = 0.2;
            $currencySymbol = '€';
            break;
        default:
            $tax = 0.4;
            $currencySymbol = '$';
            break;
    }

} catch (PDOException $e) {
    echo $e->getMessage();
}

?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Docker <?php echo $foo->getName(); ?></title>
</head>
<body>
<h1>Legacy Online Shop</h1>

<div class="cart">
    <?php foreach ($cart as $cartItem):
        $cartTotal += $cartItem['item_cost'] * $cartItem['item_quantity'];
        if ($cartItem['isVatable']) {
            $totalVatable += $cartItem['item_cost'] * $cartItem['item_quantity'];
        }
        ?>
        <div class="cart-item" id="cart-item-<?php echo $cartItem['cart_item_id'] ?>">
            <div class="cart-item-list">
                <?php echo $cartItem['item_name'] ?> x <?php echo $cartItem['item_quantity'] ?>
            </div>
            <div class="cart-item-price">
                <?php echo $currencySymbol ?><?php echo number_format(
                    $cartItem['item_quantity'] * $cartItem['item_cost'] / 100,
                    2) ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if ($cartTotal > 10000):
        $cartDiscount = $cartTotal * 0.2;
        $cartTotal -= $cartDiscount;
    ?>
    <div class="discount">
        <span class="discount-text">Discount: 20% off £100 spend</span>
        <span class="discount-value">- <?php echo $currencySymbol ?>
            <?php echo number_format($cartDiscount / 100, 2) ?></span></div>
    <?php endif; ?>
    <div class="tax-total">Tax: <span class="tax-value">
        <?php echo $currencySymbol ?><?php
        $totalTax = $totalVatable * $tax;
        echo number_format($totalTax / 100, 2)
        ?>
        </span>
    </div>
    <div class="cart-total">Total: <span class="cart-total-value">
            <?php echo $currencySymbol ?><?php echo number_format(($cartTotal + $totalTax) / 100, 2) ?>
        </span>
    </div>
</div>
</body>
</html>
