<?php
require_once("interface.ITemplate.php");
abstract class Template implements ITemplate
{
	protected $vars;
	protected $compiledContent;

	function __construct()
	{
		$this->vars = array();
	}

	function __get($key)
	{
		return $this->vars[$key];
	}

	function __set($key, $value)
	{
		$this->vars[$key] = $value;
	}

	public function get($key)
	{
		return $this->__get($key);
	}

	public function set($key, $value)
	{
		$this->__set($key, $value);
	}

	public function render($parameters = array())
	{
		foreach($parameters as $key=>$value)
		{
			$this->set($key, $value);
		}
		return  $this->compile();
	}

	public function __toString()
	{
		return $this->render();
	}

	abstract public function compile();
}
