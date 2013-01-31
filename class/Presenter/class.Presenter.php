<?php
require_once(PRESENTER_PATH."Interface.Presenter.php");
require_once(CLASS_PATH.DS."class.DataBase.php");
require_once(CLASS_PATH.DS."class.Response.php");
abstract class Presenter
{
	protected $db = null;
	protected $response = null;
	function __construct()
	{
		$this->db = PDAO::getInstance();
	}

	public function handle_request(Request $para_request)
	{
		$prefix = $para_request->apiMode?"api_":"handle_";

		for($l = count($para_request->url_parameters); $l >= 0; $l--){

			$url_arr = array_slice($para_request->url_parameters, 0, $l); 
			$methodName = implode("_", $url_arr); 
			$methodName = $prefix.$methodName;
			if(method_exists($this,$methodName)){
				$parameters = array_merge((array)$para_request->parameters,array_slice($para_request->url_parameters, $l));
				$response =  $this->$methodName($parameters);
				return $response;
			}
		}
		header("HTTP/1.0 404 Not Found");
		die();
	}
}
?>
