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
		$porcentaje = 50;
		if(!$ordenesxestudiante->validar_generacionordenesmatricula())
		{
				//exit();
		?>
			<script language="javascript">
				history.go(-1);
			</script>
<?php
		}
		else
		{
			$ordenesxestudiante->generarordenpago_matriculacyc($porcentaje);
		}
	}
	if($_POST['tipoorden'] == 1)
	{
		if(!$ordenesxestudiante->validar_generacionordenesmatricula())
		{
				//exit();
		?>
			<script language="javascript">
				history.go(-1);
			</script>
<?php
		}
		else
		{
			$ordenesxestudiante->generarordenpago_matriculacyc();
		}
	}
?>
<script language="javascript">
	window.location.reload("generarordenparacredito.php");
</script>
<?php
	exit();
}
?>
<html>
<head>
<title>Generar ordenenes crédito y cartera</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>

<body>
<div align="left">
<p>GENERACIÓN DE ORDENES PARA LEGALIZACION DEL CREDITO<p>
<form action="" method="post" name="f1">
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<tr>
<td colspan="2" align="center" id="tituloverde"><label id="labelresaltado">Seleccione el tipo de orden que quiere generar</label></td>
</tr>
<tr>
<td>
<strong>Orden por el 50% de la matricula</strong><input type="radio" name="tipoorden" value="0">
</td>
<td>
  <strong>Orden por el 100% de la matricula</strong>
  <input type="radio" name="tipoorden" value="1" checked>
</td>
</tr>
<tr>
<td colspan="2" align="center">
<?php
// Si tiene orden por concepto de plan de pagos no genera una nueva orden
$query_ordeneplanpagos= "select o.numeroordenpago
from ordenpago o
where o.codigoestudiante = '$codigoestudiante'
and o.codigoestadoordenpago = '14'
and o.codigoperiodo = '$codigoperiodo'";
//and dop.codigoconcepto = '151'
//echo "$query_ordeneplanpagos<br>";
$ordeneplanpagos = mysql_query($query_ordeneplanpagos,$sala) or die("$query_ordeneplanpagos<br>".mysql_error());
$totalRows_ordeneplanpagos = mysql_num_rows($ordeneplanpagos);
if($totalRows_ordeneplanpagos == "")
{
?>
<input type="submit" name="generar" value="Generar"> 
<?php
}
else
{
?>
<input type="button" name="generar" value="Generar" onClick="alert('No se le permite generar más de una orden para plan de pagos, debe anularse la orden que se encuentra activa')"> 
<?php
}
?>
<input type="button" onClick="window.location.href='../../prematricula/matriculaautomaticaordenmatricula.php'" value="Regresar"></td></tr>
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
