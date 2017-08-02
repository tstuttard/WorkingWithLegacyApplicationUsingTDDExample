<?php

include '../app/vendor/autoload.php';
$foo = new App\Acme\Foo();

try {
    $dsn = 'mysql:host=mysql;dbname=test;charset=utf8;port=3306';
    $pdo = new PDO($dsn, 'dev', 'dev');
    $test = $pdo->query('select * from cart');
    var_dump($test->fetchAll());

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
        <h1>Docker <?php echo $foo->getName(); ?></h1>
    </body>
</html>
