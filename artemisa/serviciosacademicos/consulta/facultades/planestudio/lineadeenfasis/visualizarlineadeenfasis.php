<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
require_once('../../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
session_start();
require_once('../seguridadplandeestudio.php');
if(isset($_GET['planestudio']))
{
	$idplanestudio = $_GET['planestudio'];
	$idlineaenfasis = $_GET['lineaenfasis'];
}
$query_lineaenfasis = "select idlineaenfasisplanestudio, idplanestudio, nombrelineaenfasisplanestudio, fechacreacionlineaenfasisplanestudio,
fechainiciolineaenfasisplanestudio, fechavencimientolineaenfasisplanestudio, responsablelineaenfasisplanestudio
from lineaenfasisplanestudio
where idlineaenfasisplanestudio = '$idlineaenfasis'
and idplanestudio = '$idplanestudio'";
$lineaEnfasis = mysql_query($query_lineaenfasis, $sala) or die("$query_planestudio");
$row_lineaenfasis = mysql_fetch_assoc($lineaEnfasis);
$totalRows_lineaenfasis = mysql_num_rows($lineaEnfasis);

// Seleccion de las materias que son papas
$query_materiabase = "select d.codigomateria, d.semestredetalleplanestudio*1 as semestre, m.nombremateria
from detalleplanestudio d, materia m
where d.idplanestudio = '$idplanestudio'
and d.codigotipomateria = '5'
and m.codigomateria = d.codigomateria
order by 2 ";
$materiabase = mysql_query($query_materiabase, $sala) or die("$query_materiabase");
$totalRows_materiabase = mysql_num_rows($materiabase);
while($row_materiabase = mysql_fetch_assoc($materiabase))
{
	$query_detallelinea = "select idlineaenfasisplanestudio
	from detallelineaenfasisplanestudio
	where idplanestudio = '$idplanestudio'
	and codigomateria = '".$row_materiabase['codigomateria']."'
	and idlineaenfasisplanestudio = '$idlineaenfasis'";
	$detallelinea = mysql_query($query_detallelinea, $sala) or die("$query_detallelinea");
	$row_detallelinea = mysql_fetch_assoc($detallelinea);
	$totalRows_detallelinea = mysql_num_rows($detallelinea);
	if($totalRows_detallelinea != "")
	{
		$papaseditados[] = $row_materiabase;
	}
	else
	{
		$papassineditar[] = $row_materiabase;
	}
}
?>
<html>
<head>
<title>Visualizar línea de énfasis</title>
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
}
-->
</style>
<body>
<div align="center">
<form name="f1" method="post" action="visualizarlineadeenfasis.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis";?>">
<p class="Estilo1" align="center"><strong>LINEA DE ENFASIS</strong></p>
<table width="400" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Nº Plan Estudio</strong></td>
	<td align="center"><strong>Nº Línea de Enfasis</strong></td>
	<td align="center"><strong>Fecha</strong></td>
  </tr>
  <tr>
	<td align="center"><?php echo $idplanestudio; ?></td>
	<td align="center"><?php echo $idlineaenfasis; ?></td>
	<td align="center"><?php echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_lineaenfasis['fechacreacionlineaenfasisplanestudio']); ?></td>
  </tr>
  <tr bgcolor="#C5D5D6">
	<td align="center"><strong>Nombre De la Línea</strong></td>
  	<td align="center" colspan="2"><strong>Responsable</strong></td>
  </tr>
  <tr>
	  <td align="center"><?php echo $row_lineaenfasis['nombrelineaenfasisplanestudio']; ?></td>
	<td align="center" colspan="2"><?php echo $row_lineaenfasis['responsablelineaenfasisplanestudio']; ?></td>
	</tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Fecha de Inicio</strong></td>
	<td align="center" colspan="2"><strong>Fecha de Vencimiento</strong></td>
  </tr>
  <tr>
  	<td align="center"><?php echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_lineaenfasis['fechainiciolineaenfasisplanestudio']); ?>
    </td>
	<td align="center" colspan="2"><?php echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_lineaenfasis['fechavencimientolineaenfasisplanestudio']); ?>
    </td>
  </tr>
  <tr>
  	<td align="center" colspan="3"><input type="button" name="modificarcabecera" value="Modificar Información de la Línea de Enfasis" onClick="window.location.href='cambiarcabeceralineadeenfasis.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis";?>'"></td>
  </tr>
<?php
if(isset($papassineditar))
{
?>
  <tr>
	<td align="center" colspan="3">
	<p><strong>Materias de Enfasis sin Editar</strong></p>
	<table border="1" cellpadding='2' cellspacing='1' bordercolor='#D76B00'>
	  <tr>
	  	<td align="center"><strong>Código</strong></td>
		<td align="center"><strong>Nombre</strong></td>
	  </tr>
<?php
	foreach($papassineditar as $key => $materiapapasineditar)
	{
?>
	  <tr>
	  	<td><a href="visualizarhijoslineadeenfasis.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis&materiapapa=".$materiapapasineditar['codigomateria']."";?>"><?php echo $materiapapasineditar['codigomateria'];?></a></td>
	  	<td><?php echo $materiapapasineditar['nombremateria'];?></td>
	  </tr>
<?php
	}
?>
	</table>
	</td>
  </tr>
<?php
}
$tieneunpapa = false;
if(isset($papaseditados))
{
	$tieneunpapa = true;
?>
	<tr>
	<td align="center" colspan="3">
	<p><strong>Materias de Enfasis Editadas</strong></p>
	<table border="1" cellpadding='2' cellspacing='1' bordercolor='#D76B00'>
	  <tr>
	  	<td align="center"><strong>Código</strong></td>
		<td align="center"><strong>Nombre</strong></td>
	  </tr>
<?php
	foreach($papaseditados as $key => $materiapapaeditada)
	{
?>
	  <tr>
	  	<td><a href="visualizarhijoslineadeenfasis.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis&materiapapa=".$materiapapaeditada['codigomateria']."";?>"><?php echo $materiapapaeditada['codigomateria'];?></a></td>
	  	<td><?php echo $materiapapaeditada['nombremateria'];?></td>
	  </tr>
<?php
	}
?>
	</table>
	</td>
  </tr>
<?php
}
?>
  <tr>
  	<td align="center" colspan="3">
	<input type="button" name="regresar" value="Regresar" style="width:135px" onClick="window.location.href='lineadeenfasisinicial.php?planestudio=<?php echo "$idplanestudio";?>'">
<?php
if(!isset($papassineditar) || $tieneunpapa)
{
?>
	<input type="button" name="iraplanestudio" value="Ver Plan de Estudios" style="width:135px" onClick="window.location.href='materiaslineadeenfasisporsemestre.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis&lineamodificar=1";?>'">
<?php
}
?>
	</td>
  </tr>
</table>
</form>
</div>
</body>
</html>
