<?php
require_once(PRESENTER_PATH."class.Presenter.php");
require_once(CLASS_PATH.DS."class.Response.php");
require_once(TPL_CLASS_PATH . "class.TemplateFactory.php");
require_once(PO_PATH . "class.Post.php");
require_once(PO_PATH . "class.PetInfo.php");
require_once(PO_PATH . "class.PetStatus.php");
class PresenterMain extends Presenter
{
	public function handle_index($parameters){
		$request = new Request("api/member/isLogin");
		$response = $request->execute();
		$isLogin = $response->content;
		$isFriend = false;

		if(!$isLogin){
			$indexTpl = TemplateFactory::getByFilename("MemberLogin.phtml");
			return new Response(0, $indexTpl);
		}

		$indexTpl = TemplateFactory::getByFilename("MainIndex.phtml");

		$sb_username = isset($parameters[0])?$parameters[0]:$_SESSION["username"];
		$pet_PetID = isset($_SESSION["PetID"])?$_SESSION["PetID"]:0;
		
		$sb = AccountInfo::getByUsername($sb_username, $this->db);
	
		$request = new Request("api/pet/info/" . $sb_username);
		$response = $request->execute();
		$PET = $response->content;
		$profile = $_SESSION;

		$loginBlock = "Hi {$_SESSION["username"]} <a href=\"".PETTIE_URL."member/logout\">logout</a>";

		$friend_request = new Request("api/friend/list", array($sb_username));
		$friends = $friend_request->execute()->content;
		$myfriend_request = new Request("api/friend/list", array($_SESSION["username"]));
		$myfriends = $myfriend_request->execute()->content;
		foreach($myfriends as $friend){
			if($friend->username == $sb_username){
				$isFriend=true;
			}
		}
		$friendsBlock = TemplateFactory::getByFilename("FriendList.phtml")->render(array("friends"=>$friends));

		$isOwn = $sb_username == $_SESSION["username"];

		$indexTpl->set("loginBlock", $loginBlock); 
		$indexTpl->set("isLogin", $isLogin); 
		$indexTpl->set("friends", $friendsBlock); 
		$indexTpl->set("isOwn", $isOwn); 
		$indexTpl->set("isFriend", $isFriend);
		$indexTpl->set("profile", $profile);
		$indexTpl->set("PetInfo", $PET);
		$indexTpl->set("sb", $sb);

		return new Response(0, $indexTpl);
	}
}
?>
