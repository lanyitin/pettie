<?php
// import essential libraries
require_once("config.php");
require_once(ROOT.DS."functions.php");
require_once(CLASS_PATH . DS . "class.Request.php");
require_once(CLASS_PATH . DS . "class.DataBase.php");

//Initialized database connection instance
PDAO::getInstance("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PWD);

//check
if(!arrayVarCheck("request", $_GET, NOT_NULL|NOT_EMPTY_STRING))
{
    $_GET["request"] = "main/index";
}

//create Request object and send it to Presneter through Dispatcher
$request = new Request($_GET["request"], array_merge($_GET, $_POST));
$response = $request->execute();
if($response->content instanceof ITemplate){
	echo $response->content->render();
}else{
	echo json_encode($response->content);
}
?>
