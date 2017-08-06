<?php


use App\Acme\CartItem;
use App\Acme\TaxCalculator;

class TaxCalculatorTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }


    public function testGBRTotalTax()
    {
        $cartItems = [
            new CartItem(1, 't-shirt', 1000, 1, true),
            new CartItem(2, 'gravy sauce', 100, 5, false),
            new CartItem(3, 'socks', 300, 4, true),
        ];
        $taxCalculator = new TaxCalculator('GBR', $cartItems);
        $this->assertEquals(440, $taxCalculator->getTotalTax());
    }
}