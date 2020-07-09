<?php
$eventId = $_GET['id'];
require 'db.php';

if(isset($_POST['do'])) {
    $_SESSION['ok'] = (new orderProcessing())->go($eventId,$_POST['phone'],$_POST['name'],$_POST['order']);
    header ('location: index.php');
}

//сброс выбора при обновлении страницы
if (isset($_SESSION['ev'.$eventId]['order']))
    foreach ($_SESSION['ev'.$eventId]['order'] as $value) $new = (new selections($eventId,$value))->unSetClickTime();
$_SESSION['ev'.$eventId]['order'] = [];
//работа только с последней открытой вкладкой
if (!isset($_SESSION['ev'.$eventId]['tabId'])) $_SESSION['ev'.$eventId]['tabId'] = 0;
$_SESSION['ev'.$eventId]['tabId']++;

$display = new display($eventId);
?>

<html>

<head>
<meta charset="utf8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style>
    .message-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.3);
        z-index: 10;
    }
    .message {
        background-color: #ffffff;
    }


    .empty {
        background: #fff;
        border: 0px;
        color: #000;
        cursor: context-menu;
        width: 15px;
        font-size: 20px;
    }

    td {
        width: 33px;
        height: 30px;
        font-size: 22px;
        text-align: center;
        color: #fff;
        background: grey;
        user-select: none;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .taken::before {
        content:'';
        position:absolute;
        display:block;
        width:auto;
        height:auto;
        left:0;
        top:0;
        right:0;
        bottom:0;
        background: rgba(0,0,0,0) url(x.svg) no-repeat;
        background-size:100% 100%;
    }

    .noselected:hover {
    }
    
    .selected,.prolselected {
        width: 5px;
        cursor: pointer;
        outline: 3px solid black;
        z-index: 5;
    }

    .preselected {
        width: 5px;
        cursor: pointer;
        outline: 1px solid black;
        z-index: 5;
    }

    span {
        font-size: 35px;
        border: 3px solid #fff;
        float: left;
    }
    
    input {
        width: 200px;
        height: 70px;
        font-size: 45px;
    }
    
    button {
        width: 250px;
        height: 70px;
        font-size: 45px;
    }

    .scene {
        font-size: 35px;
        cursor: context-menu;
    }

    img {
        width: 22px;
        pointer-events: none;
    }
    table {
        float: left;
    }
</style>
</head>

<body>
<pre><p name="//deb" class="d"></p></pre>
<div class="message-wrapper">
    <div class="message">
        <h2>Вы начали работу в другой вкладке. Эту можно закрыть.</h2>
    </div>
</div>
<table>
  <tr>
    <td id="1" class="noselected">1</td>
    <td id="2" class="noselected">2</td>
    <td id="3" class="noselected">3</td>
    <td id="4" class="noselected">4</td>
    <td id="5" class="noselected">5</td>
    <td class="empty">16</td>
    <td id="6" class="noselected">6</td>
    <td id="7" class="noselected">7</td>
    <td id="8" class="noselected">8</td>
    <td id="9" class="noselected">9</td>
    <td id="10" class="noselected">10</td>
    <td id="11" class="noselected">11</td>
    <td id="12" class="noselected">12</td>
    <td id="13" class="noselected">13</td>
    <td id="14" class="noselected">14</td>
    <td id="15" class="noselected">15</td>
    <td id="16" class="noselected">16</td>
    <td id="17" class="noselected">17</td>
    <td id="18" class="noselected">18</td>
    <td id="19" class="noselected">19</td>
    <td id="20" class="noselected">20</td>
    <td id="21" class="noselected">21</td>
    <td class="empty">16</td>
    <td id="22" class="noselected">22</td>
    <td id="23" class="noselected">23</td>
    <td id="24" class="noselected">24</td>
    <td id="25" class="noselected">25</td>

  </tr>
  <tr>
    <td id="26" class="noselected">1</td>
    <td id="27" class="noselected">2</td>
    <td id="28" class="noselected">3</td>
    <td id="29" class="noselected">4</td>
    <td id="30" class="noselected">5</td>
    <td class="empty">15</td>
    <td id="31" class="noselected">6</td>
    <td id="32" class="noselected">7</td>
    <td id="33" class="noselected">8</td>
    <td id="34" class="noselected">9</td>
    <td id="35" class="noselected">10</td>
    <td id="36" class="noselected">11</td>
    <td id="37" class="noselected">12</td>
    <td id="38" class="noselected">13</td>
    <td id="39" class="noselected">14</td>
    <td id="40" class="noselected">15</td>
    <td id="41" class="noselected">16</td>
    <td id="42" class="noselected">17</td>
    <td id="43" class="noselected">18</td>
    <td id="44" class="noselected">19</td>
    <td id="45" class="noselected">20</td>
    <td id="46" class="noselected">21</td>
    <td class="empty">15</td>
    <td id="47" class="noselected">22</td>
    <td id="48" class="noselected">23</td>
    <td id="49" class="noselected">24</td>
    <td id="50" class="noselected">25</td>

  </tr>
  <tr>
    <td id="51" class="noselected">1</td>
    <td id="52" class="noselected">2</td>
    <td id="53" class="noselected">3</td>
    <td id="54" class="noselected">4</td>
    <td id="55" class="noselected">5</td>
    <td class="empty">14</td>
    <td id="56" class="noselected">6</td>
    <td id="57" class="noselected">7</td>
    <td id="58" class="noselected">8</td>
    <td id="59" class="noselected">9</td>
    <td id="60" class="noselected">10</td>
    <td id="61" class="noselected">11</td>
    <td id="62" class="noselected">12</td>
    <td id="63" class="noselected">13</td>
    <td id="64" class="noselected">14</td>
    <td id="65" class="noselected">15</td>
    <td id="66" class="noselected">16</td>
    <td id="67" class="noselected">17</td>
    <td id="68" class="noselected">18</td>
    <td id="69" class="noselected">19</td>
    <td id="70" class="noselected">20</td>
    <td id="71" class="noselected">21</td>
    <td class="empty">14</td>
    <td id="72" class="noselected">22</td>
    <td id="73" class="noselected">23</td>
    <td id="74" class="noselected">24</td>
    <td id="75" class="noselected">25</td>

  </tr>
  <tr>
    <td class="empty"></td>
    <td id="76" class="noselected">1</td>
    <td id="77" class="noselected">2</td>
    <td id="78" class="noselected">3</td>
    <td id="79" class="noselected">4</td>
    <td class="empty">13</td>
    <td id="80" class="noselected">5</td>
    <td id="81" class="noselected">6</td>
    <td id="82" class="noselected">7</td>
    <td id="83" class="noselected">8</td>
    <td id="84" class="noselected">9</td>
    <td id="85" class="noselected">10</td>
    <td id="86" class="noselected">11</td>
    <td id="87" class="noselected">12</td>
    <td id="88" class="noselected">13</td>
    <td id="89" class="noselected">14</td>
    <td id="90" class="noselected">15</td>
    <td id="91" class="noselected">16</td>
    <td id="92" class="noselected">17</td>
    <td id="93" class="noselected">18</td>
    <td id="94" class="noselected">19</td>
    <td id="95" class="noselected">20</td>
    <td class="empty">13</td>
    <td id="96" class="noselected">21</td>
    <td id="97" class="noselected">22</td>
    <td id="98" class="noselected">23</td>
    <td id="99" class="noselected">24</td>

  </tr>
  <tr>
    <td class="empty"></td>
    <td id="100" class="noselected">1</td>
    <td id="101" class="noselected">2</td>
    <td id="102" class="noselected">3</td>
    <td id="103" class="noselected">4</td>
    <td class="empty">12</td>
    <td id="104" class="noselected">5</td>
    <td id="105" class="noselected">6</td>
    <td id="106" class="noselected">7</td>
    <td id="107" class="noselected">8</td>
    <td id="108" class="noselected">9</td>
    <td id="109" class="noselected">10</td>
    <td id="110" class="noselected">11</td>
    <td id="111" class="noselected">12</td>
    <td id="112" class="noselected">13</td>
    <td id="113" class="noselected">14</td>
    <td id="114" class="noselected">15</td>
    <td id="115" class="noselected">16</td>
    <td id="116" class="noselected">17</td>
    <td id="117" class="noselected">18</td>
    <td id="118" class="noselected">19</td>
    <td id="119" class="noselected">20</td>
    <td class="empty">12</td>
    <td id="120" class="noselected">21</td>
    <td id="121" class="noselected">22</td>
    <td id="122" class="noselected">23</td>
    <td id="123" class="noselected">24</td>

  </tr>
  <tr>
    <td class="empty"></td>
    <td id="124" class="noselected">1</td>
    <td id="125" class="noselected">2</td>
    <td id="126" class="noselected">3</td>
    <td id="127" class="noselected">4</td>
    <td class="empty">11</td>
    <td id="128" class="noselected">5</td>
    <td id="129" class="noselected">6</td>
    <td id="130" class="noselected">7</td>
    <td id="131" class="noselected">8</td>
    <td id="132" class="noselected">9</td>
    <td id="133" class="noselected">10</td>
    <td id="134" class="noselected">11</td>
    <td id="135" class="noselected">12</td>
    <td id="136" class="noselected">13</td>
    <td id="137" class="noselected">14</td>
    <td id="138" class="noselected">15</td>
    <td id="139" class="noselected">16</td>
    <td id="140" class="noselected">17</td>
    <td id="141" class="noselected">18</td>
    <td id="142" class="noselected">19</td>
    <td id="143" class="noselected">20</td>
    <td class="empty">11</td>
    <td id="144" class="noselected">21</td>
    <td id="145" class="noselected">22</td>
    <td id="146" class="noselected">23</td>
    <td id="147" class="noselected">24</td>

  </tr>
  <tr>
    <td id="148" class="noselected">1</td>
    <td id="149" class="noselected">2</td>
    <td id="150" class="noselected">3</td>
    <td id="151" class="noselected">4</td>
    <td id="152" class="noselected">5</td>
    <td class="empty">10</td>
    <td id="153" class="noselected">6</td>
    <td id="154" class="noselected">7</td>
    <td id="155" class="noselected">8</td>
    <td id="156" class="noselected">9</td>
    <td id="157" class="noselected">10</td>
    <td id="158" class="noselected">11</td>
    <td id="159" class="noselected">12</td>
    <td id="160" class="noselected">13</td>
    <td id="161" class="noselected">14</td>
    <td id="162" class="noselected">15</td>
    <td id="163" class="noselected">16</td>
    <td id="164" class="noselected">17</td>
    <td id="165" class="noselected">18</td>
    <td id="166" class="noselected">19</td>
    <td id="167" class="noselected">20</td>
    <td id="168" class="noselected">21</td>
    <td class="empty">10</td>
    <td id="169" class="noselected">22</td>
    <td id="170" class="noselected">23</td>
    <td id="171" class="noselected">24</td>
    <td id="172" class="noselected">25</td>

  </tr>
  <tr>
    <td class="empty"></td>
    <td id="173" class="noselected">1</td>
    <td id="174" class="noselected">2</td>
    <td id="175" class="noselected">3</td>
    <td id="176" class="noselected">4</td>
    <td class="empty">9</td>
    <td id="177" class="noselected">5</td>
    <td id="178" class="noselected">6</td>
    <td id="179" class="noselected">7</td>
    <td id="180" class="noselected">8</td>
    <td id="181" class="noselected">9</td>
    <td id="182" class="noselected">10</td>
    <td id="183" class="noselected">11</td>
    <td id="184" class="noselected">12</td>
    <td id="185" class="noselected">13</td>
    <td id="186" class="noselected">14</td>
    <td id="187" class="noselected">15</td>
    <td id="188" class="noselected">16</td>
    <td id="189" class="noselected">17</td>
    <td id="190" class="noselected">18</td>
    <td id="191" class="noselected">19</td>
    <td id="192" class="noselected">20</td>
    <td class="empty">9</td>
    <td id="193" class="noselected">21</td>
    <td id="194" class="noselected">22</td>
    <td id="195" class="noselected">23</td>
    <td id="196" class="noselected">24</td>

  </tr>
  <tr>
    <td class="empty"></td>
    <td id="197" class="noselected">1</td>
    <td id="198" class="noselected">2</td>
    <td id="199" class="noselected">3</td>
    <td id="200" class="noselected">4</td>
    <td class="empty">8</td>
    <td id="201" class="noselected">5</td>
    <td id="202" class="noselected">6</td>
    <td id="203" class="noselected">7</td>
    <td id="204" class="noselected">8</td>
    <td id="205" class="noselected">9</td>
    <td id="206" class="noselected">10</td>
    <td id="207" class="noselected">11</td>
    <td id="208" class="noselected">12</td>
    <td id="209" class="noselected">13</td>
    <td id="210" class="noselected">14</td>
    <td id="211" class="noselected">15</td>
    <td id="212" class="noselected">16</td>
    <td id="213" class="noselected">17</td>
    <td id="214" class="noselected">18</td>
    <td id="215" class="noselected">19</td>
    <td id="216" class="noselected">20</td>
    <td class="empty">8</td>
    <td id="217" class="noselected">21</td>
    <td id="218" class="noselected">22</td>
    <td id="219" class="noselected">23</td>
    <td id="220" class="noselected">24</td>

  </tr>
  <tr>
    <td class="empty"></td>
    <td id="221" class="noselected">1</td>
    <td id="222" class="noselected">2</td>
    <td id="223" class="noselected">3</td>
    <td id="224" class="noselected">4</td>
    <td class="empty">7</td>
    <td id="225" class="noselected">5</td>
    <td id="226" class="noselected">6</td>
    <td id="227" class="noselected">7</td>
    <td id="228" class="noselected">8</td>
    <td id="229" class="noselected">9</td>
    <td id="230" class="noselected">10</td>
    <td id="231" class="noselected">11</td>
    <td id="232" class="noselected">12</td>
    <td id="233" class="noselected">13</td>
    <td id="234" class="noselected">14</td>
    <td id="235" class="noselected">15</td>
    <td id="236" class="noselected">16</td>
    <td id="237" class="noselected">17</td>
    <td id="238" class="noselected">18</td>
    <td id="239" class="noselected">19</td>
    <td id="240" class="noselected">20</td>
    <td class="empty">7</td>
    <td id="241" class="noselected">21</td>
    <td id="242" class="noselected">22</td>
    <td id="243" class="noselected">23</td>
    <td id="244" class="noselected">24</td>

  </tr>
  <tr>
    <td id="245" class="noselected">1</td>
    <td id="246" class="noselected">2</td>
    <td id="247" class="noselected">3</td>
    <td id="248" class="noselected">4</td>
    <td id="249" class="noselected">5</td>
    <td class="empty">6</td>
    <td id="250" class="noselected">6</td>
    <td id="251" class="noselected">7</td>
    <td id="252" class="noselected">8</td>
    <td id="253" class="noselected">9</td>
    <td id="254" class="noselected">10</td>
    <td id="255" class="noselected">11</td>
    <td id="256" class="noselected">12</td>
    <td id="257" class="noselected">13</td>
    <td id="258" class="noselected">14</td>
    <td id="259" class="noselected">15</td>
    <td id="260" class="noselected">16</td>
    <td id="261" class="noselected">17</td>
    <td id="262" class="noselected">18</td>
    <td id="263" class="noselected">19</td>
    <td id="264" class="noselected">20</td>
    <td id="265" class="noselected">21</td>
    <td class="empty">6</td>
    <td id="266" class="noselected">22</td>
    <td id="267" class="noselected">23</td>
    <td id="268" class="noselected">24</td>
    <td id="269" class="noselected">25</td>

  </tr>
  <tr>
    <td id="270" class="noselected">1</td>
    <td id="271" class="noselected">2</td>
    <td id="272" class="noselected">3</td>
    <td id="273" class="noselected">4</td>
    <td id="274" class="noselected">5</td>
    <td class="empty">5</td>
    <td id="275" class="noselected">6</td>
    <td id="276" class="noselected">7</td>
    <td id="277" class="noselected">8</td>
    <td id="278" class="noselected">9</td>
    <td id="279" class="noselected">10</td>
    <td id="280" class="noselected">11</td>
    <td id="281" class="noselected">12</td>
    <td id="282" class="noselected">13</td>
    <td id="283" class="noselected">14</td>
    <td id="284" class="noselected">15</td>
    <td id="285" class="noselected">16</td>
    <td id="286" class="noselected">17</td>
    <td id="287" class="noselected">18</td>
    <td id="288" class="noselected">19</td>
    <td id="289" class="noselected">20</td>
    <td id="290" class="noselected">21</td>
    <td class="empty">5</td>
    <td id="291" class="noselected">22</td>
    <td id="292" class="noselected">23</td>
    <td id="293" class="noselected">24</td>
    <td id="294" class="noselected">25</td>

  </tr>
  <tr>
    <td class="empty"></td>
    <td id="295" class="noselected">1</td>
    <td id="296" class="noselected">2</td>
    <td id="297" class="noselected">3</td>
    <td id="298" class="noselected">4</td>
    <td class="empty">4</td>
    <td id="299" class="noselected">5</td>
    <td id="300" class="noselected">6</td>
    <td id="301" class="noselected">7</td>
    <td id="302" class="noselected">8</td>
    <td id="303" class="noselected">9</td>
    <td id="304" class="noselected">10</td>
    <td id="305" class="noselected">11</td>
    <td id="306" class="noselected">12</td>
    <td id="307" class="noselected">13</td>
    <td id="308" class="noselected">14</td>
    <td id="309" class="noselected">15</td>
    <td id="310" class="noselected">16</td>
    <td id="311" class="noselected">17</td>
    <td id="312" class="noselected">18</td>
    <td id="313" class="noselected">19</td>
    <td id="314" class="noselected">20</td>
    <td class="empty">4</td>
    <td id="315" class="noselected">21</td>
    <td id="316" class="noselected">22</td>
    <td id="317" class="noselected">23</td>
    <td id="318" class="noselected">24</td>

  </tr>
  <tr>
    <td class="empty"></td>
    <td id="319" class="noselected">1</td>
    <td id="320" class="noselected">2</td>
    <td id="321" class="noselected">3</td>
    <td id="322" class="noselected">4</td>
    <td class="empty">3</td>
    <td id="323" class="noselected">5</td>
    <td id="324" class="noselected">6</td>
    <td id="325" class="noselected">7</td>
    <td id="326" class="noselected">8</td>
    <td id="327" class="noselected">9</td>
    <td id="328" class="noselected">10</td>
    <td id="329" class="noselected">11</td>
    <td id="330" class="noselected">12</td>
    <td id="331" class="noselected">13</td>
    <td id="332" class="noselected">14</td>
    <td id="333" class="noselected">15</td>
    <td id="334" class="noselected">16</td>
    <td id="335" class="noselected">17</td>
    <td id="336" class="noselected">18</td>
    <td id="337" class="noselected">19</td>
    <td id="338" class="noselected">20</td>
    <td class="empty">3</td>
    <td id="339" class="noselected">21</td>
    <td id="340" class="noselected">22</td>
    <td id="341" class="noselected">23</td>
    <td id="342" class="noselected">24</td>

  </tr>
  <tr>
    <td id="343" class="noselected">1</td>
    <td id="344" class="noselected">2</td>
    <td id="345" class="noselected">3</td>
    <td id="346" class="noselected">4</td>
    <td id="347" class="noselected">5</td>
    <td class="empty">2</td>
    <td id="348" class="noselected">6</td>
    <td id="349" class="noselected">7</td>
    <td id="350" class="noselected">8</td>
    <td id="351" class="noselected">9</td>
    <td id="352" class="noselected">10</td>
    <td id="353" class="noselected">11</td>
    <td id="354" class="noselected">12</td>
    <td id="355" class="noselected">13</td>
    <td id="356" class="noselected">14</td>
    <td id="357" class="noselected">15</td>
    <td id="358" class="noselected">16</td>
    <td id="359" class="noselected">17</td>
    <td id="360" class="noselected">18</td>
    <td id="361" class="noselected">19</td>
    <td id="362" class="noselected">20</td>
    <td id="363" class="noselected">21</td>
    <td class="empty">2</td>
    <td id="364" class="noselected">22</td>
    <td id="365" class="noselected">23</td>
    <td id="366" class="noselected">24</td>
    <td id="367" class="noselected">25</td>

  </tr>
  <tr>
    <td id="368" class="noselected">1</td>
    <td id="369" class="noselected">2</td>
    <td id="370" class="noselected">3</td>
    <td id="371" class="noselected">4</td>
    <td id="372" class="noselected">5</td>
    <td class="empty">1</td>
    <td id="373" class="noselected">6</td>
    <td id="374" class="noselected">7</td>
    <td id="375" class="noselected">8</td>
    <td id="376" class="noselected">9</td>
    <td id="377" class="noselected">10</td>
    <td id="378" class="noselected">11</td>
    <td id="379" class="noselected">12</td>
    <td id="380" class="noselected">13</td>
    <td id="381" class="noselected">14</td>
    <td id="382" class="noselected">15</td>
    <td id="383" class="noselected">16</td>
    <td id="384" class="noselected">17</td>
    <td id="385" class="noselected">18</td>
    <td id="386" class="noselected">19</td>
    <td id="387" class="noselected">20</td>
    <td id="388" class="noselected">21</td>
    <td class="empty">1</td>
    <td id="389" class="noselected">22</td>
    <td id="390" class="noselected">23</td>
    <td id="391" class="noselected">24</td>
    <td id="392" class="noselected">25</td>

  </tr>
  <tr>
    <td class="empty" colspan="11"></td>
    <td class="scene" colspan="6">СЦЕНА</td>
    <td class="empty" colspan="10"></td>

  </tr>
</table>
<? echo $display->distinctPricesHTML ?><br>
<img style="width:42px" src="k.svg"> => <a href="karabas.com">karabas.com</a>
<p>Выбрано: </p>
<p><? echo 'Тестовое событие, '; ?></p>
<p> 20.10.2020 18:30</p>
<form action="" method="POST" style="display:none">
<p class="listselected"></p>
<p>К оплате (на кассе): </p>
<input required placeholder="Ваш телефон" type="number" name="phone" id="phone"><br>
<input required placeholder="Ваше ім'я" type="text" name="name"><br>
<input type="hidden" name="order" id="order">
<input type="hidden" name="tabId" value="<? echo $_SESSION['ev'.$eventId]['tabId']; ?>">
<input type="hidden" name="eventId" value="<? echo $eventId; ?>">
<button name="do">В резерв!</button>
</form>
<script>
let startDate = Date.now(); //deb
let tabId = '&tabId=' + <? echo $_SESSION['ev'.$eventId]['tabId']; ?>;
let eventId = '&eventId=' + <? echo $eventId; ?>;

//display
let tickets = jQuery.parseJSON('<? echo json_encode($display->tickets); ?>');
$.each(tickets, function(key,ticket) {
    if (ticket['price'])
        $('#' + ticket['place'])
            .attr('style','background:' + ticket['color']['background'] + ';color:' + ticket['color']['color']);
    if (!ticket['price'] && ticket['karabas'])
        $('#' + ticket['place'])
            .attr('style','background:#ffee5a').html('<img src="k.svg">').toggleClass('noselected empty');
    if(ticket['taken']) $('#' + ticket['place']).toggleClass('noselected taken');
});


//selections

$( document ).ajaxError( function ( event, jqXHR, settings, thrownError ) {
    $('p.d').text('!' + jqXHR.statusText + ': ' + jqXHR.status + ' ' + thrownError);
});

function unClick(request) {
    errPlace = new URLSearchParams(request).get('place');
    if ($('#' + errPlace).hasClass('preselected')) $('#' + errPlace).toggleClass('preselected noselected');
    if ($('#' + errPlace).hasClass('unselected')) $('#' + errPlace).toggleClass('unselected selected');
}

function preAvailablesGet() {
    preAvailables = [];
    $(".unselected").each(function(i){
        preAvailables.push($(this).attr("id"));
    });
    $(".noselected").each(function(i){
        preAvailables.push($(this).attr("id"));
    });
    $(".preselected").each(function(i){
        preAvailables.push($(this).attr("id"));
    });
    $(".selected").each(function(i){
        preAvailables.push($(this).attr("id"));
    });
    $(".prolselected").each(function(i){
        preAvailables.push($(this).attr("id"));
    });
    //deb console.log('preAvailables: ' + preAvailables);
    return '&preAvailables=' + preAvailables;
}

function refresh(changes) {
    $.each(changes, function(k,v) {
        if (($('#' + v.place).hasClass('noselected') && v.taken) || ($('#' + v.place).hasClass('taken') && !v.taken)) {
            $('#' + v.place).toggleClass('noselected taken'); 
            console.log((Date.now()-startDate)/1000 + ' изменён ' + v.place + ' на ' + v.taken); //deb
        } else if ($('#' + v.place).hasClass('taken') && v.taken) { //deb
            console.log((Date.now()-startDate)/1000 + ' был отмечен как занят ранее ' + v.place); //deb
        } else if ($('#' + v.place).hasClass('noselected') && !v.taken) { //deb
            console.log((Date.now()-startDate)/1000 + ' был отмечен свободным ранее ' + v.place); //deb
        }
    });
}

function pending(place) {
    if (typeof place != 'obj') place = '#' + place;

    if ($(place).hasClass('preselected') //deb
     || $(place).hasClass('unselected') //deb
     || $(place).hasClass('prolselected')) console.log('pending (lock)'); //deb

    return ($(place).hasClass('preselected') || $(place).hasClass('unselected') || $(place).hasClass('prolselected'));
}

function requestDeb(post) { //deb!
    //debdeb console.log(post); 
    return (Date.now()-startDate)/1000 + ' ушло: ' + post.replace(/(preAvailables=)([^&]+)/, '$1...'); //deb!
} //deb!

function responseDeb(response) { //deb!
    return //deb!
} //deb!

let order = [];
let prolong = [];
$('td').on('click', function() {
    place = $(this).attr('id');
    console.log(place + '(click)' + this.className); //deb
    if (pending(place)) return false;

    if ($(this).hasClass('selected')) {
        what = '&what=drop';
        order = jQuery.grep(order, function(value) {
            return value != place;
        });
        if (!order.length) $('form').hide();
        $(this).toggleClass('selected unselected');
    } else if ($(this).hasClass('noselected')) {
        what = '&what=need';
        $(this).toggleClass('noselected preselected');
    } else { what = '&what=check'; }

    post = eventId + tabId + what + '&place=' + place + preAvailablesGet();
//↓1 ajax click..........................
    $.ajax({
        type: 'POST',
        url: 'post.php',
        data: post,
        beforeSend: console.log(requestDeb(post)), //deb
        success: function(response){
            console.log((Date.now()-startDate)/1000 + ' пришло: ' + response); //deb
            if (response == 'несколько вкладок') $('.message-wrapper').css('display','flex');
            try { response = jQuery.parseJSON(response); } 
            catch (e) { $('p.d').text(response); /*//deb*/ unClick(this.data); }
            place = response['place'];

            if ($('#' + place).hasClass('preselected') && response['itSchanged']) 
                $('#' + place).toggleClass('preselected noselected');
            refresh(response['changes']);

            if ($('#' + place).hasClass('preselected')) {
                if (!order.length) $('form').show();
                order.push(place);
                $('#' + place).toggleClass('preselected selected');
                prolong[place] = setInterval(function(place) {
                    console.log($('#' + place).attr('id') + '(autoprolong)' + $('#' + place).attr('class')); //deb
                    if (pending(place)) return false;
                    $('#' + place).toggleClass('selected prolselected');
                    post = eventId + tabId + '&what=need' + '&place=' + place + preAvailablesGet();
//↓3 ajax prolong (setInterval).............
                    $.ajax({
                        type: 'POST',
                        url: 'post.php',
                        data: post,
                        beforeSend: console.log(requestDeb(post)), //deb
                        success: function(response){
                            console.log((Date.now()-startDate)/1000 + ' пришло: ' + response); //deb
                            if (response == 'несколько вкладок')
                                $('.message-wrapper').css('display','flex');
                            try { response = jQuery.parseJSON(response); } 
                            catch (e) { $('p.d').text(response); /*//deb*/ }
                            //if (response['fail'] == 'занято другим') alert('место занято');
                            if (response['itSchanged']) 
                                alert('возможно, устройство засыпало или пропадал интернет, место ' 
                                    + response['place'] + ' занято');
                            refresh(response['changes']);
                        },
                        complete: function(){
                            $('#' + new URLSearchParams(this.data).get('place')).toggleClass('selected prolselected');
                        }
                    })
//↑3 ajax end prolong (setInterval)..........
                }, 900000, place);
            }
            $('p.listselected').text(order);
            if ($('#' + place).hasClass('unselected')) {
                $('#' + place).toggleClass('unselected noselected');
                clearInterval(prolong[place]);
                //deb console.log((Date.now()-startDate)/1000 + ' кликом установлен класс noselected ' + place);
            }

            setTimeout(function() {
                if ($('#' + place).hasClass('taken')) {
                    let phone = prompt(
                        'Це місце зайняте, але ми можемо передзвонити, якщо воно звільниться і ви вкажете свій номер телефону:',
                        $('#phone').val());
                    if (phone) {
                        if ($('#phone').val() == '') $('#phone').val(phone);
                        post = eventId + tabId + '&what=need' + '&place=' + place + '&phone=' + phone + preAvailablesGet();
//↓2 ajax inQueue............................
                        $.ajax({
                            type: 'POST',
                            url: 'post.php',
                            data: post,
                            beforeSend: console.log(requestDeb(post)), //deb
                            success: function(response){
                                console.log((Date.now()-startDate)/1000 + ' пришло: ' + response); //deb
                                if (response == 'несколько вкладок')
                                    $('.message-wrapper').css('display','flex');
                                try { response = jQuery.parseJSON(response); } 
                                catch (e) { $('p.d').text(response); /*//deb*/ }
                                refresh(response['changes']);
                            }
//↑2 ajax end inQueue.........................
                        });
                    }
                }
            }, 10);
        },
        error: function () {
            unClick(this.data);
        }
    })
//↑1 ajax end click............................
});

//send order
$('form').submit(function() {
    $('#order').val(order);
});

</script>
</body>
</html>
