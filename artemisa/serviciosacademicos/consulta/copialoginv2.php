<?php
session_start();
include_once('../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
//session_start();
require_once('../Connections/sala2.php');
$rutaado=("../funciones/adodb/");
require_once('../Connections/salaado-pear.php');
require_once('../funciones/clases/autenticacion/autenticacion.php');
if(isset($_POST['login']) and isset($_POST['password'])){
	if(isset($_SESSION['2clavereq']) and $_SESSION['2clavereq']=='SEGCLAVE'){
		$autenticacion = new autenticacion($sala,$_POST['login'],$_POST['password'],true);
	}
	else{
		$autenticacion = new autenticacion($sala,$_POST['login'],$_POST['password'],false);
	}
}
?>