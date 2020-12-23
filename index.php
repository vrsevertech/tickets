<?php
session_start();
if(isset($_SESSION['ok'])) {
    echo "Спасибо, " . $_SESSION['ok']['name'] . 
        "<br>перезвоним: " . $_SESSION['ok']['phone'] . 
        "<br>номер заказа: " . $_SESSION['ok']['orderId'] . 
        "<br>зарезервировано: " . $_SESSION['ok']['order'] . 
        "<br>событие: " . $_SESSION['ok']['eventId'] .
        "<br>";
    unset($_SESSION['ok']);
} 

echo "1";

require 'db_connection.php';
$pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8", 
    $login, $password, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, 
]);

$events = $pdo->prepare("SELECT * FROM events");
$events->execute();
$events = $events->fetchAll();

foreach ($events as $event) {
	echo '<a href="./';
	echo $event['eventId'];
	echo '">';
	echo $event['eventName'] . ' ' . $event['eventDate'];
	echo '</a>';
	echo '<br>';
}
?>
<br><br><br><br><br><br><br>
<?php //phpinfo(); ?>