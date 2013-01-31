<?php
class Component
{
    private $variables;
    private $strict_mode = false;
    function __construct($para_indexes)
    {
	$this->variables = new ArrayObject();
	if(is_array($para_indexes))
	{
	    $this->strict_mode = true;
	    foreach($para_indexes as $index)
	    {
		$this->variables->offsetSet($index, null);
	    }
	}

    }
    public function __get($para_key)
    {
	return $this->variables->offsetGet($para_key);
    }
    public function __set($para_key, $para_value)
    {
	if($this->strict_mode && $this->variables->offsetExists($para_key))
	{
	    throw Exception("Invalidated index in Strict mode " . __CLASS__);
	}
	$this->variables[$para_key] = $para_value;
    }
    public function getVariables()
    {
	return $this->variables;
    }
}
