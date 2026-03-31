<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
/** USA LAS SIGUIENTES VARIABLES DE SESION
	GENERALES:
	$_SESSION['carrera']
*/
require_once('../../../Connections/sala2.php' ); 
mysql_select_db($database_sala, $sala);
session_start();
//require_once('seguridadprematricula.php');

/*require_once('../../../funciones/funcionvalidaingresopagina.php');
if(!validaringresopagina($_SESSION['MM_Username'], $_SERVER['PHP_SELF'], $sala))
{
?>
<script>
	window.location.reload("../login.php");
</script>
<?php
}
*/
if($_SESSION['MM_Username'] == 'admintecnologia' || $_SESSION['MM_Username'] == 'admincredito')
{
	session_unregister($_SESSION['codigofacultad']);
	unset($_SESSION['codigofacultad']);
}
$codigocarrera = $_SESSION['codigofacultad'];
if(isset($_GET['graduandos']))
{
	$tipocarta = "graduandos";
}
else if(isset($_GET['puestos']))
{
	$tipocarta = "puestos";
}
//echo "<h1>$tipocarta</h1>";
foreach($_POST as $materia => $valor)
{ 
   	$asignacion = "\$" . $materia . "='" . $valor . "';"; 
	//echo $asignacion."<br>";
}

?>
<html>
<head>
<title>Busqueda estudiante</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
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
		window.location.reload("cartasbusqueda.php?busqueda=nombre<?php echo "&$tipocarta";?>"); 
	} 
    if (tipo == 2)
	{
		window.location.reload("cartasbusqueda.php?busqueda=apellido<?php echo "&$tipocarta";?>"); 
	} 
    if (tipo == 3)
	{
		window.location.reload("cartasbusqueda.php?busqueda=codigo<?php echo "&$tipocarta";?>"); 
    } 
    if (tipo == 4)
	{
		window.location.reload("cartasbusqueda.php?busqueda=documento<?php echo "&$tipocarta";?>"); 
    } 
} 

/*function buscar()
{ 
    //tomo el valor del select del tipo elegido 
    var busca 
    busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value 
    //miro a ver si el tipo está definido 
    if (busca != 0)
	{
		window.location.reload("cartasbusqueda.php?buscar="+busca); 
	} 
} */
</script>

<body>
<div align="center">
<form name="f1" action="cartasbusqueda.php<?php echo "?$tipocarta";?>" method="get">
<input type="hidden" name="<?php echo "$tipocarta";?>">
  <p class="Estilo3"><strong>CRITERIO DE B&Uacute;SQUEDA</strong></p>
  <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="199" bgcolor="#C5D5D6" class="Estilo2">Búsqueda por:	        
	      <select name="tipo" onChange="cambia_tipo()">
	            <option value="0">Seleccionar</option>
	            <option value="1">Nombre</option>
	            <option value="2">Apellido</option>
	            <!-- <option value="3">Código</option> -->
	            <option value="4">Documento</option>
          </select>
	  </td>
	<td class="Estilo2">&nbsp;
	<?php
		if(isset($_GET['busqueda']))
		{
			if($_GET['busqueda']=="nombre")
			{
				echo "<strong>Digite un Nombre : </strong><input name='busqueda_nombre' type='text'>";
			}
			if($_GET['busqueda']=="apellido")
			{
				echo "<strong>Digite un Apellido : </strong><input name='busqueda_apellido' type='text'>";
			}
			if($_GET['busqueda']=="codigo")
			{
				echo "<strong>Digite un Código : </strong><input name='busqueda_codigo' type='text'>";
			}
			if($_GET['busqueda']=="documento")
			{
				echo "<strong>Digite Documento o Código: </strong><input name='busqueda_documento' type='text'>";
			}
			if($_GET['busqueda']=="credito")
			{
				echo "Digite un Número de Credito : <input name='busqueda_credito' type='text'>";
			}
	?>
	<div align="center"></div></td>
    <td bgcolor="#C5D5D6" class="Estilo2" align="center">Fecha</td>
    <td align="center" class="Estilo1"><?php echo $fechahoy=date("Y-m-d");?>&nbsp;
      <div align="center"></div>
      <div align="center"></div></td>
  </tr>
  <tr>
  	<td colspan="4" align="center" class="Estilo1"><input name="buscar" type="submit" value="Buscar">&nbsp;</td>
  </tr>
  <?php
  }
  if(isset($_GET['buscar']))
  {
  ?>
</table>
<p align="center" class="Estilo2">Seleccione el estudiante que desee consultar de la siguiente tabla: </p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr class="Estilo2">
    <td align="center" bgcolor="#C5D5D6">Nombre Estudiante&nbsp;</td>
    <td align="center" bgcolor="#C5D5D6">Documento&nbsp;</td>
	<td align="center" bgcolor="#C5D5D6">Periodo de Ingreso&nbsp;</td>
<?php
	if(isset($_GET['graduandos']))
	{
?>
	<td align="center" bgcolor="#C5D5D6" class="Estilo2">Semestre&nbsp;</td>
<?php
	}
?>
  </tr>
<?php
  	$vacio = false;
	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];
		if(isset($_GET['graduandos']))
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.numerodocumento,
			est.codigoestudiante, per.nombreperiodo, p.cantidadsemestresplanestudio, pre.semestreprematricula 
			FROM planestudio p, planestudioestudiante pee, prematricula pre, estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo per 
			WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'		
			AND est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
			AND eg.idestudiantegeneral = est.idestudiantegeneral
			AND ed.idestudiantegeneral = eg.idestudiantegeneral
			AND c.codigocarrera = est.codigocarrera
			AND ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			AND ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			AND est.codigocarrera = '$codigocarrera'
			AND per.codigoperiodo = est.codigoperiodo
			AND p.codigocarrera = est.codigocarrera
			AND p.idplanestudio = pee.idplanestudio 
			AND pre.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
			AND pre.codigoestudiante = pee.codigoestudiante
			AND pee.codigoestadoplanestudioestudiante LIKE '1%'
			AND p.codigoestadoplanestudio LIKE '1%'
			AND (pre.semestreprematricula = p.cantidadsemestresplanestudio OR pre.semestreprematricula = p.cantidadsemestresplanestudio-1)
			AND est.codigoestudiante = pre.codigoestudiante
			AND pre.codigoestadoprematricula LIKE '4%'
			ORDER BY pre.semestreprematricula, 2";
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			$totalRows_solicitud = mysql_num_rows($res_solicitud);
			if($totalRows_solicitud == "")
			{
				$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.numerodocumento, est.codigoestudiante, 
				per.nombreperiodo, p.cantidadsemestresplanestudio, est.semestre as semestreprematricula
				FROM planestudio p, planestudioestudiante pee, estudiante est, 
				estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo per 
				WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'		
				AND est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."' 
				AND eg.idestudiantegeneral = est.idestudiantegeneral 
				AND ed.idestudiantegeneral = eg.idestudiantegeneral 
				AND c.codigocarrera = est.codigocarrera 
				AND ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."' 
				AND ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."' 
				AND est.codigocarrera = '$codigocarrera' 
				AND per.codigoperiodo = est.codigoperiodo 
				AND p.codigocarrera = est.codigocarrera 
				AND p.idplanestudio = pee.idplanestudio 
				AND pee.codigoestadoplanestudioestudiante LIKE '1%' 
				AND p.codigoestadoplanestudio LIKE '1%' 
				ORDER BY 2";
				$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			}
		}
		else if(isset($_GET['puestos']))
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.numerodocumento,
			est.codigoestudiante, p.nombreperiodo
			FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo p 
			WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'		
			and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
			and eg.idestudiantegeneral = est.idestudiantegeneral
			and ed.idestudiantegeneral = eg.idestudiantegeneral
			and c.codigocarrera = est.codigocarrera
			and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			and est.codigocarrera = '$codigocarrera'
			and p.codigoperiodo = est.codigoperiodo
			ORDER BY est.codigoperiodo, 2";
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		
		}
		//and est.codigosituacioncarreraestudiante not like '1%'
		//and est.codigosituacioncarreraestudiante not like '5%'
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_apellido']))
	{
		$apellido = $_GET['busqueda_apellido'];
		if(isset($_GET['graduandos']))
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.numerodocumento,
			est.codigoestudiante, per.nombreperiodo, p.cantidadsemestresplanestudio, pre.semestreprematricula 
			FROM planestudio p, planestudioestudiante pee, prematricula pre, estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo per 
			WHERE eg.apellidosestudiantegeneral LIKE '$apellido%'		
			AND est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
			AND eg.idestudiantegeneral = est.idestudiantegeneral
			AND ed.idestudiantegeneral = eg.idestudiantegeneral
			AND c.codigocarrera = est.codigocarrera
			AND ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			AND ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			AND est.codigocarrera = '$codigocarrera'
			AND per.codigoperiodo = est.codigoperiodo
			AND p.codigocarrera = est.codigocarrera
			AND p.idplanestudio = pee.idplanestudio 
			AND pre.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
			AND pre.codigoestudiante = pee.codigoestudiante
			AND pee.codigoestadoplanestudioestudiante LIKE '1%'
			AND p.codigoestadoplanestudio LIKE '1%'
			AND (pre.semestreprematricula = p.cantidadsemestresplanestudio OR pre.semestreprematricula = p.cantidadsemestresplanestudio-1)
			AND est.codigoestudiante = pre.codigoestudiante
			AND pre.codigoestadoprematricula LIKE '4%'
			ORDER BY pre.semestreprematricula, 2";
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			$totalRows_solicitud = mysql_num_rows($res_solicitud);
			if($totalRows_solicitud == "")
			{
				$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.numerodocumento, est.codigoestudiante, 
				per.nombreperiodo, p.cantidadsemestresplanestudio, est.semestre as semestreprematricula
				FROM planestudio p, planestudioestudiante pee, estudiante est, 
				estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo per 
				WHERE eg.apellidosestudiantegeneral LIKE '$apellido%'		
				AND est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."' 
				AND eg.idestudiantegeneral = est.idestudiantegeneral 
				AND ed.idestudiantegeneral = eg.idestudiantegeneral 
				AND c.codigocarrera = est.codigocarrera 
				AND ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."' 
				AND ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."' 
				AND est.codigocarrera = '$codigocarrera' 
				AND per.codigoperiodo = est.codigoperiodo 
				AND p.codigocarrera = est.codigocarrera 
				AND p.idplanestudio = pee.idplanestudio 
				AND pee.codigoestadoplanestudioestudiante LIKE '1%' 
				AND p.codigoestadoplanestudio LIKE '1%' 
				ORDER BY 2";
				$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			}		
		}
		else if(isset($_GET['puestos']))
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.numerodocumento,
			est.codigoestudiante, p.nombreperiodo
			FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo p 
			WHERE eg.apellidosestudiantegeneral LIKE '$apellido%'		
			and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
			and eg.idestudiantegeneral = est.idestudiantegeneral
			and ed.idestudiantegeneral = eg.idestudiantegeneral
			and c.codigocarrera = est.codigocarrera
			and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			and est.codigocarrera = '$codigocarrera'
			and p.codigoperiodo = est.codigoperiodo
			ORDER BY est.codigoperiodo, 2";
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		
		}
		//and est.codigosituacioncarreraestudiante not like '1%'
		//and est.codigosituacioncarreraestudiante not like '5%'
		//AND est.codigocarrera = '$codigocarrera'
		if($_GET['busqueda_apellido'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_codigo']))
	{
		$codigo = $_GET['busqueda_codigo'];
		if(isset($_GET['graduandos']))
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.numerodocumento,
			est.codigoestudiante, per.nombreperiodo, p.cantidadsemestresplanestudio, pre.semestreprematricula 
			FROM planestudio p, planestudioestudiante pee, prematricula pre, estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo per 
			WHERE ed.numerodocumento LIKE '$codigo%'		
			AND est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
			AND eg.idestudiantegeneral = est.idestudiantegeneral
			AND ed.idestudiantegeneral = eg.idestudiantegeneral
			AND c.codigocarrera = est.codigocarrera
			AND ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			AND ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			AND est.codigocarrera = '$codigocarrera'
			AND per.codigoperiodo = est.codigoperiodo
			AND p.codigocarrera = est.codigocarrera
			AND p.idplanestudio = pee.idplanestudio 
			AND pre.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
			AND pre.codigoestudiante = pee.codigoestudiante
			AND pee.codigoestadoplanestudioestudiante LIKE '1%'
			AND p.codigoestadoplanestudio LIKE '1%'
			AND (pre.semestreprematricula = p.cantidadsemestresplanestudio OR pre.semestreprematricula = p.cantidadsemestresplanestudio-1)
			AND est.codigoestudiante = pre.codigoestudiante
			AND pre.codigoestadoprematricula LIKE '4%'
			ORDER BY pre.semestreprematricula, 2";
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			$totalRows_solicitud = mysql_num_rows($res_solicitud);
			if($totalRows_solicitud == "")
			{
				$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.numerodocumento, est.codigoestudiante, 
				per.nombreperiodo, p.cantidadsemestresplanestudio, est.semestre as semestreprematricula
				FROM planestudio p, planestudioestudiante pee, estudiante est, 
				estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo per 
				WHERE ed.numerodocumento LIKE '$codigo%'		
				AND est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."' 
				AND eg.idestudiantegeneral = est.idestudiantegeneral 
				AND ed.idestudiantegeneral = eg.idestudiantegeneral 
				AND c.codigocarrera = est.codigocarrera 
				AND ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."' 
				AND ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."' 
				AND est.codigocarrera = '$codigocarrera' 
				AND per.codigoperiodo = est.codigoperiodo 
				AND p.codigocarrera = est.codigocarrera 
				AND p.idplanestudio = pee.idplanestudio 
				AND pee.codigoestadoplanestudioestudiante LIKE '1%' 
				AND p.codigoestadoplanestudio LIKE '1%' 
				ORDER BY 2";
				$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			}
		
		}
		else if(isset($_GET['puestos']))
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.numerodocumento,
			est.codigoestudiante, p.nombreperiodo
			FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo p 
			WHERE ed.numerodocumento LIKE '$codigo%'		
			and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
			and eg.idestudiantegeneral = est.idestudiantegeneral
			and ed.idestudiantegeneral = eg.idestudiantegeneral
			and c.codigocarrera = est.codigocarrera
			and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			and est.codigocarrera = '$codigocarrera'
			and p.codigoperiodo = est.codigoperiodo
			ORDER BY est.codigoperiodo, 2";
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		
		}
		//and est.codigosituacioncarreraestudiante not like '1%'
		//and est.codigosituacioncarreraestudiante not like '5%'
		//AND est.codigocarrera = '$codigocarrera'
		//echo "$query_solicitud";
		if($_GET['busqueda_codigo'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_documento']))
	{
		$documento = $_GET['busqueda_documento'];
		if(isset($_GET['graduandos']))
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.numerodocumento,
			est.codigoestudiante, per.nombreperiodo, p.cantidadsemestresplanestudio, pre.semestreprematricula 
			FROM planestudio p, planestudioestudiante pee, prematricula pre, estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo per 
			WHERE ed.numerodocumento LIKE '$documento%'		
			AND est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
			AND eg.idestudiantegeneral = est.idestudiantegeneral
			AND ed.idestudiantegeneral = eg.idestudiantegeneral
			AND c.codigocarrera = est.codigocarrera
			AND ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			AND ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			AND est.codigocarrera = '$codigocarrera'
			AND per.codigoperiodo = est.codigoperiodo
			AND p.codigocarrera = est.codigocarrera
			AND p.idplanestudio = pee.idplanestudio 
			AND pre.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
			AND pre.codigoestudiante = pee.codigoestudiante
			AND pee.codigoestadoplanestudioestudiante LIKE '1%'
			AND p.codigoestadoplanestudio LIKE '1%'
			AND (pre.semestreprematricula = p.cantidadsemestresplanestudio OR pre.semestreprematricula = p.cantidadsemestresplanestudio-1)
			AND est.codigoestudiante = pre.codigoestudiante
			AND pre.codigoestadoprematricula LIKE '4%'
			ORDER BY pre.semestreprematricula, 2";
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			$totalRows_solicitud = mysql_num_rows($res_solicitud);
			if($totalRows_solicitud == "")
			{
				$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.numerodocumento, est.codigoestudiante, 
				per.nombreperiodo, p.cantidadsemestresplanestudio, est.semestre as semestreprematricula
				FROM planestudio p, planestudioestudiante pee, estudiante est, 
				estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo per 
				WHERE ed.numerodocumento LIKE '$documento%'		
				AND est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."' 
				AND eg.idestudiantegeneral = est.idestudiantegeneral 
				AND ed.idestudiantegeneral = eg.idestudiantegeneral 
				AND c.codigocarrera = est.codigocarrera 
				AND ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."' 
				AND ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."' 
				AND est.codigocarrera = '$codigocarrera' 
				AND per.codigoperiodo = est.codigoperiodo 
				AND p.codigocarrera = est.codigocarrera 
				AND p.idplanestudio = pee.idplanestudio 
				AND pee.codigoestadoplanestudioestudiante LIKE '1%' 
				AND p.codigoestadoplanestudio LIKE '1%' 
				ORDER BY 2";
				$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			}
		
		}
		else if(isset($_GET['puestos']))
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.numerodocumento,
			est.codigoestudiante, p.nombreperiodo
			FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, documento d, carrera c, periodo p 
			WHERE ed.numerodocumento LIKE '$documento%'		
			and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
			and eg.idestudiantegeneral = est.idestudiantegeneral
			and ed.idestudiantegeneral = eg.idestudiantegeneral
			and c.codigocarrera = est.codigocarrera
			and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			and est.codigocarrera = '$codigocarrera'
			and p.codigoperiodo = est.codigoperiodo
			ORDER BY est.codigoperiodo, 2";
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		
		}
		//and est.codigosituacioncarreraestudiante not like '1%'
		//and est.codigosituacioncarreraestudiante not like '5%'
		//AND est.codigocarrera = '$codigocarrera'
		//echo "$query_solicitud<br>";
		if($_GET['busqueda_documento'] == "")
			$vacio = true;
	}
	//echo "$query_solicitud<br>";
	//if(!$vacio)
	//{
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
			$idestudiantegeneral = $solicitud["idestudiantegeneral"];
			$codigoestudiante = $solicitud["codigoestudiante"];
			$nombre = $solicitud["nombre"];
			$nombreperiodo = $solicitud["nombreperiodo"];
			$numerodocumento = $solicitud["numerodocumento"];
			if(isset($_GET['graduandos']))
			{			
				echo "<tr>
					<td class='Estilo1'><a href='cartagraduandos/cartagraduandos.php?codigoestudiante=$codigoestudiante'>$nombre&nbsp;</a></td>
					<td class='Estilo1' align='center'>$numerodocumento&nbsp;</td>				
					<td class='Estilo1'>$nombreperiodo&nbsp;</td>
					<td class='Estilo1' align='center'>".$solicitud['semestreprematricula']."&nbsp;</td>				
					</tr>";
			}
			else if(isset($_GET['puestos']))
			{
				echo "<tr>
					<td class='Estilo1'><a href='cartapuesto/cartapuesto.php?codigoestudiante=$codigoestudiante'>$nombre&nbsp;</a></td>
					<td class='Estilo1'>$numerodocumento&nbsp;</td>				
					<td class='Estilo1'>$nombreperiodo&nbsp;</td>				
					</tr>";
			}			
		}
	//}
?>
</table>
<p>
<?php
}
?>
</p>
</form>
</div>
</body>
</html>
