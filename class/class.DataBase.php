<?php
class PDAO extends PDO
{
	private static $instance = null;
	public static function getInstance($connect_string = null , $username = null , $password = null)
	{
		if(self::$instance === null)
		{
			//don't touch following two lines unless you know what are u doing.
			self::$instance = new PDAO($connect_string, $username, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			self::$instance->exec("SET NAMES 'utf8';");
		}
		return self::$instance;
	}
	public static function exception_handler($exception) {
		die('Uncaught exception: '. $exception->getMessage());
	}
	public function __construct($dsn, $username='', $password='', $driver_options=array()) {

		set_exception_handler(array(__CLASS__, 'exception_handler'));

		parent::__construct($dsn, $username, $password, $driver_options);

		restore_exception_handler();
	}
	public function query($sql)
	{
		$stmt =  parent::query($sql) or die(print_r($this->errorInfo()).$sql);
		return $stmt;
	}
}
?>
