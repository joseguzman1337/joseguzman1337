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
// Cojo los de este semestre 
$query_premaini = "select e.codigoestudiante
from prematricula p, estudiante e
where e.codigoestudiante = p.codigoestudiante
and p.codigoperiodo = '20052'
and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
and e.codigocarrera = '050'
group by 1";
$premaini = mysql_query($query_premaini, $sala) or die("$query_premaini".mysql_error());
$total_premaini = mysql_num_rows($premaini);
// Si el estudiante tiene prematricula activa y alguna orden de pago activa le muestra los datos
$quitarestudiantes = "";
while($row_premaini = mysql_fetch_assoc($premaini))
{
	$quitarestudiantes = "$quitarestudiantes and e.codigoestudiante <> '".$row_premaini['codigoestudiante']."'";
}
// Cojo los del semestre pasado y quito los de este semestre
$query_premaant = "select e.codigoestudiante, concat(e.apellidosestudiante,' ',e.nombresestudiante) as nombre, 
e.numerodocumento
from prematricula p, estudiante e
where e.codigoestudiante = p.codigoestudiante
and p.codigoperiodo = '20051'
and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
$quitarestudiantes
and e.codigocarrera = '050'
and e.codigosituacioncarreraestudiante not like '1%'
and e.codigosituacioncarreraestudiante not like '5%'
group by 1
order by 2";
$premaant = mysql_query($query_premaant, $sala) or die("$query_premaant".mysql_error());
$total_premaant = mysql_num_rows($premaant);
// Si el estudiante tiene prematricula activa y alguna orden de pago activa le muestra los datos
$cuenta = 1;
if($total_premaant != "")
{
?>
<p align="center"><strong>ESTUDIANTES QUE NO TIENEN ORDEN DE MATRICULA</strong></p>
<p align="center">
<table width="707" border="1" align="center">
  <tr>
    <td align="center"><strong>Nº</strong>&nbsp;</td>
    <td align="center"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center"><strong>Cédula</strong>&nbsp;</td>
    <td align="center"><strong>Código</strong>&nbsp;</td>
  </tr>
<?php
	while($row_premaant = mysql_fetch_assoc($premaant))
	{
		$est = $row_premaant["nombre"];
		$cc = $row_premaant["numerodocumento"];
		$cod = $row_premaant["codigoestudiante"];
		echo "<tr>
		<td>$cuenta&nbsp;</td>
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
