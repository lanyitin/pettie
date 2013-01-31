<?php
class PetInfo
{
	public $UserID;
	public $PetID;
	public $Name;
	public $Birthday;
	public $Gender;
	public $father;
	public $mother;
	public $Spouse;
	public $Birthplace;
	public $Introduction;	
	private $db;
	
	function __construct($para_db)
	{
		$this->UserID=null;
		$this->PetID=null;
		$this->Name=null;
		$this->Birthday=null;
		$this->Gender=null;
		$this->father='Designer';
		$this->mother='Designer';
		$this->Spouse='無';
		$this->Birthplace='寵物星球';
		$this->Introduction=null;
		$this->db = $para_db;
	}
	
	public function save()
	{
		if(!self::validateName($this->Name)){
			die("The validation of Name was failed");
		}
		if($this->PetID){
			$sql = sprintf("UPDATE %s SET Name=\"%s\", father=\"%s\", mother=\"%s\", Spouse=\"%s\", Birthplace=\"%s\", Introduction=\"%s\" where PetID=%d", "PetInfo", $this->Name, $this->father ,$this->mother, $this->Spouse, $this->Birthplace, $this->Introduction, $this->PetID);
			$stmt = $this->db->query($sql);
		}else{
			$lastinsertid = $this->db->lastInsertId();
			$sql = sprintf("INSERT INTO PetInfo (UserID, Name, Gender, Introduction) values ('%s', '%s', '%d', '%s')",$this->UserID, $this->Name, $this->Gender, $this->Introduction);
			$this->db->query($sql);
			if($this->db->lastInsertId() === $lastinsertid){
				die("Cannot create new Pet");
			}
		}
	}
	
	static public function getByPetID($para_PetID, $para_db)
	{
		$pet = new PetInfo($para_db);
		$sql=sprintf("SELECT * from PetInfo where PetID=%d", $para_PetID);
		$stmt = $para_db->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row){
			foreach($row as $key => $value){
				$pet->$key = $value;
			}
		}
		return $pet;
	}
	static public function getByUserID($para_UserID, $para_db)
	{
		$pet = new PetInfo($para_db);
		$sql=sprintf("SELECT * from PetInfo where UserID='%d'", $para_UserID);
		$stmt = $para_db->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row){
			foreach($row as $key => $value){
				$pet->$key = $value;
			}
		}
		return $pet;
	}

	static public function validateName($para_Name)
	{
		//return preg_match("/^[A-Za-z0-9_]{5,16}$/i", $para_Name);
		return true;
	}

}
?>
