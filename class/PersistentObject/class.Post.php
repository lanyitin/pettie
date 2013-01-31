<?php
require_once("class.Abstract.PersistentObj.php");
class Post extends PersistentObj
{
	const TABLE_NAME = "Post";
	const entry_sql = "SELECT Post.*, AccountInfo.username as owner, AccountInfo.Pic as Pic from Post inner join AccountInfo on Post.mid=AccountInfo.id";
	const who_likes_sql = "SELECT GROUP_CONCAT(DISTINCT mid SEPARATOR ',') as who_likes from LIKE_POST WHERE pid=%d";
	public $id;
	public $mid;
	public $content;
	public $type;
	public $time;
	public $reply;
	public $popular;
	public $owner;
	public $who_likes;
	public $Pic;
	private $db;
	function __construct($para_db)
	{
		$this->id = null;
		$this->mid = null;
		$this->content = null;
		$this->type = null;
		$this->time = null;
		$this->reply = null;
		$this->popular = 0;
		$this->owner = null;
		$this->who_likes = null;
		$this->db = $para_db;
		$this->Pic = null;
	}
	public function save()
	{
		if($this->id){
			$sql = sprintf("UPDATE %s SET content=\"%s\", type=\"%s\"  WHERE id=\"%s\"", "".self::TABLE_NAME."", $this->content, $this->type, $this->id);
			$this->db->query($sql);
		}else{
			$lastinsertid = $this->db->lastInsertId();
			$sql = sprintf("INSERT INTO %s (mid, content, type, reply) VALUES ('%s', '%s', '%s', '%s')","".self::TABLE_NAME."", $this->mid, $this->content, $this->type, $this->reply);
			$this->db->query($sql);
			$new_lastinsertid = $this->db->lastInsertId();
			if($new_lastinsertid === $lastinsertid){
				die("Cannot create new post");
			}
			$this->id = $new_lastinsertid;
			if ($this->reply != 0 || $this->reply != null) {
				$sql = sprintf("insert into Notifications (mid, pid)  select Post.mid as mid, %d as pid from Post where id =%d",$this->id, $this->reply);
				$this->db->query($sql);
			}
		}
	}

	public function initWithArray($para_ary)
	{
		foreach($para_ary as $key => $value){
			if($key==="who_likes"){
				$list = explode(",", $value);
				if($list[0] == null){
					unset($list[0]);
				}
				$this->$key = $list;
				$this->popular = count($list);
			}else{
				$this->$key = $value;
			}
		}
	}
	public function delete($para_db)
	{
		$sql=sprintf("delete  from ".self::TABLE_NAME." WHERE id=%d", $this->id);
		$stmt = $para_db->query($sql);
	}
	static public function getById($para_id, $para_db)
	{
		$post = new Post($para_db);
		$sql=sprintf(self::entry_sql." WHERE ".self::TABLE_NAME.".id=%d", $para_id);
		$stmt = $para_db->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row){
			$post->initWithArray($row);
		}
		return $post;
	}

	static public function getReadedListByUserIds($para_id, $para_db)
	{
		if(gettype($para_id) == "array"){
			$para_id = implode(",", $para_id);
		}
		$sql=sprintf(self::entry_sql." WHERE AccountInfo.id in (%s) AND ".self::TABLE_NAME.".reply=0 and Post.id in (SELECT pid from READ_POST) ORDER BY ".self::TABLE_NAME.".time ASC", $para_id);
		$stmt = $para_db->query($sql);
		return self::getListBySqlstmt($stmt, $para_db);
	}

	static public function getUnreadedListByUserIds($para_id, $para_db)
	{
		if(gettype($para_id) == "array"){
			$para_id = implode(",", $para_id);
		}
		$sql=sprintf(self::entry_sql." WHERE AccountInfo.id in (%s) AND ".self::TABLE_NAME.".reply=0 and Post.id not in (SELECT pid from READ_POST) ORDER BY ".self::TABLE_NAME.".time ASC", $para_id);
		$stmt = $para_db->query($sql);
		return self::getListBySqlstmt($stmt, $para_db);
	}

	static public function getListByUsername($para_id, $para_db)
	{
		$sql=sprintf(self::entry_sql." WHERE AccountInfo.username=\"%s\" AND ".self::TABLE_NAME.".reply=0 ORDER BY ".self::TABLE_NAME.".time ASC", $para_id);
		$stmt = $para_db->query($sql);
		return self::getListBySqlstmt($stmt, $para_db);
	}

	static public function getUnreadListByUsername($para_id, $para_db)
	{
		$sql=sprintf(self::entry_sql." WHERE AccountInfo.username=\"%s\" AND ".self::TABLE_NAME.".reply=0 and Post.id not in (SELECT pid from READ_POST) ORDER BY ".self::TABLE_NAME.".time ASC", $para_id);
		$stmt = $para_db->query($sql);
		return self::getListBySqlstmt($stmt, $para_db);
	}

	static public function getCommentsByPostIds($para_ids, $para_db)
	{
		if(is_array($para_ids)){
			$para_ids = implode(",", $para_ids);
		}
		$ary = array();
		if($para_ids !== ""){
			$sql = sprintf(self::entry_sql." WHERE ".self::TABLE_NAME.".reply in (%s) ORDER BY ".self::TABLE_NAME.".time ASC", $para_ids);
			$stmt = $para_db->query($sql);
			$ary = self::getListBySqlstmt($stmt, $para_db);
		}
		return $ary;
	}

	static public function getByGroupid($para_id, $para_db)
	{
		#$memberlist_req = new Request("api/circle/member/list" + $para_id + "/", array());
		#$memberids = $memberlist_req->execute()->content;
		$sql = sprintf("SELECT AccountInfo.id from AccountInfo, IN_GROUP WHERE IN_GROUP.gid=%d AND IN_GROUP.mid=AccountInfo.id", $para_id);
		$stmt = $para_db->query($sql);
		$memberids = array();
		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
			$memberids[] = $row->id;
		}
		$memberids = implode(",", $memberids);
		$sql = sprintf(self::entry_sql . " WHERE reply=0 AND mid in (%s)", $memberids);
		$stmt = $para_db->query($sql);
		return self::getListBySqlstmt($stmt, $para_db);
	}

	static public function getLikedList($para_username, $para_db)
	{
		$sql = sprintf(self::entry_sql . " WHERE ".self::TABLE_NAME.".id in (SELECT LIKE_POST.pid from LIKE_POST WHERE mid=(SELECT id from AccountInfo WHERE username=\"%s\")) ORDER BY ".self::TABLE_NAME.".time ASC", $para_username);
		$stmt = $para_db->query($sql);
		return self::getListBySqlstmt($stmt, $para_db);
	}
	static public function getUnreadLiked($para_username, $para_db)
	{
		$sql = sprintf(self::entry_sql . " WHERE ".self::TABLE_NAME.".id in (SELECT LIKE_POST.pid from LIKE_POST WHERE mid=(SELECT id from AccountInfo WHERE username=\"%s\") AND ".self::TABLE_NAME.".reply=0 and Post.id not in (SELECT pid from READ_POST)) ORDER BY ".self::TABLE_NAME.".time ASC", $para_username);
		$stmt = $para_db->query($sql);
		return self::getListBySqlstmt($stmt, $para_db);
	}
	static public function getListBySearch($para_keyword, $para_db)
	{
		$sql = sprintf(self::entry_sql . " WHERE Post.content like \"%%%s%%\" ORDER BY ".self::TABLE_NAME.".time ASC", $para_keyword, $para_keyword);
		$stmt = $para_db->query($sql);
		return self::getListBySqlstmt($stmt, $para_db);
	}
	static public function getListBySearchUsername($para_keyword, $para_db)
	{
		$sql = sprintf(self::entry_sql . " WHERE AccountInfo.username like \"%%%s%%\" ORDER BY ".self::TABLE_NAME.".time ASC", $para_keyword, $para_keyword);
		$stmt = $para_db->query($sql);
		return self::getListBySqlstmt($stmt, $para_db);
	}

	static private function getListBySqlStmt($stmt, $para_db)
	{
		$ary = array();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$post = new Post($para_db);
			$post->initWithArray($row);
			$likes_sql = sprintf(self::who_likes_sql, $post->id);
			$likes_stmt = $para_db->query($likes_sql);
			$likes_row = $likes_stmt->fetch(PDO::FETCH_ASSOC);
			$post->initWithArray($likes_row);
			$ary[] = $post;
		}
		return $ary;
	}
}
?>
