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
$ruta = "../../../funciones/";
$rutaorden = "../../../funciones/ordenpago/";
require_once($rutaorden.'claseordenpago.php');
//echo "Hola";

$codigoestudiante = $_SESSION['codigo'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];

/*$query_periodoactivo = "select nombreperiodo, codigoestadoperiodo
from periodo
where codigoperiodo = '$codigoperiodo'";
//echo "$query_periodoactivo<br>";
$periodoactivo = mysql_db_query($database_sala,$query_periodoactivo) or die("$query_periodoactivo");
$totalRows_periodoactivo = mysql_num_rows($periodoactivo);
$row_periodoactivo = mysql_fetch_array($periodoactivo);
$nombreperiodo = $row_periodoactivo['nombreperiodo'];
*/
$ordenesxestudiante = new Ordenesestudiante($sala, $codigoestudiante, $codigoperiodo);
if(isset($_POST['generar']))
{
	if($_POST['tipoorden'] == 0)
	{
		$ordenesxestudiante->generarordenpago_matricula();
	}
	if($_POST['tipoorden'] == 1)
	{
		$conceptos[] = '159';
		if(!$ordenesxestudiante->validar_generacionordenesvarias($conceptos))
		{
?>
<script language="javascript">
	history.go(-1);
</script>
<?php
			exit();
		}
		$ordenesxestudiante->generarordenpago_conceptos($conceptos);
	}
?>
<script language="javascript">
	window.location.reload("generarordenescolegio.php");
</script>
<?php
	exit();
}
?>
<html>
<head>
<title>Generar ordenenes colegio</title>
<link rel="stylesheet" href="../../../sala.css" type="text/css">
</head>

<body>
<div align="left">
<h3>GENERACIÓN DE ORDENES PARA EL COLEGIO</h3>
<form action="" method="post" name="f1">
<table>
<tr>
<td colspan="2" align="center" id="tituloverde">Seleccione el tipo de orden que quiere generar</td>
</tr>
<tr>
<td colspan="2">
Orden de Matricula<input type="radio" name="tipoorden" value="0">
</td>
<!--<td>
Orden de Pensión<input type="radio" name="tipoorden" value="1" checked>
</td>-->
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" name="generar" value="Generar"> <input type="button" onClick="window.location.href='../matriculaautomaticaordenmatricula.php'" value="Regresar"></td></tr>
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
