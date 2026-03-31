<?php
session_start();
$rol=$_SESSION['rol'];
$codigoperiodo=$_GET['codigoperiodo'];
echo "Periodo ".$codigoperiodo;
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
require_once('../../../funciones/clases/autenticacion/redirect.php'); 
$formulario = new formulario(&$sala,"form1","post","",true,"aplicaarp_listado.php");
$formulario->rutaraiz="../../../";
$formulario->jsCalendario();
$formulario->agregar_tablas("aplicaarp","idaplicaarp",$_GET['idaplicaarp']);
if(isset($_GET['idaplicaarp']) and !empty($_GET['idaplicaarp']))
{
	$formulario->cargar("idaplicaarp",$_GET['idaplicaarp']);
}
$codigocarrera=$_GET['codigocarrera'];
$fechahoy=$formulario->fechahoy;
?>
<body>
<form name="form1" method="POST" action="">
<input type="hidden" name="submitido" value="si" />
<table  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<?php $formulario->celda_horizontal_campotexto("nombreaplicaarp","Nombre","aplicaarp",50,"requerido");?>
<?php if(empty($codigocarrera)){$formulario->celda_horizontal_combo("codigocarrera","Carrera","carrera","aplicaarp","codigocarrera","nombrecarrera","requerido","","'$fechahoy' >= fechainiciocarrera and '$fechahoy' <= fechavencimientocarrera","nombrecarrera");}?>
<?php $formulario->celda_horizontal_combo("idempresasalud","Empresa de salud","empresasalud","aplicaarp","idempresasalud","nombreempresasalud","requerido","","","nombreempresasalud");?>
<?php $formulario->celda_horizontal_campotexto("valorbaseaplicaarp","Valor Base","aplicaarp",5,"numero");?>
<?php $formulario->celda_horizontal_campotexto("porcentajeaplicaarp","Porcentaje aplicación","aplicaarp",5,"numero");?>
<?php $formulario->celda_horizontal_campotexto("valorfijoaplicaarp","Valor Fijo aplicación","aplicaarp",5,"numero");?>
<?php $formulario->celda_horizontal_calendario("fechainicioaplicaarp","Fecha inicio aplicación","aplicaarp","requerido");?>
<?php $formulario->celda_horizontal_calendario("fechafinalaplicaarp","Fecha final aplicación","aplicaarp","requerido");?>
<?php $formulario->celda_horizontal_combo("codigotipoaplicaarp","Tipo aplicación","tipoaplicaarp","aplicaarp","codigotipoaplicaarp","nombretipoaplicaarp","requerido","","","nombretipoaplicaarp");?>
<?php $formulario->celda_horizontal_combo("codigoconcepto","Concepto","concepto","aplicaarp","codigoconcepto","nombreconcepto","requerido","","codigoestado=100","nombreconcepto");?>
<?php $formulario->celda_horizontal_campotexto("semestreinicioaplicaarp","Semestre inicial aplicación","aplicaarp",5,"numero");?>
<?php $formulario->celda_horizontal_campotexto("semestrefinalaplicaarp","Semestre final aplicación","aplicaarp",5,"numero");?>
</table>
<?php $formulario->Boton("Enviar","Enviar");?>
</form>
<?php
if(isset($_POST['submitido']))
{
	$valido=$formulario->valida_formulario();
	if($valido)
	{
		$formulario->agregar_datos_formulario("aplicaarp","codigoperiodo",$codigoperiodo);
		$formulario->agregar_datos_formulario("aplicaarp","fechaaplicaarp",$fechahoy);
		if(!empty($codigocarrera))
		{
			$formulario->agregar_datos_formulario("aplicaarp","codigocarrera",$codigocarrera);
		}
		$formulario->insertar('<script language="javascript">window.close();</script><script language="javascript">window.opener.submitirFormulario();</script>','<script language="javascript">window.close();</script><script language="javascript">window.opener.submitirFormulario();</script>');
		//$formulario->insertar("","");
	}
}
?>
</body>
</html>
