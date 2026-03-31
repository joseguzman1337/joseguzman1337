<?php 
/** USA LAS SIGUIENTES VARIABLES DE SESION
		$_SESSION['dir']
*/
require_once('../../../Connections/sala2.php'); 
mysql_select_db($database_sala, $sala);
session_start();
require_once('seguridadestadocalidadacademica.php');

?>
<?php
// Pagina de donde se llamo esta pagina
if(isset($_SESSION['dir']))
{
	$dir = $_SESSION['dir'];
}
else
{
	$GLOBALS['dir'];
	$_SESSION['dir'];
	$pagina = $_SERVER['HTTP_REFERER'];
	$inicio_pagina = strpos ($pagina, "?");
	$dir = substr ($pagina, $inicio_pagina);
	$_SESSION['dir']=$dir;
}
if(isset($_POST['aceptar']))
{
	$estado=$_POST['estado'];
	$codigo=$_POST['codigo'];
	begin;
	$query_modestudiante = "
	UPDATE estudiante 
    SET codigosituacioncarreraestudiante='$estado'
    WHERE codigoestudiante='$codigo'
	";
	$modestudiante = mysql_query($query_modestudiante, $sala) or die(mysql_error());
	commit;
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=estadocalidadacademica.php$dir'>";
	exit();
}
if(isset($_POST['cancelar']))
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=estadocalidadacademica.php$dir'>";
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Modificar situacion academica</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo3 {font-size: x-small}
-->
</style>
</head>
<div align="center">
<body>
<?php 
$codigoestudiante = $_GET['codigo'];
$query_estudiante = "
SELECT * FROM estudiante e, situacioncarreraestudiante s
WHERE s.codigosituacioncarreraestudiante = e.codigosituacioncarreraestudiante
AND e.codigoestudiante = '$codigoestudiante'
";
$estudiante = mysql_query($query_estudiante, $sala) or die(mysql_error());
//$totalRows_estudiante = mysql_num_rows($estudiante);

$query_calidad = "
SELECT * FROM situacioncarreraestudiante
";
$calidad = mysql_query($query_calidad, $sala) or die(mysql_error());
//$totalRows_calidad = mysql_num_rows($calidad);
?>
<form action="estadocalidadacademicamodificar.php<?php echo  $dir?>" method="post" class="Estilo1">
<p align="center"><strong>MODIFICAR EL ESTADO DE LA SITUACI&Oacute;N ACAD&Eacute;MICA DE UN ESTUDIANTE</strong></p>
<table width="707" border="1" align="center">
  <tr>
    <td align="center"><span class="Estilo3"><strong>Nombre Estudiante</strong>&nbsp;</span></td>
    <td align="center"><span class="Estilo3"><strong>Cédula</strong>&nbsp;</span></td>
    <td align="center"><span class="Estilo3"><strong>Código</strong>&nbsp;</span></td>
  	<td align="center"><span class="Estilo3"><strong>Situacion Estudiante</strong>&nbsp;</span></td>
  </tr>
  <tr>
<?php
$row_estudiante = mysql_fetch_assoc($estudiante);
$est = $row_estudiante["nombresestudiante"]." ".$row_estudiante["apellidosestudiante"];
$cc = $row_estudiante["numerodocumento"];
$cod = $row_estudiante["codigoestudiante"];
$estadoanterior = $row_estudiante["nombresituacioncarreraestudiante"];
$codigoestadoanterior = $row_estudiante["codigosituacioncarreraestudiante"];
?>
	<td><?php echo $est;?><input type="hidden" value="<?php echo $cod;?>" name="codigo"></td>
			<td><?php echo  $cc;?>&nbsp;</td>
			<td><?php echo $cod; ?>&nbsp;</td>
			<td><select name="estado">
				<option value="<?php echo  $codigoestadoanterior;?>" selected><?php echo $estadoanterior; ?></option>
<?php 
	while($row_calidad = mysql_fetch_assoc($calidad))			
	{
		$estado = $row_calidad["nombresituacioncarreraestudiante"];
		$codigoestado = $row_calidad["codigosituacioncarreraestudiante"];
		if($codigoestadoanterior != $codigoestado)
		{
?>
				<option value="<?php echo  $codigoestado;?>"><?php echo $estado; ?></option>
<?php
		}
	}
?>
				</select>
			</td>
  </tr>
<tr><td align="center" colspan="4"><p align="center"><input type="submit" name="aceptar" value="Aceptar"><input type="submit" name="cancelar" value="Cancelar"></p> </td></tr>
</table>
</form>
</div>
</body>
</html>
