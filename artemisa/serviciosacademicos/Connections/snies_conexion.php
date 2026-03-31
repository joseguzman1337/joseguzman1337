<?php
error_reporting(2047);
require_once($rutaado.'adodb-errorhandler.inc.php');
require_once($rutaado.'adodb-pear.inc.php');
require_once($rutaado.'adodb-active-record.inc.php');
$server="200.31.79.252";
$user="snies";
$password="Snies2006";
$database="ODSUNBOSQUE";
$snies_conexion=ADONewConnection('mysql');
$snies_conexion->PConnect($server, $user, $password, $database);
$snies_conexion->SetFetchMode(ADODB_FETCH_ASSOC);
$snies_conexion->debug=false;
ADOdb_Active_Record::SetDatabaseAdapter($snies_conexion);
?>
