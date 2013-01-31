<?php
abstract class PersistentObj
{
	protected $fields;
	function __construct($para_db, $para_data = null)
	{
		if($para_db == null){
			die("the first paramenter can not be null : PersistentObg");
		}
		$this->fields["db"] = $para_db;
		if(is_array($para_data))
		{
			foreach($para_data as $key => $value){
				$this->fields[$key] = $value;
			}
		}
	}

	public function __get($para_key)
	{
		if(array_key_exists($para_key, $this->fields)){
			return $this->fields[$para_key];
		}
	}

	public function __set($para_key, $para_value)
	{
		if(array_key_exists($para_key, $this->fields)){
			$this->fields[$para_key] = $para_value;
		}
	}

	public function initWithArray($para_array)
	{
		foreach($para_array as $key=>$value){
			$this->$key=$value;
		}
	}

	abstract public function save();
}
?>
