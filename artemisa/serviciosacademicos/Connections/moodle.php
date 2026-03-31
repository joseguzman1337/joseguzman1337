<?php

/** Servidor pruebas 
$hostname_moodle = "172.16.1.7";
$database_moodle = "moodle";
$username_moodle = "root";
$password_moodle = "s4nr4f43l";
$moodle = mysql_connect($hostname_moodle, $username_moodle, $password_moodle) or trigger_error(mysql_error(),E_USER_ERROR);*/

/** Servidor produccion solo consultas*/
$hostname_moodle = "172.16.1.17";
$database_moodle = "moodle";
$username_moodle = "consulta";
$password_moodle = "consultamoodle2013";
$moodle = mysql_connect($hostname_moodle, $username_moodle, $password_moodle) or trigger_error(mysql_error(),E_USER_ERROR);

include_once($rutaado.'adodb.inc.php'); 

$dbMoodle = ADONewConnection('mysql'); 
$dbMoodle->PConnect($hostname_moodle, $username_moodle, $password_moodle, $database_moodle); 
$dbMoodle->EXECUTE("set names 'utf8'"); 
?>
