<?php


use App\Acme\CartItem;
use App\Acme\Customer;
use App\Acme\PdoCartRepository;
use App\Acme\PdoCustomerRepository;

class PdoCustomerRepositoryTest extends \Codeception\Test\Unit
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

    public function testFindById()
    {
        $customerRepository = new PdoCustomerRepository($this->pdo);

        $customerId = 1;

        $customer = $customerRepository->findByid(1);

        $this->assertEquals($customerId, $customer->getId());
        $this->assertEquals('Tom Stuttard', $customer->getName());
        $this->assertEquals('GBR', $customer->getCountryCode());
        $this->assertEquals('GBP', $customer->getCurrencyCode());
    }
}