<?php


use App\Acme\CartItem;
use App\Acme\Customer;
use App\Acme\PdoCartRepository;

class PdoCartRepositoryTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var PDO
     */
    private $pdo;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $dsn = 'mysql:host=0.0.0.0:8989;dbname=test;charset=utf8;port=8989';
        $this->pdo = new PDO($dsn, 'dev', 'dev');
        $this->pdo->exec(file_get_contents(__DIR__ . '/../../../../data/db/dumps/db.sql'));
    }

    protected function _before()
    {
        $this->pdo->beginTransaction();
    }

    protected function _after()
    {
        $this->pdo->rollBack();
    }

    public function testFindByCustomerIdReturnsCartWithCartItems()
    {
        $cartRepository = new PdoCartRepository($this->pdo);

        $customerId = 1;

        $expectedCartItems = [
            new CartItem(1, 'Sausages', 499, 2, false),
            new CartItem(2, 'Eggs', 233, 6, false),
            new CartItem(3, 'Chips', 199, 2, false),
        ];

        $cart = $cartRepository->findByCustomer(new Customer(1, 'Tom Stuttard', 'GBR', 'GBP'));

        $this->assertEquals($customerId, $cart->getCustomerId());
        $this->assertEquals($expectedCartItems, $cart->getCartItems());
        $this->assertEquals(0, $cart->getTotalTax());
        $this->assertEquals(2794, $cart->getTotalCostWithoutTax());
        $this->assertEquals(2794, $cart->getTotalCostWithTax());
    }

    public function testFindByCustomerIdReturnsCartWithTaxableCartItems()
    {
        $cartRepository = new PdoCartRepository($this->pdo);
        $cartItem = new CartItem(4, 'Shoes', 1999, 1, true);
        $cartRepository->addCartItem(1, $cartItem);

        $customerId = 1;

        $expectedCartItems = [
            new CartItem(1, 'Sausages', 499, 2, false),
            new CartItem(2, 'Eggs', 233, 6, false),
            new CartItem(3, 'Chips', 199, 2, false),
            $cartItem,
        ];

        $cart = $cartRepository->findByCustomer(new Customer(1, 'Tom Stuttard', 'GBR', 'GBP'));

        $this->assertEquals($customerId, $cart->getCustomerId());
        $this->assertEquals($expectedCartItems, $cart->getCartItems());
        $this->assertEquals(400, $cart->getTotalTax());
        $this->assertEquals(4793, $cart->getTotalCostWithoutTax());
        $this->assertEquals(5193, $cart->getTotalCostWithTax());
    }
}