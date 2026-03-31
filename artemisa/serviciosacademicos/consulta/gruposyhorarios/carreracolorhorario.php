<?php
session_start();
if(!isset($_SESSION['MM_Username']))
{
	echo "<h1>Usted no está autorizado para ver esta página</h1>";
	exit();
}
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
//error_reporting(2047);
?>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/javascript/funciones_javascript.js"></script>
<?php
$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/salaado-pear.php');
require_once("../../funciones/clases/formulariov2/clase_formulario.php");
?>
<?php
$formulario = new formulario(&$sala,"form1","post","",true,"carreracolorhorario.php",true);
$formulario->agregar_tablas("carreracolorhorario","idcarreracolorhorario");
$formulario->rutaraiz="../../../";
if(isset($_GET['idcarreracolorhorario']) and !empty($_GET['idcarreracolorhorario']))
{
	$formulario->cargar("idcarreracolorhorario",$_GET['idcarreracolorhorario']);
}
?>
<form name="form1" method="POST" action="">
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<?php 
$formulario->celda_horizontal_combo("codigomodalidadacademica","Modalidad académica","modalidadacademica","","codigomodalidadacademica","nombremodalidadacademica","requerido","","","nombremodalidadacademica","","onchange=form1.submit()");
if(isset($_POST['codigomodalidadacademica']) and !empty($_POST['codigomodalidadacademica']))
{
	$formulario->celda_horizontal_combo('codigocarrera',"Carrera","carrera","carreracolorhorario","codigocarrera","nombrecarrera","requerido","","codigomodalidadacademica=".$_POST['codigomodalidadacademica']."","nombrecarrera asc");
}
else
{
	$formulario->celda_horizontal_combo('codigocarrera',"Carrera","carrera","carreracolorhorario","codigocarrera","nombrecarrera","requerido","","","nombrecarrera asc");
}
$formulario->celda_horizontal_campotexto('nombrecarreracolorhorario',"Color horario","carreracolorhorario",10,"requerido","","El color según la tabla de colores HTML");
?>
</table>
<?php
$formulario->Boton("Enviar","Enviar");
?>
</form>