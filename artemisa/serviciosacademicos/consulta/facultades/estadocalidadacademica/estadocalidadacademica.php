<?php 
	/** USA LAS SIGUIENTES VARIABLES DE SESION
		GENERALES:
		$_SESSION['carrera']
		PARA ESTE PROGRAMA:
		$_SESSION['dir']
	*/
	require_once('../../../Connections/sala2.php');
	mysql_select_db($database_sala, $sala);
	session_start();
	require_once('seguridadestadocalidadacademica.php');
	//$_SESSION['carrera'] = 700;
	$codigocarrera = $_SESSION['codigofacultad'];
	if(isset($_SESSION['dir']))
	{
		unset($_SESSION['dir']);
	}
	
?>
<html>
<head>
<title>Estado calidad Académica</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
-->
</style>
</head>
<script language="javascript">
function cambia_tipo()
{ 
    //tomo el valor del select del tipo elegido 
    var tipo 
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value 
    //miro a ver si el tipo está definido 
    if (tipo == 1)
	{
		window.location.reload("estadocalidadacademica.php?busqueda=nombre"); 
	} 
    if (tipo == 2)
	{
		window.location.reload("estadocalidadacademica.php?busqueda=apellido"); 
	} 
    if (tipo == 3)
	{
		window.location.reload("estadocalidadacademica.php?busqueda=codigo"); 
    } 
    if (tipo == 4)
	{
		window.location.reload("estadocalidadacademica.php?busqueda=documento"); 
    } 
} 

function buscar()
{ 
    //tomo el valor del select del tipo elegido 
    var busca 
    busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value 
    //miro a ver si el tipo está definido 
    if (busca != 0)
	{
		window.location.reload("estadocalidadacademica.php?buscar="+busca); 
	} 
} 
</script>
<body>
<div align="center">
<form name="f1" action="estadocalidadacademica.php" method="get">
  <p class="Estilo1"><strong>CRITERIO DE B&Uacute;SQUEDA</strong></p>
  <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="250" bgcolor="#C5D5D6" class="Estilo1">
	<strong>Búsqueda por :</strong>	<select name="tipo" onChange="cambia_tipo()">
		<option value="0">Seleccionar</option>
		<option value="1">Nombre</option>
		<option value="2">Apellido</option>
		<option value="3">Código</option>
		<option value="4">Documento</option>
	</select>
	&nbsp;
	</td>
	<td class="Estilo1">&nbsp;
	<?php
		if(isset($_GET['busqueda']))
		{
			if($_GET['busqueda']=="nombre")
			{
				echo "Digite un Nombre : <input name='busqueda_nombre' type='text'>";
			}
			if($_GET['busqueda']=="apellido")
			{
				echo "Digite un Apellido : <input name='busqueda_apellido' type='text'>";
			}
			if($_GET['busqueda']=="codigo")
			{
				echo "Digite un Código : <input name='busqueda_codigo' type='text'>";
			}
			if($_GET['busqueda']=="documento")
			{
				echo "Digite un Número de Documento : <input name='busqueda_documento' type='text'>";
			}
			if($_GET['busqueda']=="credito")
			{
				echo "Digite un Número de Credito : <input name='busqueda_credito' type='text'>";
			}
	?>
	</td>
  </tr>
  <tr>
  	<td colspan="2" align="center" class="Estilo1"><input name="buscar" type="submit" value="Buscar">&nbsp;</td>
  </tr>
  <?php
  }
  if(isset($_GET['buscar']))
  {
  ?>
</table>
<p align="center" class="Estilo1"><strong>Seleccione el estudiante al que le desee modificar su situación académica en la siguiente tabla: </strong></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
    <td align="center" class="Estilo1"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Cédula</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Código</strong>&nbsp;</td>
  	<td align="center" class="Estilo1"><strong>Situaci&oacute;n Estudiante</strong>&nbsp;</td>
  </tr>
<?php
  	$vacio = false;
	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];
		$query_solicitud = "SELECT
					*
				FROM
					estudiante est, carrera car, situacioncarreraestudiante sce
				WHERE
					sce.codigosituacioncarreraestudiante = est.codigosituacioncarreraestudiante
					AND est.codigocarrera = car.codigocarrera
					AND car.codigocarrera = '$codigocarrera'
					AND est.nombresestudiante LIKE '$nombre%'
					ORDER BY est.nombresestudiante";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_apellido']))
	{
		$apellido = $_GET['busqueda_apellido'];
		$query_solicitud = "SELECT
					*
				FROM
					estudiante est, carrera car, situacioncarreraestudiante sce
				WHERE
					sce.codigosituacioncarreraestudiante = est.codigosituacioncarreraestudiante
					AND est.codigocarrera = car.codigocarrera
					AND car.codigocarrera = '$codigocarrera'
					AND est.apellidosestudiante LIKE '$apellido%'
					ORDER BY est.apellidosestudiante";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_apellido'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_codigo']))
	{
		$codigo = $_GET['busqueda_codigo'];
		$query_solicitud = "SELECT
					*
				FROM
					estudiante est, carrera car, situacioncarreraestudiante sce
				WHERE
					sce.codigosituacioncarreraestudiante = est.codigosituacioncarreraestudiante
					AND est.codigocarrera = car.codigocarrera
					AND car.codigocarrera = '$codigocarrera'
					AND est.codigoestudiante LIKE '$codigo%'
					ORDER BY est.codigoestudiante";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_codigo'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_documento']))
	{
		$documento = $_GET['busqueda_documento'];
		$query_solicitud = "SELECT
					*
				FROM
					estudiante est, carrera car, situacioncarreraestudiante sce
				WHERE
					sce.codigosituacioncarreraestudiante = est.codigosituacioncarreraestudiante
					AND est.codigocarrera = car.codigocarrera
					AND car.codigocarrera = '$codigocarrera'
					AND est.numerodocumento LIKE '$documento%'
					ORDER BY est.numerodocumento";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_documento'] == "")
			$vacio = true;
	}
	if(!$vacio)
	{
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
			$est = $solicitud["nombresestudiante"]." ".$solicitud["apellidosestudiante"];
			$cc = $solicitud["numerodocumento"];
			$cod = $solicitud["codigoestudiante"];
			$estado = $solicitud["nombresituacioncarreraestudiante"];
			echo "<tr>
				<td><a href='estadocalidadacademicamodificar.php?codigo=$cod'>$est&nbsp;</a></td>
				<td>$cc&nbsp;</td>
				<td>$cod&nbsp;</td>
				<td>$estado&nbsp;</td>
			</tr>";
		}
	}
	echo '<tr><td colspan="4" align="center"><input type="submit" name="cancelar" value="Cancelar" onClick="recargar()"></tr></td>';
}
?>
</table>
<p>

</p>
</form>
</div>
</body>
<script language="javascript">
function recargar()
{
	window.location.reload("estadocalidadacademica");
}
</script>
</html>
