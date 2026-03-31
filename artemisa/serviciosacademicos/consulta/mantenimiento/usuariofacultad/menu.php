<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
require_once('../../../funciones/clases/autenticacion/redirect.php');
$rol=$_SESSION['rol'];
$codigoperiodo=$_SESSION['codigoperiodosesion'];
$codigoperiodo=20062;
$usuario=$_SESSION['MM_Username'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Aplica ARP Listado</title>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
</head>
<?php
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulariov2/clase_formulario.php");
require_once("../../../funciones/clases/motorv2/motor.php");
$formulario = new formulario(&$sala,"formulario","post","",true,"aplicaarp_listado.php");
$formulario->jsVarios();
$codigomodalidadacademica=$_POST['codigomodalidadacademica'];
$fechahoy=$formulario->fechahoy;
?>
<body>
<form name="formulario" method="POST" action="">
<table  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<?php $formulario->celda_horizontal_combo("codigomodalidadacademica","Modalidad Académica","modalidadacademica","","codigomodalidadacademica","nombremodalidadacademica","requerido","","codigoestado='100'","nombremodalidadacademica","","onchange='document.formulario.submit();'");?>
<?php $formulario->celda_horizontal_combo("codigocarrera","Carrera","carrera","","codigocarrera","nombrecarrera","","","codigomodalidadacademica='$codigomodalidadacademica' and '$fechahoy' >= fechainiciocarrera and '$fechahoy' <= fechavencimientocarrera","nombrecarrera");?>
</table>
<?php $formulario->Boton("Enviar","Enviar");?>
</form>
<?php
if(isset($_POST['Enviar']))
{
	$valido=$formulario->valida_formulario();
	if($valido)
	{
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=usuariofacultad_listado.php?codigomodalidadacademica=".$_POST['codigomodalidadacademica']."&codigocarrera=".$_POST['codigocarrera']."'&link_origen=menu.php>";
	}
}
?>
</body>
</html>
