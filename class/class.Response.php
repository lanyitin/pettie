<?php
class Response
{
	public $errorCode;
	public $content;
	function __construct($para_code, $para_content)
	{
		$this->errorCode = $para_code;
		$this->content = $para_content;
	}
	public function isSuccessed()
	{
		return !$this->errorCode;
	}
}
?>
