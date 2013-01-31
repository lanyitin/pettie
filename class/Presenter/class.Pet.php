<?php
require_once(CLASS_PATH.DS."class.DataBase.php");
require_once(CLASS_PATH.DS."class.Request.php");
require_once(CLASS_PATH.DS."class.Response.php");
require_once(TPL_CLASS_PATH.DS."class.TemplateFactory.php");
require_once(PO_PATH."class.AccountInfo.php");
require_once(PO_PATH."class.PetInfo.php");
require_once(PO_PATH."class.PetStatus.php");
require_once(PRESENTER_PATH."class.Presenter.php");
require_once(ROOT.DS."functions.php");
class PresenterPet extends Presenter
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
	//認養
	protected function api_adopt($parameters)
	{
		if($parameters[0]===$_SESSION["username"]){
			$petStatus  = PetStatus::getByPetID($_SESSION["PetID"], $this->db);
			if($petStatus->PetID ===null){
				if(isset($_SESSION["id"]) && isset($_POST["Name"]) && isset($_POST["Gender"]) && isset($_POST["introduction"]) && isset($_POST["Type"])){
					$check=true;
					if($_POST["Name"]===""){
						$check = false;
						return new Response(1, "Please enter the Name.");					
					}
					if($_POST["Gender"]===""){
						$check = false;
						return new Response(1, "Please select the Gender.");
					}
					if($_POST["introduction"]==="" || $_POST["Type"]===""){
						$check = false;
						return new Response(1, "Please select the Pet.");
					}

					if($check){
						$this->db->beginTransaction();
						$pet = new PetInfo($this->db);
						$pet->UserID = $_SESSION["id"];
						$pet->Name = $_POST["Name"];
						$pet->Gender = $_POST["Gender"];
						$pet->Introduction = $_POST["introduction"];
						$pet->save();

						$sql = sprintf("select PetID From PetInfo Where UserID = \"%d\"",$_SESSION["id"]);
						$stmt = $this->db->query($sql) or die($stmt->error());
						$petid = $stmt->fetch(PDO::FETCH_BOTH);

						$petStatus = new PetStatus($this->db);
						$petStatus->PetID = $petid["PetID"];
						$petStatus->type = $_POST["Type"];
						$petStatus->save();
						$this->db->commit();
						$_SESSION["PetID"]= $petid["PetID"];
						$row =$this->api_info($parameters);
						return new Response(0,$row);

					}				
				}else{
					return new Response(1,false);
				}
			}else{
				return new Response(1,"You already have your own pet.");
			}
		}
	}
	protected function api_exercise($parameters){
		if(isset($_SESSION["PetID"])){

			$petStatus  = PetStatus::getByPetID($_SESSION["PetID"], $this->db);
			if($petStatus->health >= 30){
				
				$petStatus->currentExperience = $petStatus->currentExperience + $parameters[0];				
				if($petStatus->satiation>=1){
					$petStatus->satiation--;
				}else{
					$petStatus->satiation =0;
				}
				if($petStatus->cleanliness>=1){
					$petStatus->cleanliness--;
				}else{
					$petStatus->cleanliness=0;
				}
				$petStatus->health = floor(($petStatus->satiation * 5 ) / 3 + ($petStatus->cleanliness * 5 ) / 3);
				$petStatus->save();
				$this->api_changeStatus($parameters);

				$this->api_upgrade($parameters);
				print_r("currentExperience:".$petStatus->currentExperience."<br/>id:".$_SESSION["PetID"]);
				$row =$this->api_info($parameters);
				header("HTTP/1.0 204 No Content");
				header("Content-Length: 0");
				header('Content-Type: text/html',true);
				flush();
			}else{
				return new Response(1,"Your Pet is too weak to do execise.");
			}
		}else{
			return new Response(1, "No Pet to do execise");

		}
	}
	
	//升等
	protected function api_upgrade($parameters){
		if(isset($_SESSION["PetID"])){
			$petStatus2  = PetStatus::getByPetID($_SESSION["PetID"], $this->db);
			if($petStatus2->currentExperience >= $petStatus2->requiredExperience){
				$petStatus2->currentExperience = $petStatus2->currentExperience - $petStatus2->requiredExperience;
				$petStatus2->level = $petStatus2->level + 1;
				$petStatus2->requiredExperience = 10 + pow(2,$petStatus2->level);										
				$petStatus2->save();
				header("HTTP/1.0 204 No Content");
				header("Content-Length: 0");
				header('Content-Type: text/html',true);
				flush();
			}
		}else{
			return new Response(1, "No Pet to upgrade");
		}

	}

	//打針
	protected function api_injection($parameters){
		if(isset($_SESSION["PetID"])){
			$check=True;
			if($parameters[0]===$_SESSION["username"]){
				
				$petStatus = PetStatus::getByPetID($_SESSION["PetID"], $this->db);

				if($petStatus->health >= 30){
					$check=False;
					return new Response(1,"Your pet is healthy.");
				}
				if($petStatus->injectionC <= 0){
					$check=False;
					return new Response(1,"Your injections insufficiently.");
				}
				if($check){	
					//$petStatus->status = '健康';
					$petStatus->satiation = 15;
					$petStatus->cleanliness = 15;
					if($petStatus->injectionC >= 1){
						$petStatus->injectionC--;
					}else{
						$petStatus->injectionC=0;
					}
					$petStatus->health = floor(($petStatus->satiation * 5 ) / 3 + ($petStatus->cleanliness * 5 ) / 3);
					$petStatus->save();
					$this->api_changeStatus($parameters);

					return new Response(0, true);
				}
			}else{
				$target = AccountInfo::getByUsername($parameters[0],$this->db);
				$pet = PetInfo::getByUserID($target->id,$this->db);
				$petStatus =PetStatus::getByPetID($pet->PetID, $this->db);
				$self_petStatus =PetStatus::getByPetID($_SESSION["PetID"], $this->db);
				
				if($petStatus->health >= 30){
					$check=False;
					return new Response(1,"Your pet is healthy.");
				}
				if($self_petStatus->injectionC <= 0){
					$check=False;
					return new Response(1,"Your injections insufficiently.");
				}
				if($check){	
					$petStatus->status = '健康';
					$petStatus->satiation = 15;
					$petStatus->cleanliness = 15;
					if($petStatus->injectionC>=1){
						$self_petStatus->injectionC--;
					}else{
						$self_petStatus->injectionC = 0 ;
					}
					$petStatus->health = floor(($petStatus->satiation * 5 ) / 3 + ($petStatus->cleanliness * 5 ) / 3);
					$petStatus->save();
					$self_petStatus->save();
					$this->api_changeStatus($parameters);
					return new Response(0, true);
				}
			}
		}else{
			return new Response(1, "No Pet to injection");	
		}
	}
	//清掃
	protected function api_clean($parameters){
		if($parameters[0]===$_SESSION["username"]){
			$petStatus =PetStatus::getByPetID($_SESSION["PetID"], $this->db);
		}else{
			$target = AccountInfo::getByUsername($parameters[0],$this->db);
			$pet = PetInfo::getByUserID($target->id,$this->db);
			$petStatus =PetStatus::getByPetID($pet->PetID, $this->db);
		}
		
		if($petStatus->cleanliness < 30 && $petStatus->needClean > 0){

			if($petStatus->cleanliness<=25){
				$petStatus->cleanliness = $petStatus->cleanliness + 5;
			}else{
				$petStatus->cleanliness=30;
			}
			if($petStatus->needClean>=1){
				$petStatus->needClean--;
			}else{
				$petStatus->needClean =0;
			}
			$petStatus->health = floor(($petStatus->satiation * 5 ) / 3 + ($petStatus->cleanliness * 5 ) / 3);
			$petStatus->save();
			$this->api_changeStatus($parameters);
			header("HTTP/1.0 204 No Content");
			header("Content-Length: 0");
			header('Content-Type: text/html',true);
			flush();

		}else{
			return new Response(1, "No excreta to clean.");
		}
	}
	//餵食
	protected function api_feed($parameters){
		$check=true;
		if($parameters[0]===$_SESSION["username"]){//自己寵物
			$petStatus =PetStatus::getByPetID($_SESSION["PetID"], $this->db);
			if($petStatus->satiation >= 30 ){
				return new Response(1, "Your pet is satiate");
				$check=false;
			}
			if($petStatus->feedC <= 0){
				return new Response(1, "The numbers of feeding is not enough.");
				$check=false;
			}
				
			if($check){
				if($petStatus->satiation<=27){
					$petStatus->satiation= $petStatus->satiation + 3;
				}else{
					$petStatus->satiation = 30;
				}
				//確認便便數量
				if($petStatus->excreta<=8){
					$petStatus->excreta = $petStatus->excreta + 2;
				}else{
					$petStatus->excreta = 10;
				}

				$petStatus->feedC--;
				$petStatus->health = floor(($petStatus->satiation * 5 ) / 3 + ($petStatus->cleanliness * 5 ) / 3);
				$petStatus->save();
				$this->api_changeStatus($parameters);

				return new Response(0, true);

			}
		}else{//他人寵物
			$target = AccountInfo::getByUsername($parameters[0],$this->db);
			$pet = PetInfo::getByUserID($target->id,$this->db);
			$petStatus =PetStatus::getByPetID($pet->PetID, $this->db);
			$self_petStatus =PetStatus::getByPetID($_SESSION["PetID"], $this->db);
			
			if($petStatus->satiation >= 30 ){
				return new Response(1, "Pet is satiate");
				$check=false;
			}
			if($self_petStatus->feedC < 0){
				return new Response(1, "The numbers of feeding is not enough.");
				$check=false;
			}
				
			if($check){
				if($petStatus->satiation<=27){
					$petStatus->satiation= $petStatus->satiation + 3;
				}else{
					$petStatus->satiation = 30;
				}
				//確認便便數量
				if($petStatus->excreta<=8){
					$petStatus->excreta = $petStatus->excreta + 2;
				}else{
					$petStatus->excreta = 10;
				}

				$self_petStatus->feedC--;//減自身餵食次數
				$petStatus->health = floor(($petStatus->satiation * 5 ) / 3 + ($petStatus->cleanliness * 5 ) / 3);
				$petStatus->save();
				$self_petStatus->save();
				$this->api_changeStatus($parameters);

				return new Response(0, true);
			}
		}		
	}
	//排便
	protected function api_drain($parameters){
		if($parameters[0]===$_SESSION["username"]){//自己寵物
			$petStatus = PetStatus::getByPetID($_SESSION["PetID"], $this->db);
		}else{//他人寵物
			$target = AccountInfo::getByUsername($parameters[0],$this->db);
			$pet = PetInfo::getByUserID($target->id,$this->db);
			$petStatus =PetStatus::getByPetID($pet->PetID, $this->db);
		}
		
		if($petStatus->excreta > 0){
			$petStatus->excreta--;
			if($petStatus->needClean<=9){
				$petStatus->needClean++;				
			}else{
				$petStatus->needClean = 10;
			}
			if($petStatus->cleanliness >= 1){
				$petStatus->cleanliness = $petStatus->cleanliness - 1 ;
			}else{
				$petStatus->cleanliness = 0 ;
			}
			$petStatus->health = floor(($petStatus->satiation * 5 ) / 3 + ($petStatus->cleanliness * 5 ) / 3);
			$petStatus->save();
			$this->api_changeStatus($parameters);

			return new Response(0, true);
		}else{
			return new Response(1, "no excreta");
		}

	}
	
	protected function api_changeStatus($parameters){
		if($parameters[0]===$_SESSION["username"]){//自己寵物
			$petStatus = PetStatus::getByPetID($_SESSION["PetID"], $this->db);
		}else{//他人寵物
			$target = AccountInfo::getByUsername($parameters[0],$this->db);
			$pet = PetInfo::getByUserID($target->id,$this->db);
			$petStatus =PetStatus::getByPetID($pet->PetID, $this->db);
		}
		$check = true;
		if($petStatus->satiation < 10){
			$petStatus->status = "餓";
			$check = false;
		}
		if($petStatus->cleanliness < 10){
			$petStatus->status = "髒";
			$check = false;			
		}
		if($petStatus->health < 30 && $petStatus->health >0){
			$petStatus->status = "生病";
			$check = false;
		}
		if($petStatus->health <= 0){
			$petStatus->status = "死亡";
			$check = false;
		}	
		if($check){
			$petStatus->status = "健康";			
		}
		$petStatus->save();
		
	}
	//death
	protected function api_death($parameters)
	{
		if($parameters[0]===$_SESSION["username"]){//自己寵物
			$petStatus = PetStatus::getByPetID($_SESSION["PetID"], $this->db);
			$pet=PetInfo::getByPetID($_SESSION["PetID"], $this->db);
		}else{//他人寵物
			$target = AccountInfo::getByUsername($parameters[0],$this->db);
			$pet = PetInfo::getByUserID($target->id,$this->db);
			$petStatus =PetStatus::getByPetID($pet->PetID, $this->db);
		}
		if($petStatus->status=="死亡" || $petStatus->health <= 0){
			$stmt = $this->db->prepare("DELETE FROM PetInfo WHERE PetID =?");
			$stmt->bindValue(1,$pet->PetID,PDO::PARAM_STR);
			$stmt->execute() or die(print_r($this->db->errorInfo()));
			return new Response(0, true);
		}
		return new Response(1, false);
	}

	protected function api_info($parameters) {
		$user = AccountInfo::getByUsername($parameters[0], $this->db);
		$sql = sprintf("select PetInfo.*, PetStatus.* from PetInfo, PetStatus, AccountInfo where PetInfo.UserID=AccountInfo.id AND PetStatus.PetID=PetInfo.PetID AND AccountInfo.id=%d", $user->id);
		$stmt = $this->db->query($sql);
		$row = $stmt->fetch(PDO::FETCH_OBJ);
		return new Response(0,$row);
	}
	protected function handle_PetInfo($parameters){
		$user = AccountInfo::getByUsername($parameters[0], $this->db);
		$request = new Request("api/pet/info/" . $parameters[0] . "/");
		$response = $request->execute();
		$PET = $response->content;
		$tpl = TemplateFactory::getByFilename("PetInfo.phtml");
		$tpl->set("PetInfo", $PET);
		$tpl->email = $user->email;
		return new Response(0,$tpl); 
	}
	
	protected function api_pet_edit($parameters)
	{
		if(!isset($_POST["father"]) || $_POST["father"] === ""||!isset($_POST["mother"]) || $_POST["mother"] === ""||
		  !isset($_POST["Spouse"]) || $_POST["Spouse"] === ""||!isset($_POST["Birthplace"]) || $_POST["Birthplace"] === ""||
		  !isset($_POST["Introduction"]) || $_POST["Introduction"] === ""){
			return new Response(1,"Incomplete infomation");
		}
		$pet = PetInfo::getByUserID($_SESSION["id"], $this->db);
		$pet->father = $_POST["father"];
		$pet->mother = $_POST["mother"];
		$pet->Spouse = $_POST["Spouse"];
		$pet->Birthplace = $_POST["Birthplace"];
		$_POST["Introduction"] = ereg_replace("\n", "<br/>", $_POST["Introduction"]);
		$pet->Introduction = $_POST["Introduction"];
		$pet->save();

		return new Response(0,true);
	}
	
}
?>
