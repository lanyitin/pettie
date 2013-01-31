<?php
class Group
{
	public $id;
	public $mid;
	public $name;
	private $db;

	function __construct($para_db)
	{
		$this->id = null;
		$this->mid = null;
		$this->name = null;
		$this->db = $para_db;
	}

	public function save()
	{
		if($this->id){
			$sql = sprintf("UPDATE %s SET mid=%d, name=\"%s\" where id=%d", "`Group`", $this->mid, $this->name, $this->id);
			$stmt = $this->db->query($sql);
		}else{
			$lastinsertid = $this->db->lastInsertId();
			$sql = sprintf("INSERT INTO `Group` (mid, name) values (%d, '%s')",$this->mid, $this->name);
			$this->db->query($sql);
			if($this->db->lastInsertId() === $lastinsertid){
				die("Cannot create new Group");
			}
		}
	}

	public function delete()
	{
		$sql = "delete from `Group` where id={$this->id}";
		$this->db->query($sql);

	}

	public function addUsers($parameters)
	{
		$sql = "insert into IN_GROUP (mid, gid) values";
		$values = array();
		if(!is_array($parameters)){
			$parameters = (array)$parameters;
		}
		foreach($parameters as $user){
			$values[] = "({$user},{$this->id})";
		}

		$values = implode(",",$values);
		$sql .=$values;
		$this->db->query($sql);
	}

	public function removeUsers($parameters)
	{
		$sql = "delete from IN_GROUP where gid=%d and mid in (%s)";
		$values = array();
		if(!is_array($parameters)){
			$parameters = (array)$parameters;
		}
		foreach($parameters as $user){
			$values[] = $user;
		}
		$values = implode(",",$values);
		$sql = sprintf($sql,$this->id, $values);
		$this->db->query($sql);
	}

	static public function getById($para_id, $para_db)
	{
		$group = new Group($para_db);
		$sql=sprintf("SELECT `Group`.* from `Group` where `Group`.id=%d", $para_id);
		$stmt = $para_db->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row){
			foreach($row as $key => $value){
				$group->$key = $value;
			}
		}
		return $group;
	}

	static public function getListByUsername($para_groupname, $para_db)
	{
		$sql = sprintf("select `Group`.* from `Group` inner join AccountInfo on Group.mid=AccountInfo.id where AccountInfo.username=\"%s\"", $para_groupname);
		$stmt = $para_db->query($sql);
		$ary = array();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$group = new Group($para_db);
			foreach($row as $key => $value){
				$group->$key = $value;
			}
			$ary[] = $group;
		}
		return $ary;
	}

	static public function getByName($para_name, $para_db)
	{
		$sql = sprintf("select * from `Group` where mid=%d and id=%d", $_SESSION["id"], $para_name);
		$stmt = $para_db->query($sql);
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		$group = new Group($para_db);
		foreach($rows as $key => $value){
			$group->$key = $value;
		}
		return $group;
	}
}
?>
