<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
$rutaado='../../../funciones/adodb/';
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');


/* Input to this file - $_GET['saveString']; */

if(!isset($_GET['deleteIds']))die("no se recibieron ids para borrar");
$items = explode(",",$_GET['saveString']);
for($no=0;$no<count($items);$no++){
	$tokens = explode("-",$items[$no]);

	//echo "ID: ".$tokens[0]. " is sub of ".$tokens[1]."\n";	// Just for testing

	// Example of sql

	$query_actualiza="UPDATE menuopcion set codigoestadomenuopcion='02' WHERE idmenuopcion IN('".$_GET['deleteIds']."')";
	//$sala->debug=true;
	$operacion=$sala->query($query_actualiza);
	if($operacion){
		echo "OK";
	}
	else{
		echo "NOT OK";
	}
	//$sala->debug=false;
	// mysql_query("update nodes set parentID='".$tokens[1]."',position='$no' where ID='".$tokens[0]."'") or die(mysql_error());
	// for a table like this:
}
/*

nodes
---------------------
ID int
title varchar(255)
position int
parentID int

*/

?>