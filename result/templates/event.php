<?php
echo "Событие: " . $event['eventName'];
//echo " (" . $key . ") ";
//echo "Дата: " . $event['eventDate'] . " ";

$event['orderId'] . " ";
$event['name'] . " ";
$event['firstClick'] . " ";
$event['currentNote'] . " ";

echo '<div style="margin: 0px 0px 0px 45px">';

if (isset($event['deal'][0])) {
	echo "Заказ №" . $event['orderId'] . ": ";
	echo implode(', ', $event['deal'][0]);
	echo "<br>";
}
if (isset($event['deal'][1])) {
	echo "Освободились: ";
	echo implode(', ', $event['deal'][1]);
	echo "<br>";
}
if (isset($event['deal'][2])) {
	if (!$eventQueue) echo "В очереди: ";
	echo implode(', ', $event['deal'][2]);
}

echo "</div>";

