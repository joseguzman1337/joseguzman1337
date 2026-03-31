<?php
require_once($rutaado.'adodb-errorhandler.inc.php');
require_once($rutaado.'adodb-pear.inc.php');
require_once($rutaado.'adodb-active-record.inc.php');
require('sala2.php');
$server = $hostname_sala ;
$user = $username_sala;
$password = $password_sala;
$database = $database_sala;
$sala = ADONewConnection('mysql');
$sala->PConnect($server, $user, $password, $database);
$sala->SetFetchMode(ADODB_FETCH_ASSOC);
ADOdb_Active_Record::SetDatabaseAdapter($sala);

?>
