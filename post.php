<?php
$eventId = $_POST['eventId'];
require 'db.php';

$place = $_POST['place'];
$phone = $_POST['phone'];
$needIt = ($_POST['what'] == 'need') ? true : false;
$dropIt = ($_POST['what'] == 'drop') ? true : false;

$selections = new selections($eventId,$place);
try {
    $selections->pdo->beginTransaction();
    $changes = $selections->collectChangedStatuses($_POST['preAvailables']);
    $itSchanged = in_array($place, array_column($changes,'place'));
    if (!$itSchanged) {
        $itStaken = $selections->checkIt();
        if (!$itStaken AND $needIt) { $fail = $selections->setClickTime(); } else 
        if (!$itStaken AND $dropIt) { $fail = $selections->unSetClickTime(); } else 
        if ($itStaken AND $needIt AND isset($phone)) { $fail = $selections->addToQueue($phone); } else 
        if ($_POST['what'] == 'check') {} else exit('что делать');
    }
    $selections->pdo->commit();
} catch (Exception $e) {
    $selections->pdo->rollBack();
    exit($e);
}

echo json_encode([
    //'eventId' => $eventId,
    'place' => $place,
    'changes' => $changes,
    'itSchanged' => $itSchanged,
    //'itStaken' => $itStaken,
    //'fail' => $fail, //deb
    //'sessId' => $selections->sessId, //deb
    //'SESS_order' => $_SESSION['ev'.$eventId]['order'], //deb
    //'POST_tabId' => $_POST['tabId'], //deb
    //'SESS_tabId' => $_SESSION['ev'.explode('/',$_SERVER["HTTP_REFERER"])[4]]['tabId'], //deb
    //'SERVER_HTTP_REFERER' => explode('/',$_SERVER["HTTP_REFERER"])[4], //deb
    //'SESSION' => $_SESSION, //deb
    //'SERVER_REQUEST_URI' => $_SERVER['REQUEST_URI'], //deb
]);