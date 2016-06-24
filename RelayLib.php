<?php 

class RelayLib {
	protected $_curlResource;
	protected $_url;
	
	public function __construct($ip, $port, $username, $password)
	{
	  try {
		$this->_url = "http://" . $ip . ":" . $port . "/";
		$curl = curl_init($this->_url);
		$this->_curlResource = $curl;
	
	  }catch (Exception $exc) {

            echo $exc->getMessage().'<br/>';
            echo $exc->getTraceAsString();
            die();

	  }
	
		curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($curl);
		if ($response != true)
			throw new Exception("Constructor curl_execution failed ");
		
		$resultStatus = curl_getinfo($curl);
		if ($resultStatus['http_code'] != 200)
			throw new Exception("Authentication failed .Server responded with: ".$resultStatus['http_code']." code");
	}
	public function status()
	{
		$curl = $this->_curlResource;
		
		$resultStatus = curl_getinfo($curl);
		if ($resultStatus['http_code'] != 200)
			throw new Exception("Status connection failed .Server responded with: ".$resultStatus['http_code']." code");
		curl_setopt($curl, CURLOPT_URL, $this->_url . 'status.xml');
		
		$result = curl_exec($curl);
		 
		if ($result != true)
			throw new Exception("Status check curl_execution failed ");
		
		$status = $this->loadUrlAndDom($result);
		
		return $this->getElement($status);
	}
	public function name()
	{
		$curl = $this->_curlResource;
		
		$resultStatus = curl_getinfo($curl);
		if ($resultStatus['http_code'] != 200)
			throw new Exception("Status connection failed .Server responded with: ".$resultStatus['http_code']." code");
		curl_setopt($curl, CURLOPT_URL, $this->_url . 'status.xml');
		
		$result = curl_exec($curl);
		 
		if ($result != true)
			throw new Exception("Status check curl_execution failed ");
		
		$status = $this->loadUrlAndDom($result);
		
		return $this->getElementName($status);
	}	
	public function toggle($relNumber)
	{
		if ($relNumber < 1 && $relNumber > 8)
			throw new Exception("The toggle function input should from 1 to 8 .You have entered:".$relNumber);
		
		$curl = $this->_curlResource;
		$resultStatus = curl_getinfo($curl);
		if ($resultStatus['http_code'] != 200)
			throw new Exception("Toggle connection failed .Server responded with: ".$resultStatus['http_code']." code");
		curl_setopt($curl, CURLOPT_URL, $this->_url .'relays.cgi?relay='. $relNumber);
		
		$result = curl_exec($curl);
		if ($result != true)
			throw new Exception("Toggle curl_execution failed.");
	}
	protected function loadUrlAndDom($content)
	{
		$dom = new DOMDocument;
		$dom->strictErrorChecking = false;
		
		if ($content)
			$dom->loadHTML($content);
		
		return $dom;
	}
	protected function getElement($obj)
	{

		if (!$obj->getElementsByTagName('response')->length)
			throw new Exception('Could not get HTML content.');
		$matches[0] = $obj->getElementsByTagName('relay1')->item(0)->nodeValue;
		$matches[1] = $obj->getElementsByTagName('relay2')->item(0)->nodeValue;
		$matches[2] = $obj->getElementsByTagName('relay3')->item(0)->nodeValue;
		$matches[3] = $obj->getElementsByTagName('relay4')->item(0)->nodeValue;
		$matches[4] = $obj->getElementsByTagName('relay5')->item(0)->nodeValue;
		$matches[5] = $obj->getElementsByTagName('relay6')->item(0)->nodeValue;
		$matches[6] = $obj->getElementsByTagName('relay7')->item(0)->nodeValue;
		$matches[7] = $obj->getElementsByTagName('relay8')->item(0)->nodeValue;
		array_shift($matches);
		return $matches;
		throw new Exception("Unexpected document structure.");

	}

	protected function getElementName($obj)
	{

		if (!$obj->getElementsByTagName('response')->length)
			throw new Exception('Could not get HTML content.');
		$matches[0] = $obj->getElementsByTagName('r1name')->item(0)->nodeValue;
		$matches[1] = $obj->getElementsByTagName('r2name')->item(0)->nodeValue;
		$matches[2] = $obj->getElementsByTagName('r3name')->item(0)->nodeValue;
		$matches[3] = $obj->getElementsByTagName('r4name')->item(0)->nodeValue;
		$matches[4] = $obj->getElementsByTagName('r5name')->item(0)->nodeValue;
		$matches[5] = $obj->getElementsByTagName('r6name')->item(0)->nodeValue;
		$matches[6] = $obj->getElementsByTagName('r7name')->item(0)->nodeValue;
		$matches[7] = $obj->getElementsByTagName('r8name')->item(0)->nodeValue;
		array_shift($matches);
		return $matches;
		throw new Exception("Unexpected document structure.");

	}	
}
