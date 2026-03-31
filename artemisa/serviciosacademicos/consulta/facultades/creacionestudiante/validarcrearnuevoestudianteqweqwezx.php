<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);  
    
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);

session_start(); 
require_once('seguridadcrearestudiante.php');

mysql_select_db($database_sala, $sala);
?>
<html>
<head>
<title>Validación para crear Estduiante</title>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: x-small}
.Estilo4 {font-size: xx-small}
-->
</style>
</head>
<body>
<div align="center" class="Estilo1">
<form name="f1" action="validarcrearnuevoestudiante.php" method="get" onSubmit="return validar(this)">
  <p><strong>CRITERIO DE BUSQUEDA</strong></p>
  <table width="707" border="1" bordercolor="#003333">
  <tr>
    <td bgcolor="#C5D5D6"><span class="Estilo4"> <strong>Nombres:</strong>	&nbsp;<?php if(!isset($_GET['buscar'])) { ?><input type="text" name="nombres"><?php } else  { ?> <input type="text" name="nombres" value="<?php echo  $_GET['nombres'];?>" readonly="true"><?php }?>
	</span></td>
	<td bgcolor="#C5D5D6"><span class="Estilo4"> <strong>Apellidos:</strong>	&nbsp;<?php if(!isset($_GET['buscar'])) { ?><input type="text" name="apellidos"><?php } else  { ?> <input type="text" name="apellidos" value="<?php echo  $_GET['apellidos'];?>" readonly="true"><?php }?>
	</span></td>
  </tr>	
	  <td bgcolor="#C5D5D6" colspan="2" align="center"><span class="Estilo4"> <strong>Documento de Identidad (Actual o Anterior) o Código Estudiante:</strong>	&nbsp;<?php if(!isset($_GET['buscar'])) { ?>
	        <input type="text" name="documento"><?php } else  { ?> <input type="text" name="documento" value="<?php echo  $_GET['documento'];?>" readonly="true"><?php }?>
	</span></td>
  </tr>
  <tr>
  	<td colspan="2" align="center">
	<?php if(!isset($_GET['buscar'])) { ?><input name="buscar" type="submit" value="Buscar">&nbsp;<?php } else{ ?><input  name="buscar2" type="submit" value="Otra Búsqueda"> <?php }?></td>
  </tr>
</table>
<?php
$vacio = false;
if(isset($_GET['buscar']))
{
	$nombre = $_GET['nombres'];
	$apellido = $_GET['apellidos'];
	$documento = $_GET['documento'];
	if($nombre != "" && $apellido != "")
	{
		$query_selnombres = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		c.nombrecarrera, est.codigoestudiante, eg.numerodocumento, est.codigoperiodo
		FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c 
		WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'
		and eg.apellidosestudiantegeneral LIKE '%$apellido%'
		and eg.idestudiantegeneral = est.idestudiantegeneral
		and ed.idestudiantegeneral = eg.idestudiantegeneral
		and c.codigocarrera = est.codigocarrera
		and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
		and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
		ORDER BY 3, est.codigoperiodo";
		$selnombres = mysql_query($query_selnombres, $sala) or die(mysql_error());
		$totalRows_selnombres = mysql_num_rows($selnombres);
	}
	else if($nombre == "" && $apellido != "")
	{
		$query_selnombres = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		c.nombrecarrera, est.codigoestudiante, eg.numerodocumento, est.codigoperiodo
		FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c 
		WHERE eg.apellidosestudiantegeneral LIKE '%$apellido%'
		and eg.idestudiantegeneral = est.idestudiantegeneral
		and ed.idestudiantegeneral = eg.idestudiantegeneral
		and c.codigocarrera = est.codigocarrera
		and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
		and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
		ORDER BY 3, est.codigoperiodo";
		$selnombres = mysql_query($query_selnombres, $sala) or die(mysql_error());
		$totalRows_selnombres = mysql_num_rows($selnombres);
	}
	else if($nombre != "" && $apellido == "")
	{
		$query_selnombres = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		c.nombrecarrera, est.codigoestudiante, eg.numerodocumento, est.codigoperiodo
		FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c 
		WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'
		and eg.idestudiantegeneral = est.idestudiantegeneral
		and ed.idestudiantegeneral = eg.idestudiantegeneral
		and c.codigocarrera = est.codigocarrera
		and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
		and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
		ORDER BY 3, est.codigoperiodo";
		$selnombres = mysql_query($query_selnombres, $sala) or die(mysql_error());
		$totalRows_selnombres = mysql_num_rows($selnombres);
	}
	if($totalRows_selnombres != "")
	{
?>
<p align="center" class="Estilo2"><strong>Estudiantes que tienen un nombre igual, parecido o que contiene los nombres y apellidos digitados:</strong></p>
<table width="707" border="1" bordercolor="#003333">
  <tr>
    <td align="center" class="Estilo2"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" class="Estilo2"><strong>Cédula</strong>&nbsp;</td>
    <td align="center" class="Estilo2"><strong>Carrera</strong>&nbsp;</td>
  	</tr>
<?php
		while($row_selnombres = mysql_fetch_assoc($selnombres))
		{
			$est = $row_selnombres["nombre"];
			$cc = $row_selnombres["numerodocumento"];
			$cod = $row_selnombres["codigoestudiante"];
			$idestudiantegeneral = $row_selnombres["idestudiantegeneral"];
			$nombrecarrera = $row_selnombres["nombrecarrera"];
			//$estado = $solicitud["nombresituacioncarreraestudiante"];
?>
  <tr>
	<td><a href='editarestudiantecarrera.php?estudiantegeneral=<?php echo $idestudiantegeneral ?>'><?php echo $est ?>&nbsp;</a></td>
	<td><?php echo $cc ?>&nbsp;</td>
	<td><?php echo $nombrecarrera ?>&nbsp;</td>				
  </tr>
<?php			
		}
?>
</table>
<?php
	}
	$query_seldocumentos = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
	c.nombrecarrera, est.codigoestudiante, eg.numerodocumento, est.codigoperiodo
	FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c 
	WHERE ed.numerodocumento = '$documento'
	and eg.idestudiantegeneral = est.idestudiantegeneral
	and ed.idestudiantegeneral = eg.idestudiantegeneral
	and c.codigocarrera = est.codigocarrera
	ORDER BY 3, est.codigoperiodo";
	$seldocumentos = mysql_query($query_seldocumentos, $sala) or die(mysql_error());
	$totalRows_seldocumentos = mysql_num_rows($seldocumentos);
	if($totalRows_seldocumentos != "")
	{
?>
<p align="center" class="Estilo2"><strong>Estudiantes que tienen un documento igual al digitado:</strong></p>
<table width="707" border="1" bordercolor="#003333">
  <tr>
    <td align="center" class="Estilo2"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" class="Estilo2"><strong>Cédula</strong>&nbsp;</td>
    <td align="center" class="Estilo2"><strong>Carrera</strong>&nbsp;</td>
  	</tr>
<?php
		while($row_seldocumentos = mysql_fetch_assoc($seldocumentos))
		{
			$est = $row_seldocumentos["nombre"];
			$cc = $row_seldocumentos["numerodocumento"];
			$cod = $row_seldocumentos["codigoestudiante"];
			$idestudiantegeneral = $row_seldocumentos["idestudiantegeneral"];
			$nombrecarrera = $row_seldocumentos["nombrecarrera"];
			//$estado = $solicitud["nombresituacioncarreraestudiante"];
?>
  <tr>
	<td><a href='editarestudiantecarrera.php?estudiantegeneral=<?php echo $idestudiantegeneral ?>'><?php echo $est ?>&nbsp;</a></td>
	<td><?php echo $cc ?>&nbsp;</td>
	<td><?php echo $nombrecarrera ?>&nbsp;</td>				
  </tr>
<?php			
		}
?>
</table>
<?php
	}
?>
<p align="center" class="Estilo2"><strong>Si el estudiante que quiere ingresar a la facultad no aparece en los anteriores listados de clic en el siguiente botón <br> y digite el documento de identificación en el campo de texto</strong>
<br><br><input type="submit" name="crear" value="Crear Nuevo Estudiante" onClick="<?php echo "window.location.reload('crearnuevoestudiante.php?nombres=".$_GET['nombres']."&apellidos=".$_GET['apellidos']."&documento=".$_GET['documento']."')";?>">
<br><br> <strong>No. Documento:</strong>
<br><br><input type="text" name="documentofinal" value="<?php echo $_GET['documento'];?>"></p>
<?php
}
if(isset($_GET['crear']))
{
	$query_existeestudiante = "SELECT * 
	FROM estudiantedocumento
	where numerodocumento = '".$_GET['documentofinal']."'";
	//echo "$query_existeestudiante<br>";
	$existeestudiante = mysql_query($query_existeestudiante, $sala) or die(mysql_error());
	$row_existeestudiante = mysql_fetch_assoc($existeestudiante);
	$totalRows_existeestudiante = mysql_num_rows($existeestudiante);
	if($totalRows_existeestudiante != "")
	{
?>
		<script language="javascript">
		alert("El documento que digito ya se encuentraen el sistema");
		history.go(-1);
		</script>
<?php
	}
	else
	{
		if($_GET['documentofinal'] == "")
		{
			echo "<script language='javascript'>
			alert('Debe digitar un número de documento');
			history.go(-1);
			</script>";
		}
		echo "<script language='javascript'>
		window.location.reload('crearnuevoestudiante.php?nombres=".$_GET['nombres']."&apellidos=".$_GET['apellidos']."&documento=".$_GET['documentofinal']."')
		</script>";
	}
}
?>
</form>
</div>
</body>
<script language="javascript">
function recargar()
{
	window.location.reload("menucrearnuevoestudiante.php");
}
</script>
</html>