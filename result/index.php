<?php 
require '../db_connection.php';
require 'sql.php';

$pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8", 
    $login, $password, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, 
]);

$milliseconds = round(microtime(true) * 1000);

$all = $pdo->prepare($sql); $all->execute(); $all = $all->fetchAll();

//echo "запрос: "; echo round(microtime(true) * 1000) - $milliseconds;
$milliseconds = round(microtime(true) * 1000);

$arr;
foreach ($all as $key => $v) {
$arr[$v['priority']][$v['phone']]["clientName"] = $v['clientName'];
$arr[$v['priority']][$v['phone']]["phone"] = $v['phone'];
$arr[$v['priority']][$v['phone']]["note"] = $v['note'];
$arr[$v['priority']][$v['phone']]["events"][$v['dealPriority']][$v['eventId']]["eventName"] = $v['eventName'];
$arr[$v['priority']][$v['phone']]["events"][$v['dealPriority']][$v['eventId']]["eventDate"] = $v['eventDate'];
$arr[$v['priority']][$v['phone']]["events"][$v['dealPriority']][$v['eventId']]["orderId"] = $v['orderId'];
$arr[$v['priority']][$v['phone']]["events"][$v['dealPriority']][$v['eventId']]["name"] = $v['name'];
$arr[$v['priority']][$v['phone']]["events"][$v['dealPriority']][$v['eventId']]["firstClick"] = $v['firstClick'];
$arr[$v['priority']][$v['phone']]["events"][$v['dealPriority']][$v['eventId']]["currentNote"] = $v['currentNote'];
$arr[$v['priority']][$v['phone']]["events"][$v['dealPriority']][$v['eventId']]["deal"][$v['position']][] = $v['place'];
}

//echo " в джосн: "; echo round(microtime(true) * 1000) - $milliseconds;
$milliseconds = round(microtime(true) * 1000);

$orderSection = true;
echo "<h1> Заказы: </h1> ";
echo '<div style="margin: 0px 0px 0px 20px">';
foreach ($arr[0] as $phone) {
	include 'templates/client.php';
}
echo '</div>';
$orderSection = false;

echo "<h2> Освободились: </h2> ";
echo '<div style="margin: 0px 0px 0px 20px">';
foreach ($arr[1] as $phone) {
	include 'templates/client.php';
}
echo '</div>';

$queueSection = true;
echo "<h3> В очереди: </h3> ";
echo '<div style="margin: 0px 0px 0px 20px">';
foreach ($arr[2] as $phone) {
	include 'templates/client.php';
}
echo '</div>';

//echo " рендер: "; echo round(microtime(true) * 1000) - $milliseconds;