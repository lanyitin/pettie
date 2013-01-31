<?php
require_once(TPL_CLASS_PATH."class.FileTemplate.php");
class TemplateFactory
{
	public static function getByFilename($filename)
	{
		$filePath = TPL_PATH.$filename;
		$tpl = new FileTemplate($filePath);
		return $tpl;
	}
}
