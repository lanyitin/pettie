<?php
require_once(CLASS_PATH.DS."class.DataBase.php");
require_once(CLASS_PATH.DS."class.Request.php");
require_once(CLASS_PATH.DS."class.Response.php");
require_once(TPL_CLASS_PATH.DS."class.TemplateFactory.php");
require_once(PO_PATH."class.AccountInfo.php");
require_once(PRESENTER_PATH."class.Presenter.php");
require_once(ROOT.DS."functions.php");
class PresenterGame extends Presenter
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
	
	protected function handle_catch($parameters)
	{
		if($this->isLogin){
			$tpl = TemplateFactory::getByFilename("catch.html");

			return new Response(0,$tpl);
		}else{
			redirect("member/login/");
		}
	}
	
	protected function handle_guess($parameters)
	{
		if($this->isLogin){
			$tpl = TemplateFactory::getByFilename("guess.phtml");

			return new Response(0,$tpl);
		}else{
			redirect("member/login/");
		}
	}
	
	protected function handle_guessPic($parameters)
	{
		if($this->isLogin){
			$tpl = TemplateFactory::getByFilename("guessPic.phtml");

			return new Response(0,$tpl);
		}else{
			redirect("member/login/");
		}
	}
	protected function handle_gameList($parameters)
	{
		if($this->isLogin){
			$tpl = TemplateFactory::getByFilename("GameList.phtml");

			return new Response(0,$tpl);
		}else{
			redirect("member/login/");
		}
	}

}
?>
