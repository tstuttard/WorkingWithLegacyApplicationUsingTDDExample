<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(\Codeception\Scenario $scenario)
    {
        parent::__construct($scenario);
        $dsn = 'mysql:host=0.0.0.0:8989;dbname=test;charset=utf8;port=8989';
        $this->pdo = new PDO($dsn, 'dev', 'dev');

    }

    public function refreshDatabase()
    {


        $delete = $this->pdo->exec('DELETE FROM `customers`; DELETE FROM `carts`; DELETE FROM `cart_items`;');

        $customerInsert = $this->pdo->prepare('INSERT INTO `customers` (`id`, `name`, `currency`, `country`) VALUES (:id, :customerName, :currencyCode, :countryCode)');
        $customerInsert->bindValue(':id', 1);
        $customerInsert->bindValue(':customerName', 'Tom Stuttard');
        $customerInsert->bindValue(':currencyCode', 'GBP');
        $customerInsert->bindValue(':countryCode', 'GBR');
        $customerInsert->execute();

        $cartInsert = $this->pdo->prepare('INSERT INTO `carts` VALUES (:id, :customerId)');
        $cartInsert->bindValue(':id', 1);
        $cartInsert->bindValue(':customerId', 1);
        $cartInsert->execute();

        $cartItems = [
            [
                'id' => 1,
                'cartId' => 1,
                'name' => 'Sausages',
                'cost' => 499,
                'quantity' => 2,
                'isVatable' => 0,
            ],
            [
                'id' => 2,
                'cartId' => 1,
                'name' => 'Eggs',
                'cost' => 233,
                'quantity' => 6,
                'isVatable' => 0,
            ],
            [
                'id' => 3,
                'cartId' => 1,
                'name' => 'Chips',
                'cost' => 199,
                'quantity' => 2,
                'isVatable' => 0,
            ],
        ];
        foreach ($cartItems as $cartItem) {
            $cartItemsInsert = $this->pdo->prepare('INSERT INTO `cart_items` VALUES (:id, :cartId, :name, :cost, :quantity, :isVatable)');
            $cartItemsInsert->bindValue(':id', $cartItem['id']);
            $cartItemsInsert->bindValue(':cartId', $cartItem['cartId']);
            $cartItemsInsert->bindValue(':name', $cartItem['name']);
            $cartItemsInsert->bindValue(':cost', $cartItem['cost']);
            $cartItemsInsert->bindValue(':quantity', $cartItem['quantity']);
            $cartItemsInsert->bindValue(':isVatable', $cartItem['isVatable']);
            $cartItemsInsert->execute();
        }

        $query = $this->pdo->query('select id, cart_id, item_name, item_quantity, isVatable from cart_items');
    }

   /**
    * Define custom actions here
    */
    public function changeCustomerCurrency($customerId, $currencyCode)
    {
        $customerQuery = $this->pdo->prepare('UPDATE customers set currency = :currencyCode where id = :id');
        $customerQuery->bindParam(':currencyCode', $currencyCode);
        $customerQuery->bindParam(':id', $customerId);

        $customerQuery->execute();

    }

    public function addItemToCart($cartItem)
    {
        $cartItemsInsert = $this->pdo->prepare('INSERT INTO `cart_items` VALUES (:id, :cartId, :name, :cost, :quantity, :isVatable)');
        $cartItemsInsert->bindValue(':id', $cartItem['id']);
        $cartItemsInsert->bindValue(':cartId', $cartItem['cartId']);
        $cartItemsInsert->bindValue(':name', $cartItem['name']);
        $cartItemsInsert->bindValue(':cost', $cartItem['cost']);
        $cartItemsInsert->bindValue(':quantity', $cartItem['quantity']);
        $cartItemsInsert->bindValue(':isVatable', $cartItem['isVatable']);
        $cartItemsInsert->execute();
    }
}
