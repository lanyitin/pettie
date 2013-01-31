<?php
require_once(CLASS_PATH.DS."class.DataBase.php");
require_once(CLASS_PATH.DS."class.Request.php");
require_once(CLASS_PATH.DS."class.Response.php");
require_once(TPL_CLASS_PATH.DS."class.TemplateFactory.php");
require_once(PO_PATH."class.AccountInfo.php");
require_once(PRESENTER_PATH."class.Presenter.php");
require_once(ROOT.DS."functions.php");
class PresenterNotification extends Presenter
{
	function __construct()
	{	
		parent::__construct();
		if(!isset($_SESSION)){
			session_start();
		}
		$request = new Request("api/member/isLogin");
		$this->isLogin = $request->execute();
	}
	protected function api_message ($parameters)
	{
		$sql = sprintf("select Post.*, AccountInfo.username as who_reply, Comment.content as reply_msg, Notifications.id as nid from Post, Post as Comment, Notifications, AccountInfo where AccountInfo.id=Comment.mid and Notifications.mid=%d and Comment.id=Notifications.pid and Comment.reply=Post.id", $_SESSION["id"]);
		$stmt = $this->db->query($sql);
		$notifications = array();
		while($notif = $stmt->fetch(PDO::FETCH_OBJ)) {
			$notifications[] = $notif;
		}
		return new Response(0, $notifications);
	}
	protected function api_msg_delete($parameters) {
		$sql = sprintf("delete from Notifications where id=%d", $parameters[0]);
		$this->db->query($sql);
		header("HTTP/1.0 204 No Content");
		header("Content-Length: 0");
		header('Content-Type: text/html',true);
		flush();
	}
}
?>
