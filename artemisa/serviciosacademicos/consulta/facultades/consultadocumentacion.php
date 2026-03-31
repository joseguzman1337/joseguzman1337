<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
      
    require_once('../../Connections/sala2.php');
      session_start();	    
	  $car = $_SESSION['codigofacultad'];
?>
<html>
<head>
<title></title>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: x-small}
.Estilo3 {font-size: xx-small}
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
		window.location.reload("consultadocumentacion.php?busqueda=nombre"); 
	} 
    if (tipo == 2)
	{
		window.location.reload("consultadocumentacion.php?busqueda=apellido"); 
	} 
    if (tipo == 3)
	{
		window.location.reload("consultadocumentacion.php?busqueda=codigo"); 
    } 
    if (tipo == 4)
	{
		window.location.reload("consultadocumentacion.php?busqueda=documento"); 
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
		window.location.reload("consultadocumentacion.php?buscar="+busca); 
	} 
} 
</script>
<body>
<div align="center" class="Estilo1">
<form name="f1" action="consultadocumentacion.php" method="get" onSubmit="return validar(this)">
  <p><strong>CRITERIO DE BUSQUEDA</strong></p>
  <table width="707" border="1" bordercolor="#003333">
  <tr>
    <td width="250" bgcolor="#C5D5D6"><span class="Estilo3"> <strong>Búsqueda por : </strong>
      <select name="tipo" onChange="cambia_tipo()">
		  <option value="0">Seleccionar</option>
		  <option value="1">Nombre</option>
		  <option value="2">Apellido</option>
		  <option value="3">Código</option>
		  <option value="4">Documento</option>
	      </select>
	&nbsp;
	</span></td>
	<td><span class="Estilo3">&nbsp;
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
				echo "Digite Nº de Documento : <input name='busqueda_documento' type='text'>";
			}
	?>
	</span></td>
  </tr>
  <tr>
  	<td colspan="2" align="center"><span class="Estilo3">
  	  <input name="buscar" type="submit" value="Buscar">
  	  &nbsp;</span></td>
  </tr>
  <?php
  }
  ?>
</table>
<?php 
if(isset($_GET['buscar']))
  {
  
?>
<p align="center" class="Estilo2"><strong>Seleccione el estudiante al que le desee Modificar sus Datos: </strong></p>
<table width="707" border="1" bordercolor="#003333">
  <tr>
    <td align="center" class="Estilo2"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" class="Estilo2"><strong>Cédula</strong>&nbsp;</td>
    <td align="center" class="Estilo2"><strong>Código</strong>&nbsp;</td>
  	</tr>
<?php
  	$vacio = false;
	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];
		mysql_select_db($database_sala, $sala);
		$query_solicitud = "SELECT
					*
				FROM
					estudiante est
				WHERE					
					 est.nombresestudiante LIKE '$nombre%'
				and est.codigocarrera = '$car'
					 ORDER BY est.nombresestudiante";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_apellido']))
	{
		$apellido = $_GET['busqueda_apellido'];
		mysql_select_db($database_sala, $sala);
		$query_solicitud = "SELECT
					*
				FROM
					estudiante est
				WHERE	
					est.apellidosestudiante LIKE '$apellido%'
				and est.codigocarrera = '$car'	 
					ORDER BY est.apellidosestudiante";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_apellido'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_codigo']))
	{
		$codigo = $_GET['busqueda_codigo'];
		mysql_select_db($database_sala, $sala);
		$query_solicitud = "SELECT
					*
				FROM
					estudiante est
				WHERE										
					est.codigoestudiante LIKE '$codigo%'
				and est.codigocarrera = '$car'
					ORDER BY est.codigoestudiante";
		//echo $query_solicitud;
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_codigo'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_documento']))
	{
		$documento = $_GET['busqueda_documento'];
		mysql_select_db($database_sala, $sala);
		$query_solicitud = "SELECT
					*
				FROM
					estudiante est
				WHERE									
					est.numerodocumento LIKE '$documento%'
				and est.codigocarrera = '$car'
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
			$fac = $car;
			echo "<tr>
				<td><a href='consultadocumentacionformulario.php?codigo=$cod&carrera=$car'>$est&nbsp;</a></td>
				<td>$cc&nbsp;</td>
				<td>$cod&nbsp;</td>				
			</tr>";
		}
	}
	echo '<tr><td colspan="4" align="center"><input type="submit" name="cancelar" value="Cancelar" onClick="recargar()"></tr></td>';
}
?>
</table>
<p class="Estilo2">
</p>
</form>
</div>
</body>
<script language="javascript">
function recargar()
{
	window.location.reload("consultadocumentacion.php");
}
</script>
</html>
