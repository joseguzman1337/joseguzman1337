<?php 
session_start();
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/adodb/adodb-active-record.inc.php');
$db = getBD();
//$db->debug = true;   
ADOdb_Active_Record::SetDatabaseAdapter($db);
$ADODB_ASSOC_CASE = 0;
class periodo extends ADOdb_Active_Record{
	var $_table = 'periodo';
}
?>