<?php
/*/error_reporting(E_ALL);
ini_set("display_errors", 1);/**/
session_start();
require_once('../../kint/Kint.class.php');
require_once('../Connections/sala2.php');
$rutaado=("../funciones/adodb/");
require_once('../Connections/salaado-pear.php');
require_once('../funciones/clases/autenticacion/autenticacion.php');
require_once("../Connections/conexionldap.php");
require_once("../funciones/clases/autenticacion/claseldap.php");

$tmpl = $_REQUEST['tmpl'];
if(empty($tmpl)){
    $tmpl = 'XML';
}
if(isset($_REQUEST['login']) and isset($_REQUEST['password'])){
	if(isset($_SESSION['2clavereq']) and $_SESSION['2clavereq']=='SEGCLAVE'){
        //autenticacion de para docentes 
	   $autenticacion = new autenticacion($sala,$_REQUEST['login'],$_REQUEST['password'],true, $tmpl);        
	}else{
		$autenticacion = new autenticacion($sala,$_REQUEST['login'],$_REQUEST['password'],false, $tmpl);
	}
        
   if($autenticacion->getAut()=="OK" && isset($_REQUEST["red"])){
       header('location:'.HTTP_SITE.'/');
   }     
   
}
//echo '<pre>';print_r($_SESSION);
?>
