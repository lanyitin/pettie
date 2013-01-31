<?php
class AccountInfo
{
	public $id;
	public $username;
	public $password;
	public $email;
	public $status;
	public $privilege;
	public $Pic;
	private $db;
	function __construct($para_db)
	{
		$this->id=null;
		$this->username=null;
		$this->password=null;
		$this->email=null;
		$this->status=null;
		$this->privilege=null;
		$this->Pic=null;  
		$this->db = $para_db;
	}
	public function save()
	{
		if(!self::validateUsername($this->username)){
			die("The validation of username was failed");
		}
		if($this->id){
			$sql = sprintf("UPDATE %s SET password=\"%s\", Pic=\"%s\", email=\"%s\", status=\"%s\" where id=%d", "AccountInfo", $this->password, $this->Pic ,$this->email, $this->status, $this->id);
			$stmt = $this->db->query($sql);
		}else{
			$lastinsertid = $this->db->lastInsertId();
			$sql = sprintf("INSERT INTO AccountInfo (username, email, password) values ('%s', '%s', '%s')",$this->username, $this->email, $this->password);
			$this->db->query($sql);
			if($this->db->lastInsertId() === $lastinsertid){
				die("Cannot create new user");
			}
		}
	}
	public function active()
	{
		if($this->status != "Actived"){
			$this->status = "Actived";
			$this->save();
		}

	}
	static public function getById($para_id, $para_db)
	{
		$user = new AccountInfo($para_db);
		$sql=sprintf("SELECT * from AccountInfo where id=%d", $para_id);
		$stmt = $para_db->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row){
			foreach($row as $key => $value){
				$user->$key = $value;
			}
		}
		return $user;
	}
	static public function getByUsername($para_username, $para_db)
	{
		$user = new AccountInfo($para_db);
		$sql=sprintf("SELECT * from AccountInfo where username='%s'", $para_username);
		$stmt = $para_db->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row){
			foreach($row as $key => $value){
				$user->$key = $value;
			}
		}
		return $user;
	}

	static public function getByEmail($para_email, $para_db)
	{
		$user = new AccountInfo($para_db);
		$sql=sprintf("SELECT * from AccountInfo where email='%s'", $para_email);
		$stmt = $para_db->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		foreach($row as $key => $value){
			$user->$key = $value;
		}
		return $user;
	}
	static public function validateUsername($para_username)
	{
		return preg_match("/^[A-Za-z0-9_]{5,16}$/i", $para_username);
	}
	static public function validatePassword($para_password)
	{
		return preg_match("/^[A-Za-z0-9]{6,16}$/i", $para_password);
	}
	static public function isUserNameRepeat($para_username, $para_db)
	{
		$stmt = $para_db->prepare('select username from AccountInfo where username=:name');
		$stmt->execute(array(':name'=>$para_username));
		$row = $stmt->fetchAll();
		return count($row);
	}
}
?>
