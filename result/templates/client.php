<?= "Контакт: " . $phone['phone'] . "<br>"; ?>
<?= $phone['clientName']; ?>
<?= $phone['note']; ?>

<?php 

echo '<div style="margin: 0px 0px 0px 30px">';

if (isset($phone["events"][0])) {
	echo "Заказы: ";
	echo '<div style="margin: 0px 0px 0px 35px">';

	$eventOrder = true;
	foreach ($phone["events"][0] as $key => $event) {
		include 'event.php';
	} 
	$eventOrder = false;

	echo '</div>';
}

if (isset($phone["events"][1])) {
	if ($clientOrder) echo "Освободились: ";
	if ($clientOrder) echo '<div style="margin: 0px 0px 0px 35px">';

	$eventFree = true;
	foreach ($phone["events"][1] as $key => $event) {
		include 'event.php';
	} 
	$eventFree = false;

	if ($clientOrder) echo '</div>';
}

if (isset($phone["events"][2])) {
	if (!$clientQueue) echo "В очереди: ";
	if (!$clientQueue) echo '<div style="margin: 0px 0px 0px 35px">';

	$eventQueue = true;
	foreach ($phone["events"][2] as $key => $event) {
		include 'event.php';
	} 
	$eventQueue = false;

	if (!$clientQueue) echo '</div>';
}

echo '</div>';