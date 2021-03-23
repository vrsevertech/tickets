<?= "Телефон: " . $phone['phone'] . "<br>"; ?>
<?= $phone['clientName']; ?>
<?= $phone['note']; ?>

<?php 
echo '<div style="margin: 0px 0px 0px 30px">';
if (isset($phone["events"][0])){
	echo "Заказы: ";
	echo '<div style="margin: 0px 0px 0px 35px">';

foreach ($phone["events"][0] as $key => $event) {
	# code...
	include 'event.php';
	
} echo '</div>';}
if (isset($phone["events"][1])){
	echo "Освободились: ";
	echo '<div style="margin: 0px 0px 0px 35px">';

foreach ($phone["events"][1] as $key => $event) {
	# code...
	include 'event.php';
} echo '</div>';}
if (isset($phone["events"][2])){
	echo "В очереди: ";
	echo '<div style="margin: 0px 0px 0px 35px">';

foreach ($phone["events"][2] as $key => $event) {
	# code...
	include 'event.php';
} echo '</div>';}
echo '</div>';