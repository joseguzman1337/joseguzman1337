<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
require_once('sala2.php');
        	
	/* Database connection information */
	$username_sala        = $username_sala;
	$password_sala   = $password_sala;
	$database_sala         = $database_sala;
	$hostname_sala     = $hostname_sala;
        
/*$hostname_sala = "172.16.3.202";
$database_sala = "sala";
$username_sala = "desarrollo";
$password_sala = "desarrollosala";*/

$sala = mysql_connect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR);
?>
