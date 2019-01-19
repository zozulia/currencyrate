<?php
namespace ZozuliaForRingostat;

class NBUUSDRate implements CurrencyRate{
	
	private $_req;
	
	private $_json;

	public function __construct( $urlAPI ){
		$this->_req = new APIRequest(300, __DIR__ . '/cache' );

		$this->_req->setUrlBase($urlAPI);
		
		$this->_json = $this->_req->query();

	}

	private function getArrCurrencies(){
		
		return json_decode($this->_json);
	}
	
	public function convert($code, $amount){
		
			$arr_currencies = $this->getArrCurrencies();
			
			$USDRate = .0;
			
			$targetRate = .0;
			
			foreach($arr_currencies as $objCurrency){
				
				if ($objCurrency->cc == 'USD') $USDRate = $objCurrency->rate;
				
				if ($objCurrency->cc == $code) $targetRate = $objCurrency->rate;

				if( ($USDRate > 0) && ($targetRate > 0)) break;
				
			}/* foreach */

			return $amount * $USDRate / $targetRate;
	}
	
	public function getCodesList(){
		
		$ret = array();
		
		foreach($this->getArrCurrencies() as $objCurrency){
			
			$ret[] = $objCurrency->cc;
			
		}
		
		return $ret;
	}
}
?>