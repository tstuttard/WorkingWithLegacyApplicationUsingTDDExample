<?php

class CartCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->refreshDatabase();

    }

    public function cartInGBP(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Legacy Online Shop');

        $I->see('Sausages x 2', '#cart-item-1 .cart-item-list');
        $I->see('£ 9.98', '#cart-item-1 .cart-item-price');
        $I->see('Eggs x 6', '#cart-item-2 .cart-item-list');
        $I->see('£ 13.98', '#cart-item-2 .cart-item-price');
        $I->see('Chips x 2', '#cart-item-3 .cart-item-list');
        $I->see('£ 3.98', '#cart-item-3 .cart-item-price');
        $I->see('Tax: £ 0.00');
        $I->see('Total: £ 27.94');
    }

    public function cartInEUR(AcceptanceTester $I)
    {
        $I->changeCustomerCurrency(1, 'EUR');


        $I->amOnPage('/');
        $I->see('Legacy Online Shop');

        $I->see('Sausages x 2', '#cart-item-1 .cart-item-list');
        $I->see('€ 9.98', '#cart-item-1 .cart-item-price');
        $I->see('Eggs x 6', '#cart-item-2 .cart-item-list');
        $I->see('€ 13.98', '#cart-item-2 .cart-item-price');
        $I->see('Chips x 2', '#cart-item-3 .cart-item-list');
        $I->see('€ 3.98', '#cart-item-3 .cart-item-price');
        $I->see('Tax: € 0.00');
        $I->see('Total: € 27.94');
    }

    public function cartWithVatableItems(AcceptanceTester $I)
    {
        $cartItem = [
            'id' => 4,
            'cartId' => 1,
            'name' => 'Shoes',
            'cost' => 1999,
            'quantity' => 1,
            'isVatable' => true,
        ];

        $I->addItemToCart($cartItem);

        $I->amOnPage('/');
        $I->see('Legacy Online Shop');

        $I->see('Sausages x 2', '#cart-item-1 .cart-item-list');
        $I->see('£ 9.98', '#cart-item-1 .cart-item-price');
        $I->see('Eggs x 6', '#cart-item-2 .cart-item-list');
        $I->see('£ 13.98', '#cart-item-2 .cart-item-price');
        $I->see('Chips x 2', '#cart-item-3 .cart-item-list');
        $I->see('£ 3.98', '#cart-item-3 .cart-item-price');
        $I->see('Shoes x 1', '#cart-item-4 .cart-item-list');
        $I->see('£ 19.99', '#cart-item-4 .cart-item-price');
        $I->see('Tax: £ 4.00');
        $I->see('Total: £ 51.93');


    }
}