<?php
require_once(TPL_CLASS_PATH."class.Template.php");
class FileTemplate extends Template
{
	private $filePath = null;

	function __construct($filePath)
	{
		parent::__construct();
		$this->filePath = $filePath;
	}

	public function compile()
	{
		extract($this->vars, EXTR_PREFIX_ALL, "tpl");
		ob_start();
		include($this->filePath);
		$response = ob_get_contents();
		ob_end_clean();
		return $response;
	}
} 
?>
