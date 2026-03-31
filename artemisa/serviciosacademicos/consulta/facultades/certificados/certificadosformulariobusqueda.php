<?php
require_once('../../../Connections/sala2.php');
session_start();
mysql_select_db($database_sala, $sala);
$codigocarrera = $_SESSION['codigofacultad'];
$usuario = $_SESSION['MM_Username'];
mysql_select_db($database_sala, $sala);
$query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
$row_tipousuario = mysql_fetch_assoc($tipousuario);
$totalRows_tipousuario = mysql_num_rows($tipousuario);
?>
<html>
<head>
<title></title>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: x-small}
.Estilo3 {font-size: xx-small}
.Estilo4 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo5 {font-size: 12px}
.Estilo6 {font-size: 12}
.Estilo8 {font-size: 12px; font-weight: bold; }
.Estilo9 {
	font-family: Tahoma;
	font-weight: bold;
	font-size: 9px;
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
		window.location.href="certificadosformulariobusqueda.php?busqueda=nombre";
	}
    if (tipo == 2)
	{
		window.location.href="certificadosformulariobusqueda.php?busqueda=apellido";
	}
    if (tipo == 3)
	{
		window.location.href="certificadosformulariobusqueda.php?busqueda=documento";
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
		window.location.href="certificadosformulariobusqueda.php?buscar="+busca;
	}
}
</script>
<body>
<div align="center" class="Estilo1">
<form name="f1" action="certificadosformulariobusqueda.php" method="get" onSubmit="return validar(this)">
  <p class="Estilo4">CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="707" border="1" bordercolor="#003333">
  <tr>
    <td width="250" bgcolor="#C5D5D6"><div align="center"><span class="Estilo6"> <span class="Estilo5"><strong>Búsqueda por : </strong></span>
            <select name="tipo" onChange="cambia_tipo()">
		      <option value="0">Seleccionar</option>
		      <option value="1">Nombre</option>
		      <option value="2">Apellido</option>
		      <option value="3">Documento</option>
	          </select>
	&nbsp;
	  </span></div></td>
	<td><span class="Estilo8">&nbsp;
	    <?php
 if(isset($_GET['busqueda']))  {
			if($_GET['busqueda']=="nombre")
			{
				echo "Digite un Nombre : <input name='busqueda_nombre' type='text' size ='18'>";
			}
			if($_GET['busqueda']=="apellido")
			{
				echo "Digite un Apellido : <input name='busqueda_apellido' type='text' size ='18'>";
			}
			if($_GET['busqueda']=="documento")
			{
				echo "Digite No. Documento : <input name='busqueda_documento' type='text' size ='12'>";
			}
?>
	</span></td>
  </tr>
  <tr>
  	<td colspan="2" align="center"><span class="Estilo3">
  	  <input name="buscar" type="submit" value="Buscar">
  	  &nbsp;
  	</span></td>
  </tr>
  <?php
  }
  ?>
</table>
  <span class="Estilo9">
  <?php
if(isset($_GET['buscar']))
  {
$tipocertificado = $_GET['tipo'];
$concreditos =  $_GET['creditos'];
$tiponota =  $_GET['tiponota'];
?>
  </span>
  <p align="center" class="Estilo2"><span class="Estilo9"></span><strong>Seleccione el estudiante al que le desee generar el certificado: </strong></p>
<table width="707" border="1" bordercolor="#003333">
  <tr>
    <td align="center" bgcolor="#C5D5D6" class="Estilo2"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" bgcolor="#C5D5D6" class="Estilo2"><strong>Cédula</strong>&nbsp;</td>
    <td align="center" bgcolor="#C5D5D6" class="Estilo2"><strong>Carrera</strong>&nbsp;</td>
  	</tr>
<?php
  	$vacio = false;
if(isset($_GET['busqueda_nombre']))
	{
	  if ($row_tipousuario['codigotipousuariofacultad'] == 200)
       {
		$nombre = $_GET['busqueda_nombre'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
				c.nombrecarrera, est.codigoestudiante, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c
				WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				and eg.idestudiantegeneral = est.idestudiantegeneral
				and ed.idestudiantegeneral = eg.idestudiantegeneral
				and c.codigocarrera = est.codigocarrera
				and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
				and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
				ORDER BY 3, est.codigoperiodo";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud".mysql_error());
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	   }
	  else
	    {
		   $nombre = $_GET['busqueda_nombre'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
				c.nombrecarrera, est.codigoestudiante, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c
				WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'
				AND est.codigocarrera like '$codigocarrera%'
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				and eg.idestudiantegeneral = est.idestudiantegeneral
				and ed.idestudiantegeneral = eg.idestudiantegeneral
				and c.codigocarrera = est.codigocarrera
				and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
				and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
				ORDER BY 3, est.codigoperiodo";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud".mysql_error());
			if($_GET['busqueda_nombre'] == "")
				$vacio = true;
		}
	}
	if(isset($_GET['busqueda_apellido']))
	{
	  if ($row_tipousuario['codigotipousuariofacultad'] == 200)
       {
		    $apellido = $_GET['busqueda_apellido'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
					c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
					FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c
					WHERE eg.apellidosestudiantegeneral LIKE '$apellido%'
					and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
					and eg.idestudiantegeneral = est.idestudiantegeneral
					and ed.idestudiantegeneral = eg.idestudiantegeneral
					and c.codigocarrera = est.codigocarrera
					and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
					and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
					ORDER BY 3, est.codigoperiodo";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_apellido'] == "")
			$vacio = true;
	   }
	  else
	   {
		 $apellido = $_GET['busqueda_apellido'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
				c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c
				WHERE eg.apellidosestudiantegeneral LIKE '$apellido%'
				AND est.codigocarrera like '$codigocarrera%'
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
				and eg.idestudiantegeneral = est.idestudiantegeneral
				and ed.idestudiantegeneral = eg.idestudiantegeneral
				and c.codigocarrera = est.codigocarrera
				and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
				and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
				ORDER BY 3, est.codigoperiodo";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			if($_GET['busqueda_apellido'] == "")
				$vacio = true;
	   }
	}
	if(isset($_GET['busqueda_documento']))
	{
	  if ($row_tipousuario['codigotipousuariofacultad'] == 200)
       {
			$documento = $_GET['busqueda_documento'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
				c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, documento d, carrera c
				WHERE ed.numerodocumento LIKE '$documento%'
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
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
	  else
	   {
	        $documento = $_GET['busqueda_documento'];
			mysql_select_db($database_sala, $sala);
			$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,
				c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
				FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, documento d, carrera c
				WHERE ed.numerodocumento LIKE '$documento%'
				AND est.codigocarrera like '$codigocarrera%'
				and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
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
	}
	if(!$vacio)
	{
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
			$est = $solicitud["nombre"];
			$cc = $solicitud["numerodocumento"];
			$cod = $solicitud["codigoestudiante"];
			$nombrecarrera = $solicitud["nombrecarrera"];
			$fac = $codigocarrera ;
			echo "<tr>
				<td><font style='Tahoma' size='2'><a href='certificadosformularioperiodos.php?codigo=$cod&tipo=$tipocertificado&concredito=$concreditos&tiponota=$tiponota'>$est&nbsp;</a></font></td>
				<td align='center'><font style='Tahoma' size='2'>$cc&nbsp;</font></td>
				<td align='center'><font style='Tahoma' size='2'>$nombrecarrera&nbsp;</font></td>
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
	window.location.href="certificadosformulariobusqueda.php";
}
</script>
</html>
