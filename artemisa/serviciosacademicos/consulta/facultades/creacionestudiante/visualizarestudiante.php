<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);  
    
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);

session_start();
require_once('seguridadcrearestudiante.php'); 
?>
<html>
<head>
<title>Busqueda Visualizar Estudiante</title>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: x-small}
.Estilo3 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo4 {
	font-size: 12px;
	font-weight: bold;
}
.Estilo5 {
	font-size: 12px;
	font-family: Tahoma;
	font-weight: bold;
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
    //miro a ver si el tipo estï¿½ definido 
    if (tipo == 1)
	{
		window.location.href="visualizarestudiante.php?busqueda=nombre"; 
	} 
    if (tipo == 2)
	{
		window.location.href="visualizarestudiante.php?busqueda=apellido"; 
	} 
    if (tipo == 3)
	{
		window.location.href="visualizarestudiante.php?busqueda=codigo"; 
    } 
    if (tipo == 4)
	{
		window.location.href="visualizarestudiante.php?busqueda=documento"; 
    } 
} 

function buscar()
{ 
    //tomo el valor del select del tipo elegido 
    var busca 
    busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value 
    //miro a ver si el tipo estï¿½ definido 
    if (busca != 0)
	{
		window.location.href="visualizarestudiante.php?buscar="+busca; 
	} 
} 
</script>
<body>
<div align="center" class="Estilo1">
<form name="f1" action="visualizarestudiante.php" method="get" onSubmit="return validar(this)">
  <p class="Estilo3">CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="707" border="1" bordercolor="#003333">
  <tr>
    <td width="200" bgcolor="#C5D5D6"><div align="center"><span class="Estilo4"> Busqueda por :
            <select name="tipo" onChange="cambia_tipo()">
		      <option value="0">Seleccionar</option>
		      <option value="1">Nombre</option>
		      <option value="2">Apellido</option>
		      <!-- <option value="3">Cï¿½digo</option> -->
		      <option value="4">Documento</option>
            </select>
    </span></div></td>
	<td width="491"><span class="Estilo5">&nbsp;
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
				echo "Digite un Codigo : <input name='busqueda_codigo' type='text'>";
			}
			if($_GET['busqueda']=="documento")
			{
				echo "Digite un Numero de Documento : <input name='busqueda_documento' type='text'>";
			}
			if($_GET['busqueda']=="credito")
			{
				echo "Digite un Numero de Credito : <input name='busqueda_credito' type='text'>";
			}
	?>
	</span></td>
  </tr>
  <tr>
  	<td colspan="2" align="center"><input name="buscar" type="submit" value="Buscar">&nbsp;</td>
  </tr>
  <?php
  }
  if(isset($_GET['buscar']))
  {
  ?>
</table>
<p align="center" class="Estilo2"><strong>Seleccione el estudiante al que le desee visualizar sus datos: </strong></p>
<table width="707" border="1" bordercolor="#003333">
  <tr>
    <td align="center" bgcolor="#C5D5D6" class="Estilo2"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" bgcolor="#C5D5D6" class="Estilo2"><strong>Cedula</strong>&nbsp;</td>
    <td align="center" bgcolor="#C5D5D6" class="Estilo2"><strong>Carrera</strong>&nbsp;</td>
  	</tr>
<?php
  	$vacio = false;
	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];
		$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		c.nombrecarrera, est.codigoestudiante, eg.numerodocumento, est.codigoperiodo
		FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c 
		WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'
		and eg.idestudiantegeneral = est.idestudiantegeneral
		and ed.idestudiantegeneral = eg.idestudiantegeneral
		and c.codigocarrera = est.codigocarrera
		and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
		and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
		ORDER BY 3, est.codigoperiodo";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_apellido']))
	{
		$apellido = $_GET['busqueda_apellido'];
		$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
		FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c 
		WHERE eg.apellidosestudiantegeneral LIKE '$apellido%'
		AND est.codigocarrera like '$codigocarrera%'
		and eg.idestudiantegeneral = est.idestudiantegeneral
		and ed.idestudiantegeneral = eg.idestudiantegeneral
		and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
		and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
		ORDER BY 3, est.codigoperiodo";
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
					estudiante est
				WHERE	
									
					est.codigoestudiante LIKE '$codigo%'
					ORDER BY est.codigoestudiante";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_codigo'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_documento']))
	{
		$documento = $_GET['busqueda_documento'];
		$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
		FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, documento d, carrera c 
		WHERE ed.numerodocumento LIKE '$documento%'
		and eg.idestudiantegeneral = est.idestudiantegeneral
		and ed.idestudiantegeneral = eg.idestudiantegeneral
		and c.codigocarrera = est.codigocarrera
		and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
		and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
		ORDER BY 3, est.codigoperiodo";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_documento'] == "")
			$vacio = true;
	}
	if(!$vacio)
	{
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
			$est = $solicitud["nombre"];
			$cc = $solicitud["numerodocumento"];
			$cod = $solicitud["codigoestudiante"];
			$nombrecarrera = $solicitud["nombrecarrera"];
			echo "<tr>
				<td><a href='estudiantecreado.php?codigocreado=$cod'>$est&nbsp;</a></td>
				<td>$cc&nbsp;</td>
				<td>$nombrecarrera&nbsp;</td>				
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
	window.location.href="menucrearnuevoestudiante.php";
}
</script>
</html>





