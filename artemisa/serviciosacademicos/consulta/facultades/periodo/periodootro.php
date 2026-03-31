<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php'); 
mysql_select_db($database_sala, $sala);
//session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>INICIAL</title>
</head>

<body>
<div align="center">
<?php
if(isset($_SESSION['codigoperiodosesion']))
{
?>
	<p><font face="Tahoma"><strong><font size="3">Periodo actual:</font> <?php echo $row_selperiodo['nombreperiodo'];?></strong></font></p>
<?php
}
else
{
?>
	<p><font face="Tahoma" size="3"><strong>No tiene periodo seleccionado</strong></font></p>
	<p><font face="Tahoma" size="3"><strong>Seleccione el periodo para cada carrera de la siguiente tabla</strong></font>
    </p>
<?php
}
?>
<table align="center" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
	<td align="center"><font size="2" face="Tahoma"><strong>CODIGO</strong></font></td>
	<td align="center"><font size="2" face="Tahoma"><strong>CARRERA</strong></font></td>
  </tr>
<?php
	$query_carrera = "SELECT nombrecarrera, codigocarrera 
	from carrera 
	where fechavencimientocarrera > '".date("Y-m-d G:i:s",time())."'
	order by 1";
	$res_carrera = mysql_db_query($database_sala, $query_carrera) or die("$query_carrera".mysql_error());
while($carrera = mysql_fetch_assoc($res_carrera))
{
	$nombrecarrera = $carrera['nombrecarrera'];
	$codigocarrera = $carrera['codigocarrera'];
	echo '<tr>
	<td align="center"><font size="2" face="Tahoma"><a href="periodo.php?carreraseleccionada='.$codigocarrera.'">'.$codigocarrera.'</a></font></td>
	<td align="center"><font size="2" face="Tahoma">'.$nombrecarrera.'</font></td>
  </tr>';
}
?>
</table>
</div>
</body>
</html>
