<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();
require_once('../../../Connections/sala2.php'); 
require_once('seguridadlistagrupos.php'); 
//mysql_select_db($database_sala, $sala);

if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";

header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");

exit();
}

/********** COMENTAR ***********/
//$_SESSION['MM_Username'] = "gallegodubian";
//$_SESSION['MM_Username'] = "adminmedicina";
//$_SESSION['codigofacultad'] = 100;
//$GLOBALS['MM_Username'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];
$carrera = $_SESSION['codigofacultad'];
$usuario=$_SESSION['MM_Username'];
//echo $codigoperiodo;
$query_documento = "SELECT numerodocumento, codigorol
FROM usuario
WHERE usuario = '$usuario'";
//echo "<br>$query_rol";
mysql_select_db($database_sala, $sala);
$documento = mysql_query($query_documento, $sala) or die("$query_rol<br>");
$total_documento = mysql_num_rows($documento);
$row_documento = mysql_fetch_assoc($documento);
if($row_documento['codigorol'] == 8 || $row_documento['codigorol'] == 9)
{
	$_SESSION['codigofacultad'] = 0;
}
	
if(!isset($_SESSION['codigofacultad']))
{
	$numerodocumento = $row_documento['numerodocumento'];
	//mysql_close($ususarios);
}
mysql_select_db($database_sala, $sala);
?>
<html>
<head>
<title>Lista de grupos</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: xx-small;
}
.Estilo3 {
	font-family: Tahoma;
	font-size: x-small;
	font-weight: bold;
}
.Estilo4 {
	font-size: xx-small;
	font-weight: bold;
}
.Estilo5 {font-size: 14px}
.Estilo6 {font-family: Tahoma; font-size: 12px; }
.Estilo7 {font-family: Tahoma}
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
		window.location.reload("listagrupos.php?busqueda=nombre"); 
	} 
    if (tipo == 2)
	{
		window.location.reload("listagrupos.php?busqueda=codigo"); 
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
		window.location.reload("listagrupos.php?buscar="+busca); 
	} 
} 
</script>

<body>
<div align="center">
<form name="f1" action="listagrupos.php" method="get">
<?php
if(isset($_SESSION['codigofacultad']))
{
?>
  <p class="Estilo1 Estilo5"><strong>CRITERIO DE B&Uacute;SQUEDA</strong></p>
  <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="250" bgcolor="#C5D5D6" class="Estilo1">
	<span class="Estilo4">Búsqueda por :</span>	<select name="tipo" onChange="cambia_tipo()">
		<option value="0">Seleccionar</option>
		<option value="1">Nombre</option>
		<option value="2">Código</option>
	</select>
&nbsp;	</td>
	<td class="Estilo1">&nbsp;
<?php
	if(isset($_GET['busqueda']))
	{
		if($_GET['busqueda']=="nombre")
		{
			echo "Digite un Nombre : <input name='busqueda_nombre' type='text'>";
		}
		if($_GET['busqueda']=="codigo")
		{
			echo "Digite un Código : <input name='busqueda_codigo' type='text'>";
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
<?php
		$vacio = false;
		if(isset($_GET['busqueda_nombre']))
		{
			$nombre = $_GET['busqueda_nombre'];
			$query_solicitud = "SELECT distinct g.idgrupo, g.codigogrupo, g.nombregrupo, g.codigomateria, g.maximogrupo, g.matriculadosgrupo, m.nombremateria, m.codigomateria
			FROM grupo g, materia m
			where g.codigomateria = m.codigomateria
			and m.nombremateria like '$nombre%'
			and g.codigoestadogrupo like '1%'
			and m.codigocarrera = '$carrera'
			and g.codigoperiodo = '$codigoperiodo'
			order by m.nombremateria, g.idgrupo";
			//and g.codigomaterianovasoft = m.codigomaterianovasoft		
			//and m.codigocarrera = '$carrera'
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			/*$query_materia = "SELECT m.nombremateria, m.codigomateria
			FROM materia m
			where m.nombremateria = '$nombre%'
			and m.codigocarrera = '$carrera'";
			$res_materia = mysql_query($query_materia, $sala) or die(mysql_error());
			$materia = mysql_fetch_assoc($res_materia);
			*/
			if($_GET['busqueda_nombre'] == "")
				$vacio = true;
		}
		if(isset($_GET['busqueda_codigo']))
		{
			$codigo = $_GET['busqueda_codigo'];
			$query_solicitud = "SELECT distinct g.idgrupo, g.codigogrupo, g.nombregrupo, g.maximogrupo, g.matriculadosgrupo, m.nombremateria, m.codigomateria
			FROM grupo g, materia m
			where g.codigomateria = m.codigomateria
			and m.codigomateria like '$codigo%'
			and g.codigoestadogrupo like '1%'
			and g.codigoperiodo = '$codigoperiodo'
			and m.codigocarrera = '$carrera'
			order by m.nombremateria, g.idgrupo";
			//and g.codigomaterianovasoft = m.codigomaterianovasoft		
			//and m.codigocarrera = '$carrera'
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			/*
			$query_materia = "SELECT m.nombremateria, m.codigomateria
			FROM materia m
			where m.codigomateria = '$codigo%'
			and m.codigocarrera = '$carrera'";
			$res_materia = mysql_query($query_materia, $sala) or die(mysql_error());
			$materia = mysql_fetch_assoc($res_materia);
			*/
			if($_GET['busqueda_codigo'] == "")
				$vacio = true;
		}
		if(!$vacio)
		{
?>
<p align="center" class="Estilo3">Seleccione el grupo que desee consultar de la siguiente tabla</p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
    <td align="center" class="Estilo6"><strong>Nombre Materia</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Codigo Materia</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Código Grupo</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Nombre Grupo</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Cupo</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Prematriculados</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Matriculados</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Total Grupo</strong>&nbsp;</td>
  </tr>
<?php
			while($solicitud = mysql_fetch_assoc($res_solicitud))
			{
				$nombremateria = $solicitud["nombremateria"];
				$codigomateria = $solicitud["codigomateria"];
				$idgrupo = $solicitud["idgrupo"];
				$codigogrupo = $solicitud["codigogrupo"];
				$nombregrupo = $solicitud["nombregrupo"];
				$maximogrupo = $solicitud["maximogrupo"];
				$matriculadosgrupo = $solicitud["matriculadosgrupo"];
				
				require("calculoestudiantesinscritos.php");
				$valor_prematriculados = $total_prematriculados + $total_prematriculados2;
				$matriculadosgrupo =  $valor_prematriculados + $total_matriculados;
				echo "<tr align='center'>
					<td><font size='2' face='Tahoma'><a href='listagruposmostrar.php?idgrupo=$idgrupo&codigo=$codigomateria&codigogrupo=$codigogrupo&nombregrupo=$nombregrupo&maximogrupo=$maximogrupo&matriculadosgrupo=$matriculadosgrupo&matriculados=$total_matriculados&prematriculados=$valor_prematriculados'>$nombremateria&nbsp;</a></td>
					<td><font size='2' face='Tahoma'>$codigomateria&nbsp;</td>
					<td><font size='2' face='Tahoma'>$idgrupo&nbsp;</a></td>
					<td><font size='2' face='Tahoma'>$nombregrupo&nbsp;</td>
					<td><font size='2' face='Tahoma'>$maximogrupo&nbsp;</td>
					<td><font size='2' face='Tahoma'>$valor_prematriculados&nbsp;</td>
					<td><font size='2' face='Tahoma'>$total_matriculados&nbsp;</td>
					<td><font size='2' face='Tahoma'>$matriculadosgrupo&nbsp;</td>
				</tr>";
			}
		}
?>
</table>
<?php
		if($vacio)
		{
			echo "<font size='2' face='Tahoma'><td align='center'>No se encontro ningún resultado</td>";
		}
	}
}
else
{
	$query_solicitud = "SELECT distinct g.idgrupo, g.codigogrupo, g.nombregrupo, g.codigomateria, g.maximogrupo, g.matriculadosgrupo, m.nombremateria, m.codigomateria
	FROM grupo g, materia m
	where g.codigomateria = m.codigomateria
	and g.codigoestadogrupo like '1%'
	and g.numerodocumento = '$numerodocumento'
	and g.codigoperiodo = '$codigoperiodo'
	order by m.nombremateria, g.idgrupo";
	$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
	$total_solicitud = mysql_num_rows($res_solicitud);
	/*$query_materia = "SELECT m.nombremateria, m.codigomateria
	FROM materia m
	where m.nombremateria = '$nombre%'
	and m.codigocarrera = '$carrera'";
	$res_materia = mysql_query($query_materia, $sala) or die(mysql_error());
	$materia = mysql_fetch_assoc($res_materia);
	*/
	if($total_solicitud != "")
	{
	
?>
<p align="center" class="Estilo3">Seleccione el grupo que desee consultar de la siguiente tabla</p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
    <td align="center" class="Estilo6"><strong>Nombre Materia</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Codigo Materia</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Código Grupo</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Nombre Grupo</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Cupo</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Prematriculados</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Matriculados</strong>&nbsp;</td>
    <td align="center" class="Estilo6"><strong>Total Grupo</strong>&nbsp;</td>
  </tr>
<?php
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
			$nombremateria = $solicitud["nombremateria"];
			$codigomateria = $solicitud["codigomateria"];
			$idgrupo = $solicitud["idgrupo"];
			$codigogrupo = $solicitud["codigogrupo"];
			$nombregrupo = $solicitud["nombregrupo"];
			$maximogrupo = $solicitud["maximogrupo"];
			$matriculadosgrupo = $solicitud["matriculadosgrupo"];
			
			require("calculoestudiantesinscritos.php");
			$valor_prematriculados = $total_prematriculados + $total_prematriculados2;
			$matriculadosgrupo =  $valor_prematriculados + $total_matriculados;
			echo "<tr align='center'>
				<td><font size='2' face='Tahoma'><a href='listagruposmostrar.php?idgrupo=$idgrupo&codigo=$codigomateria&codigogrupo=$codigogrupo&nombregrupo=$nombregrupo&maximogrupo=$maximogrupo&matriculadosgrupo=$matriculadosgrupo&matriculados=$total_matriculados&prematriculados=$valor_prematriculados'>$nombremateria&nbsp;</a></td>
				<td><font size='2' face='Tahoma'>$codigomateria&nbsp;</td>
				<td><font size='2' face='Tahoma'>$idgrupo&nbsp;</a></td>
				<td><font size='2' face='Tahoma'>$nombregrupo&nbsp;</td>
				<td><font size='2' face='Tahoma'>$maximogrupo&nbsp;</td>
				<td><font size='2' face='Tahoma'>$valor_prematriculados&nbsp;</td>
				<td><font size='2' face='Tahoma'>$total_matriculados&nbsp;</td>
				<td><font size='2' face='Tahoma'>$matriculadosgrupo&nbsp;</td>
			</tr>";
		}
	}
	else
	{
		echo "<table><tr><font size='2' face='Tahoma'><td align='center'>No se encontro ningún resultado</td><tr>";
	}
?>
</table>
<?php
}
?>
</form>
</div>
</body>
</html>
