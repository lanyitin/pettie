#!/usr/local/bin/php -q
<?php
	mysql_connect("mysql.blueunit.info", "pettie", "tkuiit");
	mysql_select_db("pettie");
	mysql_query("update PetStatus set injectionC=3, feedC=20") or die(mysql_error());
?>
