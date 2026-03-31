<?php
require_once('../../../Connections/sala2.php'); 
mysql_select_db($database_sala, $sala);
session_start();
require_once('seguridadlistagrupos.php'); 
$codigoperiodo = $_SESSION['codigoperiodosesion'];
//$carrera = $_SESSION['codigofacultad'];
?>
<html>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: xx-small;
}
.Estilo3 {
	font-family: Tahoma;
	font-size: x-small;
	font-weight: bold;
}
.Estilo4 {font-family: Tahoma; font-size: 14px; font-weight: bold; }
.Estilo5 {font-family: Tahoma}
.Estilo7 {
	font-size: 12px;
	font-weight: bold;
}
.Estilo9 {font-family: Tahoma; font-size: 12px; }
-->
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Mostrar listado</title>
</head>

<body>
<span class="Estilo5">
<?
$codigo = $_GET['codigo'];
$idgrupo = $_GET['idgrupo'];
$query_solicitud = "SELECT distinct g.idgrupo, g.codigogrupo, g.nombregrupo, g.maximogrupo, g.matriculadosgrupo, 
m.nombremateria, m.codigomateria
FROM grupo g, materia m
where g.codigomateria = m.codigomateria
and g.idgrupo = '$idgrupo'";
$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
$solicitud = mysql_fetch_assoc($res_solicitud);
$codigogrupo = $solicitud['codigogrupo'];
$nombregrupo = $solicitud['nombregrupo'];
$maximogrupo = $solicitud['maximogrupo'];
require("calculoestudiantesinscritos.php");
$valor_prematriculados = $total_prematriculados + $total_prematriculados2;
$matriculadosgrupo =  $valor_prematriculados + $total_matriculados;
$matriculados = $total_matriculados;
$prematriculados = $total_prematriculados + $total_prematriculados2;

$query_materia = "SELECT m.nombremateria, m.codigomateria, c.nombrecarrera, 
concat(d.nombredocente,' ',d.apellidodocente) as nombre, c.codigocarrera
FROM materia m, carrera c, docente d, grupo g
where m.codigocarrera = c.codigocarrera
and g.numerodocumento = d.numerodocumento
and g.codigomateria = m.codigomateria
and g.idgrupo = '$idgrupo'
and m.codigomateria = '$codigo'";
//and m.codigocarrera = '$carrera'
$res_materia = mysql_query($query_materia, $sala) or die(mysql_error());
$materia = mysql_fetch_assoc($res_materia);
$nombrecarrera = $materia["nombrecarrera"];
$codigocarrera = $materia["codigocarrera"];
?>
</span>
<p align="center" class="Estilo4">DATOS DE LA MATERIA Y EL GRUPO </p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
  <tr bgcolor="#C5D5D6">
    <td align="center" class="Estilo9"><strong>Nombre Materia</strong>&nbsp;</td>
    <td align="center" class="Estilo9"><strong>C&oacute;digo Materia</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><span class="Estilo7">&Aacute;rea Responsable </span></td>
    <td align="center" class="Estilo9"><strong>Profesor</strong>&nbsp;</td>
  </tr>
<?php

$nombredocente = $materia["nombre"];
$nombremateria = $materia["nombremateria"];
$codigomateria = $materia["codigomateria"];

echo "<tr>
	<td align='center'><font face='Tahoma' size='2'>$nombremateria&nbsp;</td>
	<td align='center'><font face='Tahoma' size='2'>$codigomateria&nbsp;</td>
	<td align='center'><font face='Tahoma' size='2'>$nombrecarrera&nbsp;</td>
	<td align='center'><font face='Tahoma' size='2'>$nombredocente&nbsp;</td>
</tr>";
?>
</table>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
  <tr bgcolor="#C5D5D6">
    <td align="center" class="Estilo9"><strong>C&oacute;digo Grupo</strong>&nbsp;</td>
    <td align="center" class="Estilo9"><strong>Nombre Grupo</strong>&nbsp;</td>
    <td align="center" class="Estilo9"><strong>Cupo</strong>&nbsp;</td>
    <td align="center" class="Estilo9"><strong>Prematriculados</strong>&nbsp;</td>
  	<td align="center" class="Estilo9"><strong>Matriculados</strong>&nbsp;</td>
  	<td align="center" class="Estilo9"><strong>Total Grupo</strong>&nbsp;</td>
  </tr>
<?php
echo "<tr>
	<td align='center'><font face='Tahoma' size='2'>$idgrupo&nbsp;</td>
	<td align='center'><font face='Tahoma' size='2'>$nombregrupo&nbsp;</td>
	<td align='center'><font face='Tahoma' size='2'>$maximogrupo&nbsp;</td>
	<td align='center'><font face='Tahoma' size='2'>$prematriculados&nbsp;</td>
	<td align='center'><font face='Tahoma' size='2'>$matriculados&nbsp;</td>
	<td align='center'><font face='Tahoma' size='2'>$matriculadosgrupo&nbsp;</td>
</tr>";
?>
</table>
<span class="Estilo5">
<?php
$query_horario = "select s.nombresede, sa.nombresalon, d.nombredia, h.horainicial, h.horafinal
from horario h, sede s, salon sa, dia d
where h.codigosalon = sa.codigosalon
and sa.codigosede = s.codigosede
and h.codigodia = d.codigodia
and h.idgrupo = '$idgrupo'";
$res_horario = mysql_query($query_horario, $sala) or die(mysql_error());
?>
</span>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
  <tr bgcolor="#C5D5D6">
    <td align="center" class="Estilo9"><strong>Sede</strong>&nbsp;</td>
    <td align="center" class="Estilo9"><strong>Salón</strong>&nbsp;</td>
    <td align="center" class="Estilo9"><strong>Día</strong>&nbsp;</td>
    <td align="center" class="Estilo9"><strong>Hora Inicial</strong>&nbsp;</td>
  	<td align="center" class="Estilo9"><strong>Hora Final</strong>&nbsp;</td>
  </tr>
<?php
	while($horario = mysql_fetch_assoc($res_horario))
	{
		$nombresede = $horario["nombresede"];
		$nombresalon = $horario["nombresalon"];
		$nombredia = $horario["nombredia"];
		$horainicial = $horario["horainicial"];
		$horafinal = $horario["horafinal"];
		echo "<tr>
			<td align='center'><font face='Tahoma' size='2'>$nombresede&nbsp;</td>
			<td align='center'><font face='Tahoma' size='2'>$nombresalon&nbsp;</td>
			<td align='center'><font face='Tahoma' size='2'>$nombredia&nbsp;</td>
			<td align='center'><font face='Tahoma' size='2'>$horainicial&nbsp;</td>
			<td align='center'><font face='Tahoma' size='2'>$horafinal&nbsp;</td>
		</tr>";
	}
?>
</table>

<span class="Estilo5">
<?php
require("calculoestudiantesinscritos.php");
if($total_prematriculados != 0 || $total_prematriculados2 != 0)
{
?>
</span>
<p align="center" class="Estilo4"><strong>ESTUDIANTES PREMATRICULADOS</strong></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
  <tr bgcolor="#C5D5D6">
    <td width="206" align="center" class="Estilo1"><span class="Estilo7">Facultad</span></td>
    <td width="128" align="center" class="Estilo9"><strong>Documento Estudiante</strong>&nbsp;</td>
    <td width="349" align="center" class="Estilo9"><strong>Nombre Estudiante</strong>&nbsp;</td>
  </tr>
<?php
	while($inscritos = mysql_fetch_assoc($res_inscritos))
	{
		$nombreestudiante = $inscritos["nombre"];
		$numerodocumento = $inscritos["numerodocumento"];
		$nombrefacultad=$inscritos["nombrecarrera"];
		/* OJO este codigo es para efectuar el cambio de grupo
		echo "<tr>				
			<td align='center'><font face='Tahoma' size='2'>$nombrefacultad&nbsp;</td>
			<td align='center'><font face='Tahoma' size='2'><a href='cambiogrupos.php?idgrupo=$idgrupo&codigo=$codigomateria&codigogrupo=$codigogrupo&nombregrupo=$nombregrupo&maximogrupo=$maximogrupo&matriculadosgrupo=$matriculadosgrupo&matriculados=$matriculados&prematriculados=$prematriculados'>$codigoestudiante&nbsp;</a></td>
			<td align='center'><font face='Tahoma' size='2'>$nombreestudiante&nbsp;</td>
		</tr>";
		*/
		echo "<tr>				
			<td align='center'><font face='Tahoma' size='2'>$nombrefacultad&nbsp;</td>
			<td align='center'><font face='Tahoma' size='2'>$numerodocumento&nbsp;</td>
			<td align='center'><font face='Tahoma' size='2'>$nombreestudiante&nbsp;</td>
		</tr>";
	}
	$boolinscritos2 = false;
	while($inscritos2 = mysql_fetch_assoc($res_inscritos2))
	{
		$nombreestudiante = $inscritos2["nombre"];
		$numerodocumento = $inscritos2["numerodocumento"];
		$nombrefacultad=$inscritos2["nombrecarrera"];
		/* OJO Este codigo es para efectuar el cambio de grupo
		echo "<tr  bgcolor='#D4D4D4'>				
			<td align='center'><font face='Tahoma' size='2'>$nombrefacultad&nbsp;</td>
			<td align='center'><font face='Tahoma' size='2'><a href='cambiogrupos.php?idgrupo=$idgrupo&codigo=$codigomateria&codigogrupo=$codigogrupo&nombregrupo=$nombregrupo&maximogrupo=$maximogrupo&matriculadosgrupo=$matriculadosgrupo&matriculados=$matriculados&prematriculados=$prematriculados'>$codigoestudiante&nbsp;</a></td>
			<td align='center'><font face='Tahoma' size='2'>$nombreestudiante&nbsp;</td>
		</tr>";
		*/
		echo "<tr  bgcolor='#D4D4D4'>				
			<td align='center'><font face='Tahoma' size='2'>$nombrefacultad&nbsp;</td>
			<td align='center'><font face='Tahoma' size='2'>$numerodocumento&nbsp;</td>
			<td align='center'><font face='Tahoma' size='2'>$nombreestudiante&nbsp;</td>
		</tr>";
		$boolinscritos2 = true;
	}
?>
</table>
<span class="Estilo5">
<?php
	if($boolinscritos2)
	{
?>
</span>
<p align="center" class="Estilo3"><font color="#800000">Los estudiantes sombreados tienen una deuda por concepto de matricula</font></p>
<span class="Estilo5">
<?		
	}
}
if($total_matriculados != 0)
{
?>
</span>
<p align="center" class="Estilo4"><strong>ESTUDIANTES MATRICULADOS</strong></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
  <tr bgcolor="#C5D5D6">
    <td width="206" align="center" class="Estilo1"><span class="Estilo7">Facultad</span></td>
    <td width="128" align="center" class="Estilo9"><strong>Documento Estudiante</strong></td>
    <td width="349" align="center" class="Estilo9"><strong>Nombre Estudiante</strong></td>
  </tr>
  <?php
	while($matriculados = mysql_fetch_assoc($res_matriculados))
	{
		$nombreestudiante = $matriculados["nombre"];
		$numerodocumento = $matriculados["numerodocumento"];
		$nombrefacultad=$matriculados["nombrecarrera"];
		echo "<tr>				
			<td align='center'><font face='Tahoma' size='2'>$nombrefacultad&nbsp;</td>
			<td align='center'><font face='Tahoma' size='2'>$numerodocumento&nbsp;</td>
			<td align='center'><font face='Tahoma' size='2'>$nombreestudiante&nbsp;</td>
		</tr>";
	}
?>
</table>
<span class="Estilo5">
<?php
}
?>
</span>
<p align="center">
  <input type="button" onClick="print()" value="Imprimir">
<br><br><input type="button" onClick="history.go(-1)" value="Salir">
</p>
</body>
<script language="javascript">
function ira()
{
	window.location.reload("cambiargrupoacademico.php");
}
</script>
</html>
