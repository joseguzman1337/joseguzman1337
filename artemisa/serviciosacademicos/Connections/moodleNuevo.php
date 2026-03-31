<?php

/** Servidor produccion solo consultas*/
$hostname_moodle2 = "172.16.3.204";
$database_moodle2 = "moodle";
$username_moodle2 = "consulta";
$password_moodle2 = "consultamoodle2013";
$moodle2 = mysql_connect($hostname_moodle2, $username_moodle2, $password_moodle2) or trigger_error(mysql_error(),E_USER_ERROR);

include_once($rutaado.'adodb.inc.php'); 

$dbMoodle2 = ADONewConnection('mysql'); 
$dbMoodle2->PConnect($hostname_moodle2, $username_moodle2, $password_moodle2, $database_moodle2); 
$dbMoodle2->EXECUTE("set names 'utf8'"); 
?>
