<?php
require_once(CLASS_PATH . DS . "class.Response.php");
require_once(CLASS_PATH . DS . "class.Request.php");
require_once(TPL_CLASS_PATH . "class.TemplateFactory.php");
require_once(PRESENTER_PATH."class.Presenter.php");
require_once(ROOT.DS."functions.php");
require_once(PO_PATH."class.AccountInfo.php");
class PresenterFriend extends Presenter
{
	function __construct()
	{
		parent::__construct();
		$request = new Request("api/member/isLogin");
		$response = $request->execute();
		$this->isLogin = $response->content;
		if(!$this->isLogin){
			redirect("member/login");
		}

	}
	protected function api_list($parameters)
	{
		$userid=isset($parameters[0])?$parameters[0]:$_SESSION["username"];
		$sql = sprintf("select AccountInfo.* from AccountInfo, (select Relationship.mid2 as id from Relationship, AccountInfo where Relationship.mid1=AccountInfo.id and AccountInfo.username=\"%s\" and Relationship.status=\"Comfirmed\" UNION select Relationship.mid1 as id from Relationship,AccountInfo where Relationship.mid2=AccountInfo.id and AccountInfo.username=\"%s\" and Relationship.status=\"Comfirmed\") as FriendInfo where AccountInfo.id=FriendInfo.id", $userid, $userid);
		$stmt = $this->db->query($sql);
		$list = $stmt->fetchAll(PDO::FETCH_CLASS);
		return new Response(0, $list);
	}

	protected function api_list_pendding($parameters)
	{
		$sql = sprintf("select AccountInfo.*, FriendInfo.isSend from AccountInfo, (select Relationship.mid2 as id, true as isSend from Relationship, AccountInfo where Relationship.mid1=AccountInfo.id and AccountInfo.id=%d and Relationship.status=\"Pendding\" UNION select Relationship.mid1 as id, false as isSend from Relationship,AccountInfo where Relationship.mid2=AccountInfo.id and AccountInfo.id=%d and Relationship.status=\"Pendding\") as FriendInfo where AccountInfo.id=FriendInfo.id", $_SESSION["id"], $_SESSION["id"]);
		$stmt = $this->db->query($sql);
		$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return new Response(0, $list);
	}

	protected function handle_group($parameters)
	{
		$sql = sprintf("SELECT * FROM `Group` inner join IN_GROUP on `Group`.id=IN_GROUP.gid inner join AccountInfo on AccountInfo.id=IN_GROUP.mid where `Group`.id=\"%d\"", $parameters[0]);
		$stmt = $this->db->query($sql);
		$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return new Response(0, $list);
	}

	protected function handle_add($parameters)
	{
		$sql = sprintf("select id from AccountInfo where username=\"%s\"", $parameters[0]);
		$stmt = $this->db->query($sql);
		$id = $stmt->fetch(PDO::FETCH_ASSOC);
		$id = $id["id"];
		$sql = sprintf("insert into Relationship(mid1, mid2) values (%d, %d)", $_SESSION["id"], $id);
		$stmt = $this->db->query($sql);
		//$sql = sprintf("insert into Notifications (mid, type) values (%d, 0)", $id);
		//$stmt = $this->db->query($sql);
		//$theId = $this->db->lastInsertId();
		//$sql = sprintf("insert into Notifications_Friend (nid, mid1, mid2) values (%d, %d, %d)", $theId, $_SESSION["id"], $id);
		//$stmt = $this->db->query($sql);
	}
	protected function handle_confirm($parameters)
	{
		$sql = sprintf("update Relationship set status=\"Comfirmed\" where mid2=%d and mid1=(select id from AccountInfo where username=\"%s\")", $_SESSION["id"], $parameters[0]);
		$this->db->query($sql);
		$sql = sprintf("delete from Relationship where mid1=%d and mid2=(select id from AccountInfo where username=\"%s\")", $_SESSION["id"], $parameters[0]);
		$stmt = $this->db->query($sql);
		header("HTTP/1.0 204 No Content");
		header("Content-Length: 0");
		header('Content-Type: text/html',true);
		flush();
	}

	protected function handle_deny($parameters)
	{
		$sql = sprintf("delete from Relationship where mid2=%d and mid1=(select id from AccountInfo where username=\"%s\")", $_SESSION["id"], $parameters[0]);
		$stmt = $this->db->query($sql);
		$sql = sprintf("delete from Relationship where mid1=%d and mid2=(select id from AccountInfo where username=\"%s\")", $_SESSION["id"], $parameters[0]);
		$stmt = $this->db->query($sql);
		header("HTTP/1.0 204 No Content");
		header("Content-Length: 0");
		header('Content-Type: text/html',true);
		flush();
	}

	protected function handle_cancel($parameters)
	{
		$sql = sprintf("delete from Relationship where mid1=%d and mid2=(select id from AccountInfo where username=\"%s\")", $_SESSION["id"], $parameters[0]);
		$stmt = $this->db->query($sql);
		$sql2 = sprintf("delete from Relationship where mid2=%d and mid1=(select id from AccountInfo where username=\"%s\")", $_SESSION["id"], $parameters[0]);
		$stmt = $this->db->query($sql2);
		header("HTTP/1.0 204 No Content");
		header("Content-Length: 0");
		header('Content-Type: text/html',true);
		flush();
	}
	protected function handle_delete($parameters)
	{
		$sql = sprintf("delete from Relationship where mid1=%d and mid2=(select id from AccountInfo where username=\"%s\")", $_SESSION["id"], $parameters[0]);
		$stmt = $this->db->query($sql);
		$sql2 = sprintf("delete from Relationship where mid2=%d and mid1=(select id from AccountInfo where username=\"%s\")", $_SESSION["id"], $parameters[0]);
		$stmt = $this->db->query($sql2);
		header("HTTP/1.0 204 No Content");
		header("Content-Length: 0");
		header('Content-Type: text/html',true);
		flush();
	}
	protected function handle_search($parameters)
	{
		$friends = array();
		if (isset($parameters[0])) {
			$sql = sprintf("select * from AccountInfo where username like \"%%%s%%\"", $parameters[0]);
			$stmt = $this->db->query($sql);
			while($row = $stmt->fetch(PDO::FETCH_OBJ)){
				$friends[] = $row;
			}
		}
		$tpl = TemplateFactory::getByFilename("Searchfriendlist.phtml");
		$tpl->set("friends", $friends);
		return new Response(0, $tpl);
	}
}
?>
