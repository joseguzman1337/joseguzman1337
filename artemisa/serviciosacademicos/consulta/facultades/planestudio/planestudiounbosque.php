<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
require_once("../../../funciones/validacion.php");
require_once("../../../funciones/errores_plandeestudio.php");
require("funcionesequivalencias.php");

mysql_select_db($database_sala, $sala);
session_start();
//require_once('seguridadplandeestudio.php');
if(isset($_GET['planestudio']))
{
	$idplanestudio = $_GET['planestudio'];
	// Para las materias que no son lineas de enfasis
	$idlineaenfasis = 1;
	$estaEnenfasis = "no";
	$idlineamodificar = 1;
}
$formulariovalido = 1;
?>
<html>
<head>
<title>Materias por semestre</title>
</head>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo2 {
	font-family: sans-serif;
	font-size: 9px;
	text-align: center;
}
.Estilo3 {
	font-family: sans-serif;
	font-size: 9px;
	width: 9px;
}
-->
</style>
<?php
echo'<script language="javascript">
function recargar2(dir)
{
	//alert("Va a hacer algo");
	window.location.href="../materiasgrupos/detallesmateria.php"+dir+"&planestudio='.$idplanestudio.'&visualizado";
}
</script>';
?>
<script language="javascript">
function recargar(dir)
{
	window.location.href="materiasporsemestre.php?"+dir;
	//history.go();
}
</script>
<body>
<div align="center">
<form name="f1" method="post" action="materiasporsemestre.php?planestudio=<?php echo "$idplanestudio";?>">
<?php
// Selecciona toda la informacion del plan de estudio
$query_planestudio = "select p.idplanestudio, p.nombreplanestudio, p.fechacreacionplanestudio,
p.responsableplanestudio, p.cargoresponsableplanestudio, p.cantidadsemestresplanestudio,
c.nombrecarrera, p.numeroautorizacionplanestudio, t.nombretipocantidadelectivalibre,
p.cantidadelectivalibre, p.fechainioplanestudio, p.fechavencimientoplanestudio
from planestudio p, carrera c, tipocantidadelectivalibre t
where p.codigocarrera = c.codigocarrera
and p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre
and p.idplanestudio = '$idplanestudio'";
$planestudio = mysql_query($query_planestudio, $sala) or die("$query_planestudio");
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);
if(!isset($_GET['tipodereferencia']) && !isset($_POST['tipodereferencia']))
{
	require_once("pensumseleccionreferenciaunbosquesnies.php");
}
?>
</html>
