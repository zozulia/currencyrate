<?php
require_once('CurrencyRateInterface.php');
require_once('APIRequest.php');
require_once('NBUUSDRate.php');

$obj = new ZozuliaForRingostat\NBUUSDRate("https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json");

$arr_codes = $obj->getCodesList();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>USD converter by Roman Zozulia</title>
		<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js?ver=3.9.2'></script>
	</head>
	<body>
	<div>
	<input type="number" name="amount" placeholder="amount" value="1"> USD to 
	<select name="code">
<?
foreach($arr_codes as $code){
	
	echo "\n" . '<option value="' . $code . '">' . $code . '</option>';
	
}
?>
	</select>
	<button onclick="$('.answer').load('./convert.php?code=' + $('select[name=&quot;code&quot;]').val() + '&amount=' + $('input[name=&quot;amount&quot;]').val());">Convert</button>
	</div>
	<p class="answer"></p>
	</body>
</html>