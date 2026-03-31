<?php 
require_once('../../Connections/sala2.php'); 
$GLOBALS['codigofacultad'];
session_start();
if(isset($_SESSION['codigofacultad']))
{
	unset($_SESSION['codigofacultad']);
}

mysql_select_db($database_sala, $sala);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>INICIAL</title>
</head>

<body>
<p align="center"><strong>SELECCIONE LA CARRERA A LA QUE DESEA GENERARLE IMPRESIONES MASIVAS </strong></p>
<table align="center" border="1" width="500">
  <tr>
	<td align="center"><strong>CODIGO</strong></td>
	<td align="center"><strong>NOMBRE</strong></td>
  </tr>
<?php
$query_carrera = "SELECT codigocarrera, nombrecarrera FROM carrera order by 2";
$res_carrera = mysql_db_query($database_sala, $query_carrera) or die("No se deja selecionar el minimo");
while($carrera = mysql_fetch_assoc($res_carrera))
{
	$nombre=$carrera['nombrecarrera'];
	$codigo=$carrera['codigocarrera'];
	echo '<tr>
	<td align="center"><a href="listadoimpresiones.php?carrera='.$codigo.'">'.$codigo.'</td>
	<td align="center">'.$nombre.'</td>
  </tr>';
}
?>
</table>
</body>
</html>