<?php
require_once(CLASS_PATH."class.Request.php");
interface IPresenter
{
	public function handleRequest(Request $para_request);
	public function response();
	public function handle_default(Request $para_request);
}
?>
