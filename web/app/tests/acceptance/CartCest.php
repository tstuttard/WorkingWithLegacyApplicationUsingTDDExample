<?php

class CartCest
{
    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Legacy Online Shop');
    }
}