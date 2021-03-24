<?php
require 'db_connection.php';
$pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8", 
    $login, $password, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, 
]);

$pdo->query("UPDATE `tickets` SET `orderId`=NULL,`clickTime`=NULL,`sessId`=NULL")->execute();
$pdo->query("DELETE FROM `queue`")->execute();
$pdo->query("DELETE FROM `orders`")->execute();

echo "Готово";