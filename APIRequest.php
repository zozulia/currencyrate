<?php
namespace ZozuliaForRingostat;

class APIRequest{
	
	private $_urlBase, $_urlAction, $_hashParams, $_intCacheSeconds, $_cacheDirectory;
	
	public function __construct($intCacheSeconds = 0, $cacheDirectory = ''){
		
		$this->_urlBase = '';
		
		$this->_urlAction = '';
		
		$this->_hashParams = array();
		
		$this->_intCacheSeconds = $intCacheSeconds;
		
		$this->_cacheDirectory = $cacheDirectory;
		
		if ( !empty($cacheDirectory) && !file_exists($cacheDirectory) ) mkdir($cacheDirectory);

	}

	public function setUrlBase($urlBase){
		
		if (substr($urlBase,0,4) !== 'http'){
			
			throw new Exception('URL base must be starting with "http://" OR "https://"');
			
		}
	
		$this->_urlBase = $urlBase;
		
		if (substr($urlBase, -1) != '/') $this->_urlBase .= '/'; // urlBase should be ending with '/' symbol
		
	}
	
	public function setUrlAction($urlAction){
		
		$this->_urlBase = $urlBase;
	}
	
	public function setRequestParams($params ){
		
		$this->_hashParams = $params;
		
	}

	protected function assembleUrl(){

		if ( !isset($this->_urlBase{6}) ){
			
			throw new Exception('URL base is not set');
			
		}

		$dataGET = '';

		$delimiter = '?';
		
		foreach( $this->_hashParams as $paramName => $paramValue ){
			
			$dataGET .= $delimiter . $paramName . '=' . $paramValue;
			
			$delimiter = '&';
			
		}/* foreach */

		return $this->_urlBase . (empty($this->_urlAction) ? '' : '/' . $this->_urlAction) . $dataGET;

	}
	
	protected function HTTPRequest( $url ){
		
		return file_get_contents($url);
		
	}
	
	public function query(){
		
		$url = $this->assembleUrl();

		$cacheFileName = false;
		
		if ( ($this->_intCacheSeconds > 0) && isset($this->_cacheDirectory{1}) ){ // if cache directory set, so cache coud be used
		
			$cacheFileName = $this->_cacheDirectory . '/' . md5($this->_urlAction . json_encode($this->_hashParams));
		}

		if($cacheFileName){
			
			if ( file_exists($cacheFileName) && (filemtime($cacheFileName) > time() - $this->_intCacheSeconds) ){
				
				return file_get_contents($cacheFileName);

			}
			else{

				$answer = $this->HTTPRequest($url);
				
				file_put_contents($cacheFileName, $answer);
				
				return $answer;
				
			}
		}
		
		return $this->HTTPRequest($url);
	}
}
?>