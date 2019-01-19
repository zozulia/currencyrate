<?php
namespace ZozuliaForRingostat;

interface CurrencyRate{
	/*
	*	returns $amount dollars equivalent of $code currency
	*/
	public function convert($code,$amount);
	
	
	/*
	*	returns currency codes array for available rates
	*/
	public function getCodesList();
}
?>