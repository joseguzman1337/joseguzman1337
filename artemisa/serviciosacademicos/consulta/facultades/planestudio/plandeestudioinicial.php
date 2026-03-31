<?php


session_start();
require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
}
require_once('seguridadplandeestudio.php');
$codigocarrera = $_SESSION['codigofacultad'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Planes de estudio en construcción</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-weight: bold;
	font-size: 14px;
}
.Estilo2 {
	font-family: Tahoma;
	font-size: 12px;
}
-->
</style>
</head>

<body>
<div align="center">
<form action="plandeestudioinicial.php" name="f1" method="post">
<?php
// Se selecciona el plan de estudios de acuerdo a la fecha, es decir que en determinada fecha queda
$query_planesdeestudio = "select c.nombrecarrera, p.nombreplanestudio, p.idplanestudio
from planestudio p, carrera c
where c.codigocarrera = p.codigocarrera
and c.codigocarrera = '$codigocarrera'
and p.codigoestadoplanestudio = '101'";
$planesdeestudio = $db->GetAll($query_planesdeestudio);
$totalRows_planesdeestudio = count($planesdeestudio);
if($totalRows_planesdeestudio != "")
{
?>
<p align="center" class="Estilo1">PLANES DE ESTUDIO EN CONSTRUCCI&Oacute;N</p>
<table width="500" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
  	<td width="250" rowspan="2">
	<select name='identplanestudio' size="7" style="width: 250px">
<?php
	foreach($planesdeestudio as $row_planesdeestudio)
	{
		$nombreCarrera = $row_planesdeestudio['nombrecarrera'];
		$nombreplanestudio = $row_planesdeestudio['nombreplanestudio'];
		$idplanestudio = $row_planesdeestudio['idplanestudio'];
?>
		<option value="<?php echo $idplanestudio; ?>"><?php echo "$nombreplanestudio"; ?></option>
<?php
	}
?>
	</select>
	</td>
	<td align="center"><input type="submit" name="editar" value="Editar" style="WIDTH:80px"></td>
  </tr>
  <tr>
  	<td align="center"><input type="submit" name="eliminar" value="Eliminar" style="WIDTH:80px"></td>
  </tr>
  <?php if($_SESSION['MM_Username'] == 'admintecnologia'){
	?>
		<tr>
			<td></td>
			<td align="center"><input type="submit" name="cambiar" value="Cambiar Estado" style="WIDTH:auto"></td>
		</tr>
<?php	
  }?>
  
</table>
<span class="Estilo2">
<?php
}
else
{

	$query_carrera = "SELECT nombrecarrera FROM carrera where codigocarrera = '$codigocarrera'";
	$carrera = $db->GetRow($query_carrera);
	$row_carrera = $carrera;
	$totalRows_carrera = count($carrera);
	$nombreCarrera = $row_carrera['nombrecarrera'];
}
?>
</span>
<p align="center" class="Estilo1">PLANES DE ESTUDIO ACTIVOS</p>
<table width="500" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
  	<td width="250" rowspan="3">
	<select name='identplanestudio2' size="7" style="width: auto">
<?php
$query_planesdeestudioactivos = "select c.nombrecarrera, p.nombreplanestudio, p.idplanestudio , p.codigoestadoplanestudio
from planestudio p, carrera c
where c.codigocarrera = p.codigocarrera
and c.codigocarrera = '$codigocarrera'
and p.codigoestadoplanestudio = '100'";

$planesdeestudioactivos = $db->GetAll($query_planesdeestudioactivos);
$totalRows_planesdeestudioactivos = count($planesdeestudioactivos);
if($totalRows_planesdeestudioactivos != "")
{
	foreach($planesdeestudioactivos as $row_planesdeestudioactivos)
	{
		$nombreCarrera = $row_planesdeestudioactivos['nombrecarrera'];
		$nombreplanestudio = $row_planesdeestudioactivos['nombreplanestudio'];
		$idplanestudio = $row_planesdeestudioactivos['idplanestudio'];
		$codigoestadoplanestudio = $row_planesdeestudioactivos['codigoestadoplanestudio'];
?>
		<option value="<?php echo $idplanestudio; ?>"><?php echo "$nombreplanestudio"; ?></option>
<?php
	}
}
else
{

	$query_carrera = "SELECT nombrecarrera FROM carrera where codigocarrera = '$codigocarrera'";
	$carrera = $db->GetRow($query_carrera);
	$row_carrera = $carrera;
	$totalRows_carrera = count($carrera);
	$nombreCarrera = $row_carrera['nombrecarrera'];
}
?>
	</select>
	</td>
	<td align="center"><input  type="submit" name="nuevo" value="Nuevo" style="WIDTH:80px"></td>
  </tr>
  <tr>
  	<td align="center"><input  type="submit" name="visualizar" value="Visualizar" style="WIDTH:80px"></td>
  </tr>
  <tr>
  	<td align="center"><input type="submit" name="copiar" value="Copiar" style="WIDTH:80px"></td>
  </tr>
  <?php if($_SESSION['MM_Username'] == 'admintecnologia'){
	?>
		<tr>
			<td></td>
			<td align="center"><input type="submit" name="cambiar" value="Cambiar Estado" style="WIDTH:auto"></td>
		</tr>
<?php	
  }?>
</table>
</form>
</div>

</body>
<?php
if(isset($_POST['nuevo']))
{
	echo '<script language="javascript">
	window.location.href="nuevoplandeestudio.php?nombrecarrera='.$nombreCarrera.'";
	</script>';
}
else if(isset($_POST['identplanestudio']))
{
	if(isset($_POST['editar']))
	{
		echo '<script language="javascript">
		window.location.href="visualizarplandeestudio.php?planestudio='.$_POST['identplanestudio'].'";
		</script>';
	}
	else if(isset($_POST['eliminar']))
	{
		echo '<script language="javascript">
		window.location.href="eliminarplandeestudio.php?planestudio='.$_POST['identplanestudio'].'";
		</script>';
	}
	if(isset($_POST['cambiar']))
	{
		echo '<script language="javascript">
		window.location.href="actualizaplandeestudio/cambioestado.php?planestudio='.$_POST['identplanestudio'].'";
		</script>';
	}
}
else
{
	if(isset($_POST['editar']) || isset($_POST['eliminar']))
	{
		echo '<script language="javascript">
		alert("Debe seleccionar un plan de estudios del panel de la izquierda de planes de estudio en construcción");
		</script>';
	}
}
if(isset($_POST['nuevo']))
{
	echo "entro";
	echo '<script language="javascript">
	window.location.href="nuevoplandeestudio.php?nombrecarrera='.$nombreCarrera.'";
	</script>';
}
else if(isset($_POST['identplanestudio2']))
{
	if(isset($_POST['visualizar']))
	{
		echo '<script language="javascript">
		window.location.href="materiasporsemestre.php?planestudio='.$_POST['identplanestudio2'].'&visualizado";
		</script>';
	}
	if(isset($_POST['asignar']))
	{
		echo '<script language="javascript">
		window.location.href="asignacioncopiaplanestudio/asignacionplanestudio.php?planestudio='.$_POST['identplanestudio2'].'";
		</script>';
	}
	if(isset($_POST['copiar']))
	{
		echo '<script language="javascript">
		window.location.href="asignacioncopiaplanestudio/copiarplanestudio.php?planestudio='.$_POST['identplanestudio2'].'";
		</script>';
	}
	if(isset($_POST['cambiar']))
	{
		echo '<script language="javascript">
		window.location.href="actualizaplandeestudio/cambioestado.php?planestudio2='.$_POST['identplanestudio2'].'";
		</script>';
	}
}
else
{
	if(isset($_POST['visualizar']) || isset($_POST['asignar']))
	{
		echo '<script language="javascript">
		alert("Debe seleccionar un plan de estudios del panel de la izquierda de plan de estudios activos");
		</script>';
	}
}
?>
</html>
