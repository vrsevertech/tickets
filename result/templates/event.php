<?= "Событие: " . $key . " (" . $event['eventName'] . ") "; ?>
<?= "Дата: " . $event['eventDate'] . " "; ?>

<?php

$event['orderId'] . " ";
$event['name'] . " ";
$event['firstClick'] . " ";
$event['currentNote'] . " ";

echo '<div style="margin: 0px 0px 0px 45px">';
if (isset($event['deal'][0])){
echo "Заказы: ";
foreach ($event['deal'][0] as $key => $value) {
	# code...
echo $value . " ";

}echo "<br>";
}
if (isset($event['deal'][1])){
echo "Освободились: ";
foreach ($event['deal'][1] as $key => $value) {
	# code...
echo $value . " ";
}echo "<br>";}
if (isset($event['deal'][2])){echo "В очереди: ";
foreach ($event['deal'][2] as $key => $value) {
	# code...
echo $value . " ";
}}
echo "</div>";

