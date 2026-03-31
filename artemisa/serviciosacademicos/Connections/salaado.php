<?php
$server = $hostname_sala;
$user = $username_sala;
$password = $password_sala;
$database = $database_sala;

include($rutaado.'adodb.inc.php'); 

$db = ADONewConnection('mysql'); 
$db->Connect($server, $user, $password, $database); 
?>
