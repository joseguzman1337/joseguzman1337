<?php
//error_reporting(2047);
require_once($rutaado.'adodb-errorhandler.inc.php');
require_once($rutaado.'adodb-pear.inc.php');
require_once($rutaado.'adodb-active-record.inc.php');
$server="snies.unbosque.edu.co";
$user="postgres";
$password="";
$database="odsbosque";
$snies_conexion=ADONewConnection('postgres');
$snies_conexion->PConnect($server, $user, $password, $database);
$snies_conexion->SetFetchMode(ADODB_FETCH_ASSOC);
//$snies_conexion->debug=true;
ADOdb_Active_Record::SetDatabaseAdapter($snies_conexion);

/*
$conexion_bd = pg_connect("host=localhost dbname=snies user=postgres password=andreapreciosa")
    or die('No pudo conectarse: ' . pg_last_error());

// Realizar una consulta SQL
$consulta = 'SELECT * FROM autores';
$resultado = pg_query($consulta) or die('Consulta fallida: ' . pg_last_error());
*/
?>
