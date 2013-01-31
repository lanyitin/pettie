<?php
interface ITemplate
{
	public function render($parameters);
	public function set($key, $value);
	public function get($key);
} 
?>
