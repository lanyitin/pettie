#!/usr/local/bin/php -q
<?php
	mysql_connect("mysql.blueunit.info", "pettie", "tkuiit");
	mysql_select_db("pettie");
	mysql_query("update PetStatus set satiation=satiation-1, cleanliness=cleanliness-1") or die(mysql_error());
	mysql_query("update PetStatus set satiation=0 where satiation < 0") or die(mysql_error());
	mysql_query("update PetStatus set cleanliness=0 where cleanliness < 0") or die(mysql_error());
?>
