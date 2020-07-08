<?php
session_start();
if (count($_POST)) 
  if ($_SESSION['ev'.$_POST['eventId']]['tabId'] != $_POST['tabId']) exit('несколько вкладок');

/**
 * База.
 */
class db
{
    
    function __construct()
    {
        require 'db_connection.php';
        $this->pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8", 
            $login, $password, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false, 
        ]);
        $this->sessId = session_id();
    }

    function __get($w) { switch ($w) { case 'whatIsTaken': return "
        orderId IS NOT NULL 
        OR 
        (
            (
                sessId IS NULL 
                OR sessId != '$this->sessId'
            )
            AND
            (
                (

                    clickTime IS NOT NULL 
                    AND UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(clickTime)<1200
                ) 
                OR 
                (
                    SELECT COUNT(*) 
                    FROM queue 
                    WHERE queue.place = tickets.place 
                    AND queue.eventId = tickets.eventId
                ) > 0
            )
        )
    ";}}
}

/**
 * Отображение.
 */
class display extends db
{
    
    function __construct($eventId)
    {
        parent::__construct();
        $tickets = $this->pdo->prepare("
            SELECT place,price,karabas,($this->whatIsTaken) as taken FROM tickets WHERE eventId=?");
        $tickets->execute([$eventId]);
        if (!$tickets->rowCount()) exit('Событие прошло или не запланировано');
        $this->tickets = $tickets->fetchAll();

        $distinctPrices = $this->pdo->prepare('
            SELECT DISTINCT price FROM tickets WHERE eventId=? AND price IS NOT NULL ORDER BY price DESC');
        $distinctPrices->execute([$eventId]);
        $step = floor(count($this->colors)/$distinctPrices->rowCount());
        if (!$step) exit("Ценновых категорий больше, чем " . count($this->colors));

        $keyColor = 0;
        foreach ($distinctPrices->fetchAll() as $distinctPrice) {
            $background = $this->colors[$keyColor];
            $color = $this->color_inverse($this->colors[$keyColor]);
            $this->distinctPricesHTML .= '<span 
                style="background: ' . $background . ';color: ' . $color . '">' . $distinctPrice['price'] . '</span>';
            foreach ($this->tickets as &$ticket) {
                if ($ticket['price'] != $distinctPrice['price']) continue;
                $ticket['color']['background'] = $background;
                $ticket['color']['color'] = $color;
            }
            //print_r($prices);
            $keyColor += $step;
        }
    }

    function tickets()
    {
        
    }

    function distinctPrices() 
    {

    }

    public $colors = [
        "#FF0000",
        "#DC143C",
        "#800000",
        "#A52A2A",
        "#D2691E",
        "#8B4513",
        "#F08080",
        "#FFA07A",
        "#DEB887",
        "#BC8F8F",
        "#F4A460",
        "#DAA520",
        "#B8860B",
        "#CD853F",
        "#FF4500",
        "#FF7F50",
        "#FF6347",
        "#FF8C00",
        "#00FF00",
        "#32CD32",
        "#98FB98",
        "#00FA9A",
        "#3CB371",
        "#2E8B57",
        "#008000",
        "#006400",
        "#9ACD32",
        "#6B8E23",
        "#808000",
        "#66CDAA",
        "#8FBC8F",
        "#20B2AA",
        "#008080",
        "#D8BFD8",
        "#DA70D6",
        "#FF00FF",
        "#9370DB",
        "#8A2BE2",
        "#9932CC",
        "#8B008B",
        "#4B0082",
        "#6A5ACD",
        "#483D8B",
        "#00FFFF",
        "#00CED1",
        "#5F9EA0",
        "#4682B4",
        "#7B68EE",
        "#0000FF",
        "#000080"
    ];

    function color_inverse($color)
    {
        $color = str_replace('#', '', $color);
        if (strlen($color) != 6){ return '000000'; }
        $rgb = '';
        for ($x=0;$x<3;$x++){
            $c = 255 - hexdec(substr($color,(2*$x),2));
            $c = ($c < 0) ? 0 : dechex($c);
            $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
        }
        return '#'.$rgb;
    }
}

/**
 * Выборы.
 */
class selections extends db
{

    function __construct($eventId,$place)
    {
        parent::__construct();
        $this->eventId = $eventId;
        $this->place = $place;
    }

    function collectChangedStatuses($preAvailables)
    {
        $pre = explode(',', $preAvailables);
        $in = str_repeat('?,', count($pre) - 1) . '?';
        $q = "SELECT place,($this->whatIsTaken) as taken FROM tickets WHERE eventId=? AND karabas IS NULL 
                AND ((place IN ($in) AND ($this->whatIsTaken)) OR (place NOT IN ($in) AND NOT ($this->whatIsTaken)))";
        $p = $this->pdo->prepare($q);
        $p->execute(array_merge([$this->eventId],$pre,$pre));
        return $p->fetchAll();
    }

    function checkIt()
    {
        if (!isset($this->taken)) {
            $q = "SELECT ($this->whatIsTaken) as taken FROM tickets WHERE eventId=? AND place=?";
            $p = $this->pdo->prepare($q);
            $p->execute([$this->eventId,$this->place]);
            $this->taken = $p->fetch()['taken'];
        }
        return ($this->taken);
    }

    function setClickTime()
    {
        if (!$this->taken) {
            $q = 'UPDATE tickets SET clickTime=NOW(),sessId=? WHERE eventId=? AND place=?';
            $p = $this->pdo->prepare($q);
            $p->execute([session_id(),$this->eventId,$this->place]);
            $k = array_search($this->place, $_SESSION['ev'.$this->eventId]['order']);
            if ($k === false) $_SESSION['ev'.$this->eventId]['order'][] = $this->place;
        } else return 'занято другим';
    }

    function unSetClickTime()
    {
        if (!$this->taken) {
            $q = 'UPDATE tickets SET clickTime=NULL,sessId=NULL WHERE eventId=? AND place=?';
            $p = $this->pdo->prepare($q);
            $p->execute([$this->eventId,$this->place]);
            $k = array_search($this->place, $_SESSION['ev'.$this->eventId]['order']);
            ($k !== false) ? array_splice($_SESSION['ev'.$this->eventId]['order'],$k,1) : exit('???');
        } else return 'занято другим';
    }

    function orderReset()
    {

    }

    function alreadyInQueueCheck($phone)
    {
        $q = 'SELECT COUNT(*) FROM queue WHERE eventId=? AND place=? AND phone=?';
        $p = $this->pdo->prepare($q);
        $p->execute([$this->eventId,$this->place,$phone]);
        return ($p->fetch()['COUNT(*)'] === 0);
    }

    function addToQueue($phone)
    {
        if ($this->alreadyInQueueCheck($phone)) {
            $q = 'INSERT queue SET eventId=?, place=?, phone=?';
            $p = $this->pdo->prepare($q);
            $p->execute([$this->eventId,$this->place,$phone]);
        } else return 'добавленно раннее';
    }
}

/**
 * Заказ.
 */
class orderProcessing extends db
{

    function ticketAvailabilityCheck($eventId, array $order)
    {
        $in = str_repeat('?,', count($order) - 1) . '?';
        $q = "SELECT COUNT(*) FROM tickets WHERE eventId=? AND place IN ($in) AND ($this->whatIsTaken)";
        $p = $this->pdo->prepare($q);
        $p->execute(array_merge([$eventId],$order));
        return ($p->fetch()['COUNT(*)'] === 0);
    }

    function getExistOrder($eventId, $phone)
    {
        $q = "SELECT orderId FROM orders WHERE eventId=? AND phone=? AND (status IS NULL OR status LIKE 'comfirmed%')";
        $p = $this->pdo->prepare($q);
        $p->execute([$eventId,$phone]);
        return $p->fetch()['orderId'];
    }

    function createOrder($eventId, $phone, $name)
    {
        $q = 'INSERT INTO orders SET eventId=?, phone=?, name=?';
        $p = $this->pdo->prepare($q);
        $p->execute([$eventId,$phone,$name]);
        return $this->pdo->lastInsertId();
    }

    function go($eventId, $phone, $name, $order)
    {
        $order = explode(',', $order);
        if (!count($order)) exit('пустой заказ');
        $in = str_repeat('?,', count($order) - 1) . '?';
        try {
            $this->pdo->beginTransaction();
            if ($this->ticketAvailabilityCheck($eventId,$order)) {
                $orderId = $this->getExistOrder($eventId,$phone);
                if (!$orderId) $orderId = $this->createOrder($eventId,$phone,$name);
                $a = array_merge([$orderId,$eventId],$order);
                $this->pdo->prepare("UPDATE tickets SET orderId=? WHERE eventId=? AND place IN ($in)")->execute($a);
                $this->pdo->commit();
                //echo 'ok';
            } else {
                throw new Exception('не'); //системная ошибка, либо запрос в обход фронтенда
            }
        } catch (Exception $e) {
            $this->pdo->rollBack();
            exit($e);
        }

        return [
            'eventId' => $eventId, 
            'phone' => $phone, 
            'name' => $name, 
            'orderId' => $orderId, 
            'order' => implode(',', $order),
        ]; 
    }
}