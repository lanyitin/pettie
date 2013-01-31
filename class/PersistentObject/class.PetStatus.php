<?php
class PetStatus
{
	public $idx;
	public $PetID;
	public $type;
	public $currentExperience;
	public $requiredExperience;
	public $level;
	public $status;
	public $health;
	public $satiation;
	public $cleanliness;
	public $excreta;
	public $needClean;
	public $injectionC;
	public $feedC;
	private $db;
	
	function __construct($para_db)
	{
		$this->idx = null;
		$this->PetID=null;
		$this->type=null;
		$this->currentExperience=0;
		$this->requiredExperience=10;
		$this->level=0;
		$this->status='健康';
		$this->health=100;
		$this->satiation=30;
		$this->cleanliness=30;
		$this->excreta=5;
		$this->needClean = 0;
		$this->injectionC=3;
		$this->feedC=20;
		$this->db = $para_db;
	}
	
	public function save()
	{
		
		if($this->idx){
			$sql =sprintf("UPDATE %s SET currentExperience=\"%d\", requiredExperience=\"%d\", level=\"%d\", status=\"%s\", health=\"%f\", satiation=\"%d\", cleanliness=\"%d\", excreta=\"%d\", needClean=\"%d\", injectionC=\"%d\", feedC=\"%d\" where PetID=%d", "PetStatus", $this->currentExperience, $this->requiredExperience, $this->level, $this->status, $this->health, $this->satiation, $this->cleanliness, $this->excreta, $this->needClean, $this->injectionC, $this->feedC, $this->PetID);
			$stmt = $this->db->query($sql);
		}else{
			$lastinsertid = $this->db->lastInsertId();
			$sql = sprintf("INSERT INTO PetStatus (PetID, type) values (\"%d\", '%s')",$this->PetID, $this->type);
			$this->db->query($sql);
			if($this->db->lastInsertId() === $lastinsertid){
				die("Cannot create new Pet");
			}
		}
	}
	
	static public function getByPetID($para_PetID, $para_db)
	{
		$petStatus = new PetStatus($para_db);
		$sql=sprintf("SELECT * from PetStatus where PetID=%d", $para_PetID);
		$stmt = $para_db->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row){
			foreach($row as $key => $value){
				$petStatus->$key = $value;
			}
		}
		return $petStatus;
	}
	
}
?>
