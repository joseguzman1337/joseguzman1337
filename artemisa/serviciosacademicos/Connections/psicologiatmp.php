<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

$hostname_uebautes = "localhost";
$database_uebautes = "uebautes";
	$username_uebautes = "psicologia";
$password_uebautes = "123456";
$uebautes = mysql_pconnect($hostname_uebautes, $username_uebautes, $password_uebautes) or die("NO CONECTO BASE PSICO");
//echo $hostname_uebautes.",". $username_uebautes.",". $password_uebautes;
@session_start();

require_once($rutaado.'adodb-errorhandler.inc.php');
require_once($rutaado.'adodb-pear.inc.php');
require_once($rutaado.'adodb-active-record.inc.php');
$server = $hostname_uebautes ;
$user = $username_uebautes;
$password = $password_uebautes;
$database = $database_uebautes;
$uebautes = ADONewConnection('mysql');
$uebautes->PConnect($server, $user, $password, $database);
$uebautes->SetFetchMode(ADODB_FETCH_ASSOC);
$uebautes->debug=false;
ADOdb_Active_Record::SetDatabaseAdapter($uebautes);
//require_once('seguridadconexion.php');
?>