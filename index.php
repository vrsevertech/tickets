<?php
session_start();
if(isset($_SESSION['ok'])) {
    echo "Спасибо, " . $_SESSION['ok']['name'] . 
        "<br>перезвоним: " . $_SESSION['ok']['phone'] . 
        "<br>номер заказа: " . $_SESSION['ok']['orderId'] . 
        "<br>зарезервировано: " . $_SESSION['ok']['order'] . 
        "<br>";
    unset($_SESSION['ok']);
} 
?>
<a href="./1">тестовое событие</a>
<br><br><br><br><br><br><br>
<?php //phpinfo(); ?>