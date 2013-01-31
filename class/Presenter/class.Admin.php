<?php
require_once(CLASS_PATH . DS . "class.Response.php");
require_once(CLASS_PATH . DS . "class.Request.php");
require_once(TPL_CLASS_PATH . "class.TemplateFactory.php");
require_once(PRESENTER_PATH."class.Presenter.php");
require_once(ROOT.DS."functions.php");
class PresenterAdmin extends Presenter
{
	function __construct(){
		parent::__construct();
		$request = new Request("api/member/isLogin");
		$response = $request->execute();
		$isLogin = json_decode($response)->content;
		if(!$isLogin || !($_SESSION["privilege"] & 64)){
			die("you have not enough privilege to visit this page");
		}
	}

	protected function handle_account_list($parameters)
	{
		$sql = "select * from AccountInfo";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll();
		return new Response(0, json_encode($row));
	}

	protected function handle_account_delete($parameters)
	{
		$sql = "update AccountInfo set status='Disactived' where username='{$parameters[0]}'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll();
		echo $sql;
		redirect("admin/account/list");
	}

}
?>
