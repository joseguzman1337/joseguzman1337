<?php 
//require_once('https://artemisa.unbosque.edu.co/serviciosacademicos/Connections/sala2.php');
$hostname_sala = "200.31.79.227";
$database_sala = "sala";
$username_sala = "emerson";
$password_sala = "kilo999";
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR); 

//require_once('../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);
session_start();
?>
<html>
<head>
<title>Estudiates sin prematricula</title>
</head>

<body>
<?php
// Cojo las ordenes de pago que tienen fechas
$query_premaini = "select e.codigoestudiante
from estudiante e, ordenpago o, fechaordenpago f
where o.codigoestudiante = e.codigoestudiante
and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
and o.codigoperiodo = '20052'
and f.numeroordenpago = o.numeroordenpago";
$premaini = mysql_query($query_premaini, $sala) or die("$query_premaini".mysql_error());
$total_premaini = mysql_num_rows($premaini);
// Si el estudiante tiene prematricula activa y alguna orden de pago activa le muestra los datos
$quitarestudiantes = "";
while($row_premaini = mysql_fetch_assoc($premaini))
{
	$quitarestudiantes = "$quitarestudiantes and e.codigoestudiante <> '".$row_premaini['codigoestudiante']."'";
}
// Cojo todas y quito las ordenes de pago con fechas
$query_premaant = "select e.codigoestudiante, concat(e.apellidosestudiante,' ',e.nombresestudiante) as nombre, 
e.numerodocumento, o.numeroordenpago, c.nombrecarrera
from estudiante e, ordenpago o, carrera c
where o.codigoestudiante = e.codigoestudiante
and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
and o.codigoperiodo = '20052'
and e.codigocarrera = c.codigocarrera
$quitarestudiantes
order by 4";
$premaant = mysql_query($query_premaant, $sala) or die("$query_premaant".mysql_error());
$total_premaant = mysql_num_rows($premaant);
// Si el estudiante tiene prematricula activa y alguna orden de pago activa le muestra los datos
$cuenta = 1;
if($total_premaant != "")
{
?>
<p align="center"><strong>ESTUDIANTES QUE NO TIENEN FECHAS EN LA ORDEN DE MATRICULA</strong></p>
<p align="center">
<table width="707" border="1" align="center">
  <tr>
    <td align="center"><strong>Nº</strong>&nbsp;</td>
    <td align="center"><strong>Facultad</strong>&nbsp;</td>
    <td align="center"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center"><strong>Orden</strong>&nbsp;</td>
    <td align="center"><strong>Código</strong>&nbsp;</td>
  </tr>
<?php
	while($row_premaant = mysql_fetch_assoc($premaant))
	{
		$fac = $row_premaant["nombrecarrera"];
		$est = $row_premaant["nombre"];
		$cc = $row_premaant["numeroordenpago"];
		$cod = $row_premaant["codigoestudiante"];
		echo "<tr>
		<td>$cuenta&nbsp;</td>
		<td>$fac&nbsp;</td>
		<td>$est&nbsp;</td>
		<td>$cc&nbsp;</td>
		<td>$cod&nbsp;</td>
		</tr>";
		$cuenta++;
	}
}		
?>
</table>
</body>
</html>
