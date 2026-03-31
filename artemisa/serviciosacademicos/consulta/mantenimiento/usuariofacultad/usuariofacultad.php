<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Usuariofacultad</title>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
</head>
<?php
$rutaado="../../../funciones/adodb/";
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulariov2/clase_formulario.php");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once('../../../funciones/clases/autenticacion/redirect.php');
$formulario = new formulario(&$sala,"form1","post","",true,"aplicaarp_listado.php");
$formulario->rutaraiz="../../../";
$formulario->jsVarios();
$formulario->jsCalendario();
$formulario->agregar_tablas("usuariofacultad","idusuario");
if(isset($_GET['idusuario']) and !empty($_GET['idusuario']))
{
	$formulario->cargar("idusuario",$_GET['idusuario']);
}
$fechahoy=$formulario->fechahoy;
?>
<body>
<form name="form1" method="POST" action="">
<?php
?>
<table  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<?php
if(!empty($_POST['codigomodalidadacademica']))
{
	$codigomodalidadacademica=$_POST['codigomodalidadacademica'];
	$where="codigomodalidadacademica=$codigomodalidadacademica";
}
$formulario->celda_horizontal_combo("codigomodalidadacademica","Modalidad académica","modalidadacademica","","codigomodalidadacademica","nombremodalidadacademica","requerido","","","nombremodalidadacademica","","onchange='document.form1.submit()'");
$codigomodalidadacademica=$_POST['codigomodalidadacademica'];
$formulario->celda_horizontal_combo("codigofacultad","Carrera","carrera","usuariofacultad","codigocarrera","nombrecarrera","requerido","",$where,"nombrecarrera");
$formulario->celda_horizontal_combo("codigotipousuariofacultad","Tipo usuario facultad","tipousuariofacultad","usuariofacultad","codigotipousuariofacultad","nombretipousuariofacultad","requerido","","","nombretipousuariofacultad");
$formulario->celda_horizontal_campotexto("usuario","Usuario","usuariofacultad",20,"requerido");
$formulario->celda_horizontal_campotexto("emailusuariofacultad","Email","usuariofacultad",20,"requerido");
?>
</table>
<?php $formulario->Boton("Enviar","Enviar");?>
</form>
<?php
if(isset($_POST['Enviar']))
{
	$valido=$formulario->valida_formulario();
	if($valido)
	{
		$formulario->insertar('<script language="javascript">window.close();</script><script language="javascript">window.opener.submitirFormulario();</script>','<script language="javascript">window.close();</script><script language="javascript">window.opener.submitirFormulario();</script>');
	}
}
?>
</body>
</html>
