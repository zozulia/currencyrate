<?php
require_once('CurrencyRateInterface.php');
require_once('APIRequest.php');
require_once('NBUUSDRate.php');

$obj = new ZozuliaForRingostat\NBUUSDRate("https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json");

echo $_GET['amount'] . ' USD = ' . $obj->convert($_GET['code'], $_GET['amount']) . '  ' . $_GET['code'] . ';';
?>