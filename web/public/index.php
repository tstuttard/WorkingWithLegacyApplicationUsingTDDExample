<?php

use App\Acme\TaxCalculator;

include __DIR__ . '/../app/vendor/autoload.php';
$foo = new App\Acme\Foo();

try {
    $dsn = 'mysql:host=mysql;dbname=test;charset=utf8;port=3306';
    $pdo = new PDO($dsn, 'dev', 'dev');
    $customerId = 1;
    $cartRepository = new \App\Acme\PdoCartRepository($pdo);

    $customerQuery = $pdo->prepare('select * from customers where id = :id');
    $customerQuery->bindParam(':id', $customerId);
    if ($customerQuery->execute()) {
        $customer = $customerQuery->fetch();
    }

    $cart = $cartRepository->findByCustomerId($customerId);
    $taxCalculator = new TaxCalculator($customer['country'], $cart->getCartItems());
    switch ($customer['currency']) {
        case 'GBP':
            $currencySymbol = '£';
            break;
        case 'EUR':
            $currencySymbol = '€';
            break;
        default:
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
    <style>
        body {
            font-size: 28px;
        }

        .cart {
            width: 500px;
            border: black 1px solid;
            padding: 5px;
        }

        .cart-item {
            /*margin-bottom: 10px;*/
        }

        .cart-item-list {
            display: inline;
        }

        .cart-item-price {
            display: inline;
            float: right;
        }

        .discount-value {
            float: right;
        }

        .tax-value {
            float: right;
        }

        .cart-total-value {
            float: right;
        }
    </style>
</head>
<body>
<h1>Legacy Online Shop</h1>

<div class="cart">
    <?php foreach ($cart->getCartItems() as $cartItem):
        $cartTotal += $cartItem->getCost() * $cartItem->getQuantity();
        if ($cartItem->isVatable()) {
            $totalVatable += $cartItem->getCost() * $cartItem->getQuantity();
        }
        ?>
        <div class="cart-item" id="cart-item-<?php echo $cartItem->getId() ?>">
            <div class="cart-item-list">
                <?php echo $cartItem->getItemName() ?> x <?php echo $cartItem->getQuantity() ?>
            </div>
            <div class="cart-item-price">
                <?php echo $currencySymbol ?><?php echo number_format($cartItem->getQuantity() * $cartItem->getCost() / 100, 2) ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if ($cart->getTotalCost() > 10000):
        $cartDiscount = $cart->getTotalCost() * 0.2;
    ?>
    <div class="discount">
        <span class="discount-text">Discount: 20% off £100 spend</span>
        <span class="discount-value">- <?php echo $currencySymbol ?><?php echo number_format($cartDiscount / 100, 2) ?></span></div>
    <?php endif; ?>
    <div class="tax-total">Tax: <span class="tax-value">
        <?php echo $currencySymbol ?><?php
        echo number_format($taxCalculator->getTotalTax() / 100, 2)
        ?>
        </span>
    </div>
    <div class="cart-total">Total: <span class="cart-total-value"><?php echo $currencySymbol ?><?php echo number_format(($cart->getTotalCost() - $cartDiscount + $taxCalculator->getTotalTax()) / 100, 2) ?></span></div>
</div>
</body>
</html>
