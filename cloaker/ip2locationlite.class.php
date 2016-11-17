<?php
// MODIFIED FOR wpCloaker to not check the ip by gethostbyname() and do no IP format checking with preg

final class ip2location_lite{
	protected $errors = array();
	protected $service = 'api.ipinfodb.com';
	protected $version = 'v3';
	protected $apiKey = '';

	public function __construct(){}

	public function __destruct(){}

	public function setKey($key){
		if(!empty($key)) $this->apiKey = $key;
	}

	public function getError(){
		return implode("\n", $this->errors);
	}

	public function getCountry($remote_addr){
		return $this->getResult('ip-country', $remote_addr);
	}

	public function getCity($remote_addr){
		return $this->getResult('ip-city', $remote_addr);
	}

	private function getResult($name, $remote_addr){
		$xml = @my_file_get_contents('http://' . $this->service . '/' . $this->version . '/' . $name . '/?key=' . $this->apiKey . '&ip=' . $remote_addr . '&format=xml');

		try{
			$response = @new SimpleXMLElement($xml);

			foreach($response as $field=>$value){
				$result[(string)$field] = (string)$value;
			}

			return $result;
		}
		catch(Exception $e){
			$this->errors[] = $e->getMessage();
			return;
		}

		$this->errors[] = 'not a valid IP address or hostname.';
		return;
	}
}
?>