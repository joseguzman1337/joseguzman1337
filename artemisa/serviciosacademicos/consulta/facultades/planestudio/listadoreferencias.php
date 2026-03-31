<?php
ini_set('display_errors', '1');
session_start();
include_once('../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
require (realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));

require_once("../../../funciones/validacion.php");
require_once("../../../funciones/errores_plandeestudio.php");
require("funcionesequivalencias.php");

require_once('seguridadplandeestudio.php');
if(isset($_GET['planestudio']))
{
	//echo "adssad $tipomateria";
	$idplanestudio = $_GET['planestudio'];
	$materiaAreferenciar = $_GET['codigodemateria'];
	$tipomateria = $_GET['tipomateriaenplan'];
	$idlineaenfasis = $_GET['lineaenfasis'];
	//echo "sdasd $tipomateria";
	if($tipomateria == 5)
	{
		$query_selidlinea= "select idlineaenfasisplanestudio
		from detallelineaenfasisplanestudio
		where idplanestudio = '$idplanestudio'
		and codigomateriadetallelineaenfasisplanestudio = '$materiaAreferenciar'
		and codigotipomateria = '5'";
		//echo "$query_selidlinea";
		$selidlinea = $db->GetRow($query_selidlinea);
		$totalRows_selidlinea = count($selidlinea);
		$row_selidlinea = $selidlinea;
		$idlineamodificar = $row_selidlinea['idlineaenfasisplanestudio'];
	}
	else
	{
		$idlineamodificar = 1;
	}
}
$query_datomateria = "select nombremateria
from materia
where codigomateria = '".$_GET['codigodemateria']."'";
$datomateria = $db->GetRow($query_datomateria);
$totalRows_datomateria = count($datomateria);
$row_datomateria = $datomateria;
		
?>
<html>
<head>
<title>Opciones de Referencia Plan de Estudio</title>
<style type="text/css">
<!--
.Estilo3 {
	font-size: 11px;
	font-weight: bold;
}
-->
</style>
</head>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo4 {font-size: 11px}
-->
</style>
<body>
<div align="center">
<form name="f1" method="post">
<p class="Estilo1" align="center"><strong> REFERENCIAS DE <?php echo $row_datomateria['nombremateria']; ?> </strong></p>
<?php 
$query_selprerequisitos = "select r.codigomateriareferenciaplanestudio, m.nombremateria
from referenciaplanestudio r, materia m
where r.idplanestudio = '$idplanestudio'
and r.codigomateria = '".$_GET['codigodemateria']."'
and r.idlineaenfasisplanestudio = '1'
and r.codigotiporeferenciaplanestudio = '100'
and m.codigomateria = r.codigomateriareferenciaplanestudio";
//echo "UNO: $query_selprerequisitos <br>";
$selprerequisitos = $db->GetAll($query_selprerequisitos);
$totalRows_selprerequisitos = count($selprerequisitos);
//$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);
if($totalRows_selprerequisitos == "")
{
	$query_selprerequisitos = "select r.codigomateriareferenciaplanestudio, m.nombremateria
	from referenciaplanestudio r, materia m
	where r.idplanestudio = '$idplanestudio'
	and r.codigomateria = '".$_GET['codigodemateria']."'
	and r.idlineaenfasisplanestudio = '$idlineamodificar'
	and r.codigotiporeferenciaplanestudio = '100'
	and m.codigomateria = r.codigomateriareferenciaplanestudio";
	//echo "DOS: $query_selprerequisitos <br>";
	$selprerequisitos = $db->GetAll($query_selprerequisitos);
	$totalRows_selprerequisitos = count($selprerequisitos);
}
if($totalRows_selprerequisitos != "")
{
?>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
  	    <td align="center" bgcolor="#C5D5D6" colspan="2"><span class="Estilo3">PREREQUISITOS</span></td>
  </tr>
  <tr>
  	    <td align="center" bgcolor="#C5D5D6"><span class="Estilo3">CODIGO</span></td> 	    
		<td align="center" bgcolor="#C5D5D6"><span class="Estilo3">NOMBRE</span></td>
  </tr>
<?php
	foreach($selprerequisitos as $row_selprerequisitos)
	{
?>
  <tr>
  	<td><span class="Estilo4"><?php echo $row_selprerequisitos['codigomateriareferenciaplanestudio']?></span></td>
	<td><span class="Estilo4"><?php echo $row_selprerequisitos['nombremateria']?></span></td>
  </tr>

<?php
	}
?>
</table>
<br><br>
<?php
}
$query_selcorequisitos = "select r.codigomateriareferenciaplanestudio, m.nombremateria
from referenciaplanestudio r, materia m
where r.idplanestudio = '$idplanestudio'
and r.codigomateria = '".$_GET['codigodemateria']."'
and r.idlineaenfasisplanestudio = '1'
and r.codigotiporeferenciaplanestudio = '200'
and m.codigomateria = r.codigomateriareferenciaplanestudio";
$selcorequisitos = $db->GetAll($query_selcorequisitos);
$totalRows_selcorequisitos = count($selcorequisitos);
if($totalRows_selcorequisitos == "")
{
	$query_selcorequisitos = "select r.codigomateriareferenciaplanestudio, m.nombremateria
	from referenciaplanestudio r, materia m
	where r.idplanestudio = '$idplanestudio'
	and r.codigomateria = '".$_GET['codigodemateria']."'
	and r.idlineaenfasisplanestudio = '$idlineaenfasis'
	and r.codigotiporeferenciaplanestudio = '200'
	and m.codigomateria = r.codigomateriareferenciaplanestudio";
	$selcorequisitos = $db->GetAll($query_selcorequisitos);
	$totalRows_selcorequisitos = count($selcorequisitos);
}
if($totalRows_selcorequisitos != "")
{
?>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
  	    <td align="center" bgcolor="#C5D5D6" colspan="2"><span class="Estilo3">COREQUISITOS DOBLES </span></td>
  </tr>
  <tr>
  	    <td align="center" bgcolor="#C5D5D6"><span class="Estilo3">CODIGO</span></td> 	    
		<td align="center" bgcolor="#C5D5D6"><span class="Estilo3">NOMBRE</span></td>
  </tr>
<?php
	foreach($selcorequisitos as $row_selcorequisitos)
	{
?>
  <tr>
  	<td><span class="Estilo4"><?php echo $row_selcorequisitos['codigomateriareferenciaplanestudio']?></span></td>
	<td><span class="Estilo4"><?php echo $row_selcorequisitos['nombremateria']?></span></td>
  </tr>

<?php
	}
?>
</table>
<br><br>
<?php
}
$query_selcorequisitosencillo = "select r.codigomateriareferenciaplanestudio, m.nombremateria
from referenciaplanestudio r, materia m
where r.idplanestudio = '$idplanestudio'
and r.codigomateria = '".$_GET['codigodemateria']."'
and r.idlineaenfasisplanestudio = '1'
and r.codigotiporeferenciaplanestudio = '201'
and m.codigomateria = r.codigomateriareferenciaplanestudio";
$selcorequisitosencillo = $db->GetAll($query_selcorequisitosencillo);
$totalRows_selcorequisitosencillo = count($selcorequisitosencillo);
//$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);
if($totalRows_selcorequisitosencillo == "")
{
	$query_selcorequisitosencillo = "select r.codigomateriareferenciaplanestudio, m.nombremateria
	from referenciaplanestudio r, materia m
	where r.idplanestudio = '$idplanestudio'
	and r.codigomateria = '".$_GET['codigodemateria']."'
	and r.idlineaenfasisplanestudio = '$idlineaenfasis'
	and r.codigotiporeferenciaplanestudio = '201'
	and m.codigomateria = r.codigomateriareferenciaplanestudio";
	$selcorequisitosencillo = $db->GetAll($query_selcorequisitosencillo);
	$totalRows_selcorequisitosencillo = count($selcorequisitosencillo);
	//$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);
}
if($totalRows_selcorequisitosencillo != "")
{
?>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
  	    <td align="center" bgcolor="#C5D5D6" colspan="2"><span class="Estilo3">COREQUISITOS SENCILLOS </span></td>
  </tr>
  <tr>
  	    <td align="center" bgcolor="#C5D5D6"><span class="Estilo3">CODIGO</span></td> 	    
		<td align="center" bgcolor="#C5D5D6"><span class="Estilo3">NOMBRE</span></td>
  </tr>
<?php
	foreach($selcorequisitosencillo as $row_selcorequisitosencillo)
	{
?>
  <tr>
  	<td><span class="Estilo4"><?php echo $row_selcorequisitosencillo['codigomateriareferenciaplanestudio']?></span></td>
	<td><span class="Estilo4"><?php echo $row_selcorequisitosencillo['nombremateria']?></span></td>
  </tr>

<?php
	}
?>
</table>
<br><br>
<?php
}
$query_selequivalencias = "select r.codigomateriareferenciaplanestudio, m.nombremateria
from referenciaplanestudio r, materia m
where r.idplanestudio = '$idplanestudio'
and r.codigomateria = '".$_GET['codigodemateria']."'
and r.idlineaenfasisplanestudio = '1'
and r.codigotiporeferenciaplanestudio = '300'
and m.codigomateria = r.codigomateriareferenciaplanestudio";
$selequivalencias = $db->GetAll($query_selequivalencias);
$totalRows_selequivalencias = count($selequivalencias);
//$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);
if($totalRows_selequivalencias == "")
{
	$query_selequivalencias = "select r.codigomateriareferenciaplanestudio, m.nombremateria
	from referenciaplanestudio r, materia m
	where r.idplanestudio = '$idplanestudio'
	and r.codigomateria = '".$_GET['codigodemateria']."'
	and r.idlineaenfasisplanestudio = '$idlineaenfasis'
	and r.codigotiporeferenciaplanestudio = '300'
	and m.codigomateria = r.codigomateriareferenciaplanestudio";
	$selequivalencias = $db->GetAll($query_selequivalencias);
	$totalRows_selequivalencias = count($selequivalencias);
	//$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);
}
if($totalRows_selequivalencias != "")
{
?>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
  	    <td align="center" bgcolor="#C5D5D6" colspan="2"><span class="Estilo3">EQIVALENCIAS</span></td>
  </tr>
  <tr>
  	    <td align="center" bgcolor="#C5D5D6"><span class="Estilo3">CODIGO</span></td> 	    
		<td align="center" bgcolor="#C5D5D6"><span class="Estilo3">NOMBRE</span></td>
  </tr>
<?php
//	if(isset($Arregloequivalencias))
//	{
	foreach($selequivalencias as $row_selequivalencias)
	{
?>
  <tr>
  	<td><span class="Estilo4"><?php echo $row_selequivalencias['codigomateriareferenciaplanestudio'] ?></span></td>
	<td><span class="Estilo4"><?php echo $row_selequivalencias['nombremateria']; ?></span></td>
  </tr>

<?php
	}
?>
</table>
<?php
}
?>
</form>
</div>
</body>
</html>
