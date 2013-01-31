<?php
class Request
{
	public $presenterName = null;
	public $url_parameters = null;
	public $parameters = null;
	public $apiMode = false;
	function __construct($para_request_str, $parameters = array())
	{
		foreach($parameters as $key=>$value){
			if(is_string($parameters[$key])){
				$this->parameters[$key] = htmlentities($parameters[$key], ENT_QUOTES);
			}else{
				$this->parameters[$key] = $parameters[$key];
			}
		}

		$ary = explode("/", $para_request_str);
		//check if the request is on API mode
		for($i = 0; $i < count($ary); $i++) {
			if($ary[$i] == "" || $ary[$i] == null) {
				unset($ary[$i]);
			}
		}
		$ary = array_values($ary);
		if($ary[0] === "api"){
			$ary = array_slice($ary,1);
			$this->apiMode = true;
		}

		$this->presenterName = htmlentities($ary[0]);
		$this->url_parameters = array_slice($ary, 1);
		foreach($this->url_parameters as $key=>$value){
			$this->url_parameters[$key] = htmlentities($this->url_parameters[$key], ENT_QUOTES);
		}
	}

	public function execute()
	{
		$presenterFilePath = PRESENTER_PATH."class.".ucfirst($this->presenterName).".php";
		if(file_exists($presenterFilePath))
		{
			require_once($presenterFilePath);
			$presenterClassName = "Presenter" . ucfirst($this->presenterName);
			$presenter = new $presenterClassName;
			$response = $presenter->handle_request($this);
			return $response;
		}else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
}
?>
