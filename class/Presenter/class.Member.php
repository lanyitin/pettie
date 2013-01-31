<?php
require_once(CLASS_PATH.DS."class.DataBase.php");
require_once(CLASS_PATH.DS."class.Request.php");
require_once(CLASS_PATH.DS."class.Response.php");
require_once(TPL_CLASS_PATH.DS."class.TemplateFactory.php");
require_once(PO_PATH."class.AccountInfo.php");
require_once(PO_PATH."class.PetInfo.php");
require_once(PRESENTER_PATH."class.Presenter.php");
require_once(ROOT.DS."functions.php");
class PresenterMember extends Presenter
{
	function __construct()
	{	
		parent::__construct();
		if(!isset($_SESSION)){
			session_start();
		}
	}

	protected function handle_register($parameters)
	{
		$r = $this->api_isLogin($parameters);
		if($r->content === true)
		{
			redirect("");
		}
		$result = $this->api_register($parameters);
		if($result->isSuccessed()){
			redirect("member/login/");
		}
		$tpl = TemplateFactory::getByFilename("MemberLogin.phtml");
		return new Response(0,$tpl);
	}

	protected function api_register($parameter)
	{
		if(!isset($_POST["username"]) || !isset($_POST["email"]) || !isset($_POST["password"]) || $_POST["username"]=="" ||$_POST["password"]=="" ||$_POST["email"]=="")
		{
			return new Response(1,"Incomplete infomation");
		}
		if($this->api_isUserNameRepeat(array($_POST["username"]))->content)
		{
			return new Response(2, "Username exists");
		}
		$user = new AccountInfo($this->db);
		$user->username = $_POST["username"];
		$user->password = md5($_POST["password"]);
		$user->email = $_POST["email"];
		$user->save();

		$code = $user->username.":".$user->password;
		$code=base64_encode($code);
		$message="<html><head></head><body>Hi {$_POST['username']}:<br/>Thank you for join us. Click me to active your account:<a href=\"http://pettie.blueunit.info/member/active/{$code}\">{$code}</a></body></html>";
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html;\r\n";
		$subject="Pettie: Active Your Account";
		$mail_result = mail("lanyitin800830@gmail.com", $subject.$_POST["email"], $message, $headers);
		$mail_result = mail($_POST["email"], $subject, $message, $headers);
		if(!$mail_result){
			die("fail to send email to new member");
		}


		return new Response(0, "Successed");
	}

	protected function api_isLogin($parameters)
	{
		$result = (isset($_SESSION["username"]) && $_SESSION["username"] !== "" && $_SESSION["username"] !== null);
		return new Response(0,$result);
	}

	protected function api_isUserNameRepeat($parameters)
	{
		return new Response(0,AccountInfo::isUsernameRepeat($parameters[0], $this->db));
	}

	protected function handle_login($parameters)
	{
		if($this->api_isLogin($parameters)->content)
		{
			redirect("main/index/".$_SESSION["username"]."/");
		}
		$result = $this->api_login($parameters);
		if($result->isSuccessed()){
			redirect("main/index/".$_SESSION["username"]."/");
		}
		$tpl = TemplateFactory::getByFilename("MemberLogin.phtml");
		return new Response(0,$tpl);
	}

	protected function api_login($parameters)
	{
		if(!isset($_POST["username"]) || $_POST["username"] === "" || !isset($_POST["password"]) || $_POST["password"] === "")
		{
			return new Response(1,"Incomplete infomation");
		}
		$user = AccountInfo::getByUsername($_POST['username'],$this->db);
		if($user === null){
			return new Response(1,"Incomplete infomation");
		}
		if($user->password !== md5($_POST['password']))
		{
			return new Response(1,"Incomplete infomation");
		}
		if($user->status != "Actived"){
			return new Response(1,"");
		}
		$_SESSION["username"] = $user->username;
		$_SESSION["password"] = $user->password;
		$_SESSION["id"] = $user->id;
		$_SESSION["email"] = $user->email;
		$_SESSION["status"] = $user->status;
		$_SESSION["privilege"] = $user->privilege;
		$_SESSION["Pic"] = $user->Pic;
		
		$pet = PetInfo::getByUserID($user->id,$this->db);
		if(isset($pet)){
			//$pet = PetInfo::getByUserID($user->id,$this->db);
			$_SESSION["PetID"]=$pet->PetID;
		}
		return new Response(0,true);
	}

	protected function handle_logout($parameters)
	{
		$this->api_logout($parameters);
		redirect("");
		//return new Response(0, true);
	}

	protected function api_logout($parameters)
	{
		session_unset();
		session_destroy();
		return new Response(0,true);
	}

	protected function handle_profile($parameters)
	{
		$result = $this->api_profile($parameters);
		if($result->isSuccessed()){
			$tpl = TemplateFactory::getByFilename("MemberProfile.phtml");
			$tpl->user = $result->content;
			return new Response(0, $tpl);
		}else{
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}

	protected function api_profile($parameters)
	{
		$username = isset($parameters[0])?$parameters[0]:$_SESSION["username"];
		$user = AccountInfo::getByUsername($username, $this->db);
		if($user->id){
			return new Response(0, $user);
		}else{
			return new Response(1, false);
		}
	}

	protected function handle_profile_edit($parameters)
	{    
		if($this->api_isLogin($parameters)->isSuccessed()){
			if($this->api_profile_edit($parameters)->isSuccessed()){
				redirect("main/index/".$_SESSION["username"]."/");
			}else{
				$user = AccountInfo::getById($_SESSION["id"], $this->db);
				$tpl = TemplateFactory::getByFilename("MemberEditProfile.phtml");
				$tpl->email = $user->email;
				$tpl->pic_src = $user->Pic;
				return new Response(0, $tpl);
			}
		}else{
			redirect("member/login/");
		}
	}

	protected function api_profile_edit($parameters)
	{
		if(!isset($_POST["email"]) || $_POST["email"] === ""){
			return new Response(1,"Incomplete infomation");
		}
		$user = AccountInfo::getById($_SESSION["id"], $this->db);
		$user->email = $_POST["email"];
		$user->save();
		$this->api_upload($parameters);
		return new Response(0,true);
	}

	protected function handle_editPassword($parameters)
	{
		if($this->api_isLogin($parameters)->isSuccessed()){
			$result = $this->api_editPassword($parameters);
			if($result->isSuccessed())
			{
				redirect("");
			}else{
				$tpl = TemplateFactory::getByFilename("MemberEditPassword.phtml");
				return new Response(0,$tpl);
			}
		}else{
			redirect("member/login/");
		}
	}

	protected function api_editPassword($parameters)
	{
		if(!isset($_POST["password"]) || !isset($_POST["old_password"]))
		{
			return new Response(1,"Incomplete infomation");
		}
		if(md5($_POST["old_password"]) !== $_SESSION["password"]){
			return new Response(1,"Incomplete infomation");
		}
		$user = AccountInfo::getById($_SESSION["id"], $this->db);
		$user->password = md5($_POST["password"]);
		$user->save();
		return new Response(0,true);
	}
	protected function handle_forget($parameters){
		$result = $this->api_forget($parameters);
		if($result->content === false){
			$tpl = TemplateFactory::getByFilename("MemberForget.phtml");
			return new Response(0,$tpl);
		}elseif(!$result->isSuccessed() && $result->content !== false){
			return new Response(1, $result->content);
		}else{
			redirect("member/login/");
		}
	}

	protected function api_forget($parameters)
	{
		if(isset($_POST["email"])){
			$user = AccountInfo::getByEmail($_POST["email"]);
			if(!$user->id){
				return new Response(1, "¥ç¡æ­¤Email");
			}
			$pw = generateRandomString();
			$user->password = md5($pw);

			$message="<html><head></head><body>Hi {$_POST['username']}, your new password is:{$pw}</body></html>";
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html;\r\n";
			$subject="Pettie Support: About your password";
			mail($_POST["email"], $subject, $message, $headers);
		}else{
			return new Response(1, false);
		}
	}

	protected function handle_active($parameters)
	{
		$result = $this->api_active($parameters);
		if($result->isSuccessed()){
			redirect("");
		}else{
			return new Response(1, $result->content);
		}
	}

	protected function api_active($parameters)
	{
		$code = $parameters[0];
		$code = base64_decode($code);
		list($username, $password) = explode(":", $code);
		$user = AccountInfo::getByUsername($username, $this->db);
		if($user->password == $password){
			$user->active();
			return new Response(0, true);
		}
		return new Response(1, "é©èå¤±æ");
	}
	protected function handle_upload($parameters)
	{		
		$result = $this->api_upload($parameters);
		if($result->isSuccessed())
		{			
			//redirect("");
			return new Response(0,true);
		}else{
			$tpl = TemplateFactory::getByFilename("MemberUpload.phtml");
			return new Response(0,$tpl);
		}			
	}
	
	protected function api_upload($parameters)
	{
		if(isset($_FILES["file"]["name"])){
			$allowedExts = array("jpg", "jpeg", "gif", "png");
			$split = explode(".", $_FILES["file"]["name"]);
			$extension = strtolower (end($split));
			if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/png")
			|| ($_FILES["file"]["type"] == "image/pjpeg"))
			&& in_array($extension, $allowedExts))
			{
				if ($_FILES["file"]["error"] > 0)
				{
					echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
				}
				else
				{
					// 取得上傳圖片
					function imageCreateFromAny($filepath) { 
						$type = exif_imagetype($filepath); // [] if you don't have exif you could use getImageSize() 
						$allowedTypes = array( 
							1,  // [] gif 
							2,  // [] jpg 
							3,  // [] png 
						); 
						if (!in_array($type, $allowedTypes)) { 
							return false; 
						} 
						switch ($type) { 
							case 1 : 
								$im = imageCreateFromGif($filepath); 
							break; 
							case 2 : 
								$im = imageCreateFromJpeg($filepath); 
							break; 
							case 3 : 
								$im = imageCreateFromPng($filepath); 
							break;  
						}    
							return $im;  
					} 
					$src = imageCreateFromAny($_FILES['file']['tmp_name']);
					// 取得來源圖片長寬
					$src_w = imagesx($src);
					$src_h = imagesy($src);

					// 假設要長寬不超過180
					if($src_w>180||$src_h>180){
						if($src_w > $src_h){
							$thumb_w = 180;
							$thumb_h = intval($src_h / $src_w * 180);
						}else{
								$thumb_h = 180;
							$thumb_w = intval($src_w / $src_h * 180);
						}
					}else{
						$thumb_w = 180;
						$thumb_h = 180;
					}
					// 建立縮圖
					$thumb = imagecreatetruecolor($thumb_w, $thumb_h);

					// 開始縮圖
					imagecopyresampled($thumb, $src, 0, 0, 0, 0, $thumb_w, $thumb_h, $src_w, $src_h);
	
					// 儲存縮圖到指定 thumb 目錄
					imagejpeg($thumb, ROOT.DS."images/avator/".$_SESSION["id"].".png"); 
					
					$_SESSION["Pic"] = "images/avator/".$_SESSION["id"].".png";
					if(isset($_SESSION["Pic"])){
						$user = AccountInfo::getById($_SESSION["id"], $this->db);
						$user->Pic = $_SESSION["Pic"];
						$user->save();
					}
					return new Response(0, true);
				}
			}else{
				return new Response(1, "Invalid file");
			}
		}else{
			return new Response(1, false);
		}
		
	}
}
?>
