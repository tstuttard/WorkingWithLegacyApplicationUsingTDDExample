<?php

class CartCest
{
    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Legacy Online Shop');

        $I->see('Sausages x 2', '#cart-item-1 .cart-item-list');
        $I->see('£ 9.98', '#cart-item-1 .cart-item-price');
        $I->see('Eggs x 6', '#cart-item-2 .cart-item-list');
        $I->see('£ 13.98', '#cart-item-2 .cart-item-price');
        $I->see('Chips x 2', '#cart-item-3 .cart-item-list');
        $I->see('£ 3.98', '#cart-item-3 .cart-item-price');
        $I->see('Total: £ 27.94');
    }
}