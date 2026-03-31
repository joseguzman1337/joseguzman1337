<?php
require_once('../../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);
session_start();
$ruta = "../../../funciones/";
$rutaorden = "../../../funciones/ordenpago/";
require_once($rutaorden.'claseordenpago.php');
//echo "Hola";

$codigoestudiante = $_SESSION['codigo'];
$codigoperiodo    = $_SESSION['codigoperiodosesion'];
$codigocarrera    = $_SESSION['codigofacultad'];
$codigoconcept    = "C9022";

/***** Validaciones para generacion de ordenes *******/


$query_situacion = "SELECT *
FROM estudiante
WHERE codigoestudiante  = '$codigoestudiante'
AND ( codigosituacioncarreraestudiante = 300 or codigosituacioncarreraestudiante = 301 )
AND codigotipoestudiante like '1%'";
$situacion = mysql_query($query_situacion,$sala) or die("$query_situacion<br>".mysql_error());
$totalRows_situacion = mysql_num_rows($situacion);
$row_situacion = mysql_fetch_array($situacion);

if (!$row_situacion)
 {
?>		
<script language="javascript">
	alert("Aplica solo para Estudiantes Nuevos y que se encuentren Admitidos");
	history.go(-1);
</script>
<?php
	exit(); 
 }

/***** Fin Validacion ****/

$ordenesxestudiante = new Ordenesestudiante($sala, $codigoestudiante, $codigoperiodo);
if(isset($_POST['generar']))
{	
  $porcentaje = $_POST['tipoorden'];
  $fechadetallefechafinanciera = $_POST['fecha'];			
  $ordengenerada = $ordenesxestudiante->generarordenpago_matriculaabono($porcentaje,$fechadetallefechafinanciera);
  
  $query_upddetalleordenpago = "UPDATE detalleordenpago 
  SET codigoconcepto = '$codigoconcept'
  WHERE numeroordenpago = '$ordengenerada'"; 
  $upddetalleordenpago = mysql_query($query_upddetalleordenpago,$sala) or die("$query_upddetalleordenpago<br>".mysql_error());
?>		
<script language="javascript">
	window.location.reload("../../prematricula/matriculaautomaticaordenmatricula.php");
</script>
<?php
	exit();
}

$query_subper= "SELECT MAX(s.idsubperiodo) as idsubperiodo
FROM periodo p, carreraperiodo cp, subperiodo s
WHERE p.codigoperiodo  = cp.codigoperiodo
AND s.idcarreraperiodo = cp.idcarreraperiodo	
AND p.codigoperiodo = '$codigoperiodo'
AND codigocarrera = '$codigocarrera'";
$subper = mysql_query($query_subper,$sala) or die("$query_subper<br>".mysql_error());
$totalRows_subper = mysql_num_rows($subper);
$row_subper = mysql_fetch_array($subper);
$subperiodo = $row_subper['idsubperiodo'];

$query_porcentajes= "SELECT *
FROM abonomatricula
where codigocarrera = '$codigocarrera'
and idsubperiodo = '$subperiodo'
and codigoestado like '1%'";
//and dop.codigoconcepto = '151'
//echo "$query_porcentajes<br>";
$porcentajes = mysql_query($query_porcentajes,$sala) or die("$query_porcentajes<br>".mysql_error());
$totalRows_porcentajes = mysql_num_rows($porcentajes);
$row_porcentajes = mysql_fetch_array($porcentajes);

if (!$row_porcentajes)
 {
    $codigocarrera = 1;
	$query_subper= "SELECT MAX(s.idsubperiodo) as idsubperiodo
	FROM periodo p, carreraperiodo cp, subperiodo s
	WHERE p.codigoperiodo  = cp.codigoperiodo
	AND s.idcarreraperiodo = cp.idcarreraperiodo	
	AND p.codigoperiodo = '$codigoperiodo'
	AND codigocarrera = '$codigocarrera'";
	//and dop.codigoconcepto = '151'
	//echo "$query_ordeneplanpagos<br>";
	$subper = mysql_query($query_subper,$sala) or die("$query_subper<br>".mysql_error());
	$totalRows_subper = mysql_num_rows($subper);
	$row_subper = mysql_fetch_array($subper);
	$subperiodo = $row_subper['idsubperiodo'];
	
	$query_porcentajes= "SELECT *
	FROM abonomatricula
	where codigocarrera = '$codigocarrera'
	and idsubperiodo = '$subperiodo'
	and codigoestado like '1%'";	
	$porcentajes = mysql_query($query_porcentajes,$sala) or die("$query_porcentajes<br>".mysql_error());
	$totalRows_porcentajes = mysql_num_rows($porcentajes);
	$row_porcentajes = mysql_fetch_array($porcentajes);
 }

?>
<html>
<head>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<title>Generar ordenenes crédito y cartera</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
</head>
<body>
<div align="left">
<p>GENERACIÓN DE ORDENES PARA ABONO MATRICULAS<p>
<form action="" method="post" name="f1">
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<tr>
<td colspan="2" align="center" id="tituloverde"><label id="labelresaltado">Seleccione el tipo de orden que quiere generar</label></td>
</tr>
<tr>
 <td id="idtitulogris">Porcentaje a Pagar</td>
 <td>  
<select name="tipoorden">  
<?php
	do
	{
?>
  <option value="<?php echo $row_porcentajes['valorabonomatricula']?>" <?php if (!(strcmp($row_porcentajes['valorabonomatricula'], $_POST['genero']))) {echo "SELECTED";} else if($row_porcentajes['valorabonomatricula'] == $row_porcentajes['valorabonomatricula']){ echo "SELECTED";}?>>
    <?php echo $row_porcentajes['valorabonomatricula']?>%
  </option>
<?php
	}
	while ($row_porcentajes = mysql_fetch_array($porcentajes));	
	$rows = mysql_num_rows($porcentajes);

	if($rows >  0)
	{
		mysql_data_seek($porcentajes, 0);
		$row_porcentajes = mysql_fetch_assoc($porcentajes);
	}
?>

</select></td>

</tr>
<tr>
<td>Fecha de Pago</td>
<td><input type="text" name="fecha" style="font-size:9px" size="8" maxlength="10" readonly="true" value="<?php echo $_POST['fecha'];?>"></td>
</tr>
<tr>
<td colspan="2" align="center">
<?php

$query_ordeneplanpagos= "select o.numeroordenpago
from ordenpago o,detalleordenpago d
where o.codigoestudiante = '$codigoestudiante'
AND o.numeroordenpago = d.numeroordenpago 
AND (d.codigoconcepto = '$codigoconcept' or d.codigoconcepto ='151')
AND (o.codigoestadoordenpago LIKE '1%' or o.codigoestadoordenpago LIKE '4%')
AND o.codigoperiodo = '$codigoperiodo'";
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
<input type="button" name="generar" value="Generar" onClick="alert('Ya presenta orden de Abono o Matricula')"> 
<?php
}
?>
<input type="button" onClick="window.location.href='../../prematricula/matriculaautomaticaordenmatricula.php'" value="Regresar"></td></tr>
</table>
</form>
<?php
$ordenesxestudiante->mostrar_ordenespago($rutaorden,"");
//echo "<br>$sala, $codigoestudiante, $codigoperiodo";
?>
</div>
</body>
</form>
</body>
<script type="text/javascript">
	Calendar.setup(
	{ inputField : "fecha", // ID of the input field
		ifFormat : "%Y-%m-%d", // the date format
		text : "fecha" // ID of the button
	});
</script>
</html>