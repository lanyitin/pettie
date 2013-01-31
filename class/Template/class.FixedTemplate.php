<?php
require_once(TPL_CLASS_PATH."class.Template.php");
class FixedTemplate extends Template
{
	function __construct($para_str)
	{
		parent::__construct();
		$this->str = $para_str;
	}

	public function execTplCode()
	{
		$patterns = array();
		$patterns[] = "/<!---?(.*)?--->/ime";
		$patterns[] = "/{{([a-zA-Z0-9]*)}}/ime";

		$replacements = array();
		$replacements[] = "<?php $1 ?>";
		echo preg_replace($patterns, $replacements, $this->str);
	}
} 
?>
