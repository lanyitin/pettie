<?php
require_once(CLASS_PATH . DS . "class.Response.php");
require_once(CLASS_PATH . DS . "class.Request.php");
require_once(TPL_CLASS_PATH . "class.TemplateFactory.php");
require_once(PRESENTER_PATH."class.Presenter.php");
require_once(ROOT.DS."functions.php");
require_once(PO_PATH.DS."class.Group.php");
class PresenterCircle extends Presenter
{

	function __construct()
	{	
		parent::__construct();
		$request = new Request("api/member/isLogin");
		$response = $request->execute();
		$this->isLogin = $response->content;
	}

	public function handle_list($parameters)
	{
		$rows = $this->api_list($parameters)->content;
		$tpl = TemplateFactory::getByFilename("CircleList.phtml");
		$tpl->circles = $rows;
		return new Response(0, $tpl);
	}


	public function api_member_list($parameters) {
		$sql = sprintf("select AccountInfo.id from AccountInfo, IN_GROUP where IN_GROUP.mid=AccountInfo.id AND IN_GROUP.gid=%d", $parameters[0]);
		$stmt = $this->db->query($sql);
		$rows = array();
		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
			$rows[] = $row->id;
		}
		return new Response(0, $rows);
	}
	public function api_list($parameters)
	{
		$username = isset($parameters[0])?$parameters[0]:$_SESSION["username"];
		$rows = Group::getListByUsername($username, $this->db);
		return new Response(0, $rows);
	}

	public function handle_create($parameters)
	{
		if(!isset($parameters["name"])){
			$tpl = TemplateFactory::getByFilename("CircleCreate.phtml");
			return new Response(0, $tpl);
		}
		$group = new Group($this->db);
		$group->mid = $_SESSION["id"];
		$group->name = $parameters["name"];
		$group->save();
		redirect("circle/list");
	}

	public function handle_edit($parameters)
	{
		$group = Group::getByName($parameters[0], $this->db);

		if(!isset($parameters["new_name"])){
			$tpl = TemplateFactory::getByFilename("CircleEdit.phtml");
			$tpl->circle = $group;
			return new Response(0, $tpl);
		}
		$group->name = $parameters["new_name"];
		$group->save();
		redirect("circle/list");
	}

	public function handle_delete($parameters)
	{
		$group = Group::getById($parameters[0], $this->db);
		$group->delete();
		header("HTTP/1.0 204 No Content");
		header("Content-Length: 0");
		header('Content-Type: text/html',true);
		flush();
	}

	public function handle_add_user($parameters)
	{
		$group = Group::getById($parameters[0], $this->db);
		$group->addUsers($parameters["users"]);
	}

	public function handle_remove_user($parameters)
	{
		$group = Group::getById($parameters[0], $this->db);
		$group->removeUsers($parameters["users"]);
	}
}
?>
