<?php
session_start();
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 
//$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
//require_once("../../../funciones/phpmailer/class.phpmailer.php");
//require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../FuncionesCadena.php");
require_once("../FuncionesFecha.php");
require_once('../FuncionesSeguridad.php');
require_once('../FuncionesMatematica.php');
require_once("../clasebasesdedatosgeneral.php");
require_once("ConsultaEncuesta.php");


$objetobase=new BaseDeDatosGeneral($sala);

$objetoconsultapregunta= new ConsultaEncuesta($objetobase,$formulario);

$objetoconsultapregunta->setIdEncuesta($_GET["idencuesta"]);
$objetoconsultapregunta->setIdUsuario($_GET["idusuario"]);
$objetoconsultapregunta->guardarEncuestaAjax($_GET["valorrespuesta"], $_GET["idpregunta"]);
?>