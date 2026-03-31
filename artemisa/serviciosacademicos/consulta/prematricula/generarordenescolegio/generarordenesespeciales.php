<?php
/**
* @author Fernando Muñoz Beltrán
*
*
*
*/
 
require_once('../../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);
session_start();
//require_once('../../../funciones/clases/autenticacion/redirect.php' );
$ruta = "../../../funciones/";
$rutaorden = "../../../funciones/ordenpago/";

require_once($rutaorden.'claseordenpago.php');

$codigoestudiante = $_SESSION['codigo'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];

/*$codigoestudiante = 10941;
$codigoperiodo = 20081;
$_SESSION['MM_Username'] = 'sistemas';*/
//$_SESSION['MM_Username'] = 'colegio';
$query_carrera = "select c.codigocarrera, c.codigomodalidadacademica
from carrera c, estudiante e
where e.codigoestudiante = '$codigoestudiante'
and c.codigocarrera = e.codigocarrera";
//echo "$query_carrera<br>";
$carrera = mysql_db_query($database_sala,$query_carrera) or die("$query_carrera");
$totalRows_carrera = mysql_num_rows($carrera);
$row_carrera = mysql_fetch_array($carrera);
$codigomodalidadacademica = $row_carrera['codigomodalidadacademica'];
$valordetallecohorte = $_REQUEST['valordetallecohorte'];

$ordenesxestudiante = new Ordenesestudiante($sala, $codigoestudiante, $codigoperiodo);

if(isset($_POST['generar']))
{

  //se aclara a que modulo pertenece la orden
	$_GET['modulo'] = 'ordenEspecial';

	if($_POST['tipoorden'] == 0)
	{
		$conceptos[] = '151';
		$cantidad['151'] = $_REQUEST['valor'];
	}
	if($_POST['tipoorden'] == 1)
	{
		$conceptos[] = '159';
		$cantidad['159'] = $_REQUEST['valor'];
	}	    	
	if($_POST['tipoorden'] == 0)
		$ordenesxestudiante->generarordenpago_matricula_fecha($conceptos, $cantidad, $_REQUEST['fechadepago'],$_REQUEST['observacion']);
	else
		$ordenesxestudiante->generarordenpago_conceptos_fecha($conceptos, $cantidad, $_REQUEST['fechadepago'],$_REQUEST['observacion']);
?>
<script language="javascript">
	window.location.href="generarordenesespeciales.php?valordetallecohorte=<?php echo $valordetallecohorte; ?>";
</script>
<?php
	exit();
}
?>
<html>
<head>
<title>Generar ordenenes colegio</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
</head>

<body>
<div align="left">
<h3>GENERACIÓN DE ORDENES ESPECIALES DE MATRICULA</h3>
<form action="" method="post" name="f1">
<input type="hidden" name="valordetallecohorte" value="<?php echo $valordetallecohorte; ?>">
<table>
<?php
if($codigomodalidadacademica == 100)
{
?>
<tr>
<td colspan="2" align="left" id="tdtitulogris">Seleccione el tipo de orden</td>
</tr>
<tr>
<td>
Orden de Matricula<input type="radio" name="tipoorden" value="0">
</td>
<td>
Orden de Pensión<input type="radio" name="tipoorden" value="1" checked>
</td>
</tr>
<?php
}
else
{
?>
<tr><td><input type="hidden" name="tipoorden" value="0"></td></tr>
<?php
}
?>
<tr>
<td colspan="1" align="center" id="tdtitulogris">Seleccione el valor</td>
<td colspan="1" align="center" id="tdtitulogris">Seleccione la fecha</td>
<td colspan="1" align="center" id="tdtitulogris">Observación de la orden</td>
</tr>
<tr>
<td><!-- <select name="valor">
	<option value="<?php echo $valordetallecohorte; ?>" <?php if($valordetallecohorte == $_REQUEST['valor']) echo "selected"; ?>><?php echo $valordetallecohorte; ?></option>
	</select> -->
	<input type="text" value="<?php if(!isset($_REQUEST['valor'])) echo $valordetallecohorte; else echo $_REQUEST['valor']; ?>" name="valor">
	</td>
<td><input type="text" value="<?php if(isset($_REQUEST['fechadepago'])) echo $_REQUEST['fechadepago']; else echo date("Y-m-d");?>" name="fechadepago" id="fechadepago">
<script type="text/javascript">
    Calendar.setup(
    {
      inputField  : "fechadepago",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      onUpdate    : "fechadepago" // ID of the button
    }
  );
</script>
</td>
<td>
  <input type="text" value="" name="observacion">
</td>
</tr>
<?php
if($codigomodalidadacademica == 400)
{
?>
<tr>
<td colspan="2" align="center" id="tdtitulogris">Seleccione el grupo</td>
</tr>
<?php
    $query_ordenesinternas = "select n.numeroordeninternasap, g.idgrupo
    from numeroordeninternasap n, grupo g, materia m
    where n.idgrupo = g.idgrupo
    and g.codigoperiodo = '$codigoperiodo'
    and g.codigomateria = m.codigomateria
    and m.codigocarrera = '".$row_carrera['codigocarrera']."'
    and n.fechavencimientonumeroordeninternasap >= '".date("Y-m-d")."'";
    //echo "$query_carrera<br>";
    $ordenesinternas = mysql_db_query($database_sala,$query_ordenesinternas) or die("$query_ordenesinternas");
    $totalRows_ordenesinternas = mysql_num_rows($ordenesinternas);
    if($totalRows_ordenesinternas > 0)
    {
?>
<tr id="trtitulogris">
<td>
    Número Orden Interna
</td>
<td>Idgrupo</td>
</tr>
<?php
        while($row_ordenesinternas = mysql_fetch_array($ordenesinternas))
        {
?>
<tr>
<td>
    <?php echo $row_ordenesinternas['numeroordeninternasap']; ?>
</td>
<td><?php echo $row_ordenesinternas['idgrupo']; ?><input type="radio" name="zidgrupo" value="0"></td>
</tr>
<?php
        }
    }
    else
    {
?>
<tr>
<td colspan="2">
No hay orden interna activa.
</td>
</tr>
<?php

    }
?>
<?php
}
?>
<tr>
<td colspan="2" align="center">
<input type="submit" name="generar" value="Generar"> <input type="button" onClick="window.location.href='../matriculaautomaticaordenmatricula.php'" value="Regresar">
</td></tr>
</table>
</form>
<?php
//echo "<br>$sala, $codigoestudiante, $codigoperiodo,$rutaorden";
$ordenesxestudiante->mostrar_ordenespago($rutaorden,"");

//echo "<br>$sala, $codigoestudiante, $codigoperiodo";
?>
</div>
</body>
</html>
