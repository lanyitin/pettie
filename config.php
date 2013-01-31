<?php
define("ROOT", dirname(__FILE__));
define("DS", DIRECTORY_SEPARATOR);

define("CLASS_PATH", ROOT.DS."class".DS);

define("PRESENTER_PATH", CLASS_PATH."Presenter".DS);
define("TPL_PATH", ROOT.DS."template".DS);
define("TPL_CLASS_PATH", CLASS_PATH.DS."Template".DS);
define("PO_PATH", CLASS_PATH."PersistentObject".DS);

define("DB_HOST", "mysql.blueunit.info");
define("DB_NAME", "pettie");
define("DB_USER", "pettie");
define("DB_PWD", "tkuiit");

define("PETTIE_URL", "http://pettie.blueunit.info/");
//define("PETTIE_URL", "http://127.0.0.1/pettie/");

define("Debug", True);
if(Debug === True){
  error_reporting(E_ALL);
  ini_set('display_errors','On');
}
?>
