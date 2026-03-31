<?php 
ini_set("include_path", ".:/usr/share/pear_"); 
/** USA LAS SIGUIENTES VARIABLES DE SESION
	GENERALES:
	$_SESSION['carrera']
*/
require_once('../../../Connections/sala2.php');
require_once('../funciones/validacion.php');
require('calendario/calendario.php');
mysql_select_db($database_sala, $sala);
session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php'); 
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
$aplicararp = "";
if(isset($_GET['aplicaarp']))
{
	$aplicararp = "&aplicaarp";
}

$strperidosesion = "";
if(isset($_SESSION['codigoperiodosesion']))
{
	$strperidosesion = "and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'";
}
			
if($_SESSION['MM_Username'] == 'admintecnologia' || $_SESSION['MM_Username'] == 'admincredito')
{
	session_unregister($_SESSION['codigofacultad']);
	unset($_SESSION['codigofacultad']);
}
$codigocarrera = $_SESSION['codigofacultad'];
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
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
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
		window.location.reload("busqueda_estudiante.php?busqueda=nombre<?php if(isset($_GET['aplicaarp'])){echo $aplicararp;}?>"); 
	} 
    if (tipo == 2)
	{
		window.location.reload("busqueda_estudiante.php?busqueda=apellido<?php if(isset($_GET['aplicaarp'])){echo $aplicararp;}?>"); 
	} 
    if (tipo == 3)
	{
		window.location.reload("busqueda_estudiante.php?busqueda=codigo<?php if(isset($_GET['aplicaarp'])){echo $aplicararp;}?>"); 
    } 
    if (tipo == 4)
	{
		window.location.reload("busqueda_estudiante.php?busqueda=documento<?php if(isset($_GET['aplicaarp'])){echo $aplicararp;}?>"); 
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
		window.location.reload("busqueda_estudiante.php?buscar="+busca); 
	} 
} 
</script>

<body>
<div align="center">
<form name="f1" action="busqueda_estudiante.php" method="get">
  <p class="Estilo3">CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="199" bgcolor="#C5D5D6" class="Estilo2"align="center">Búsqueda por:
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
    <td align="center" class="Estilo1"><?php echo $fechahoy=date("Y-m-d");?>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="4" align="center" class="Estilo2"><strong>Toda la Universidad <input type="radio" name="tipobusqueda" checked value="Universidad">&nbsp;
	Toda la Facultad <input type="radio" name="tipobusqueda" checked value="Facultad"></strong></td>
  </tr>
  <tr>
  	<td colspan="4" align="center" class="Estilo2"><strong>Periodo de Ingreso:
<?php
$query_selperiodos = "select p.codigoperiodo, p.nombreperiodo
from periodo p, carreraperiodo cp
where cp.codigocarrera = '$codigocarrera'
and p.codigoperiodo = cp.codigoperiodo
ORDER BY p.codigoperiodo DESC";
$selperiodos = mysql_query($query_selperiodos, $sala) or die("$query_selperiodos".mysql_error());
$totalRows_selperiodos = mysql_num_rows($selperiodos);
if($totalRows_selperiodos == "")
{
	$query_selperiodos = "select p.codigoperiodo, p.nombreperiodo
	from periodo p
	ORDER BY p.codigoperiodo DESC";
	$selperiodos = mysql_query($query_selperiodos, $sala) or die("$query_selperiodos".mysql_error());
	$totalRows_selperiodos = mysql_num_rows($selperiodos);
}
?>  
	  <select name="periodo">
		<option value="0" selected>Todos</option>
<?php
while($row_selperiodos = mysql_fetch_assoc($selperiodos))
{
?>
		<option value="<?php echo $row_selperiodos['codigoperiodo'];?>"><?php echo $row_selperiodos['nombreperiodo'];?></option>
<?php
}
?>	  </select>
	</strong>
	</td>
  </tr>
  <tr>
  	<td colspan="4" align="center" class="Estilo1">
	<?php 
	if(isset($_GET['aplicaarp']))
	{
	?>
	<input type="hidden" name="aplicaarp" value="<?php echo $_GET['aplicaarp'];?>">
	<?php
	}
	?>
	<input name="buscar" type="submit" value="Buscar">&nbsp;
	</td>
  </tr>
  <?php
  }
  if(isset($_GET['buscar']))
  {
  ?>
</table>
<p align="center" class="Estilo2">Seleccione el estudiante que desee consultar de la siguiente tabla:</p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr class="Estilo2">
    <td align="center" bgcolor="#C5D5D6">Nombre Estudiante</td>
    <td align="center" bgcolor="#C5D5D6">Documento</td>	
	<td align="center" bgcolor="#C5D5D6">Periodo de Ingreso</td>	
  </tr>
<?php
  	$vacio = false;
	$strperiodo = "";
	if($_GET['periodo'] != "0")
	{
		$strperiodo = "and est.codigoperiodo = '".$_GET['periodo']."'";
	}
	//echo $strperiodo;
	//exit;
	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];

		if($_GET['tipobusqueda'] == "Universidad")
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.numerodocumento, p.nombreperiodo
			FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo p 
			WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'		
			$strperidosesion
			and eg.idestudiantegeneral = est.idestudiantegeneral
			and ed.idestudiantegeneral = eg.idestudiantegeneral
			and c.codigocarrera = est.codigocarrera
			and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			$strperiodo
			and est.codigoperiodo = p.codigoperiodo
			ORDER BY 3, est.codigoperiodo";
			//and est.codigosituacioncarreraestudiante not like '1%'
			//and est.codigosituacioncarreraestudiante not like '5%'
		}
		if($_GET['tipobusqueda'] == "Facultad")
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre, eg.numerodocumento, p.nombreperiodo
			FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo p 
			WHERE eg.nombresestudiantegeneral LIKE '%$nombre%'		
			$strperidosesion
			and eg.idestudiantegeneral = est.idestudiantegeneral
			and ed.idestudiantegeneral = eg.idestudiantegeneral
			and c.codigocarrera = est.codigocarrera
			and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			and est.codigocarrera = '".$_SESSION['codigofacultad']."'
			$strperiodo
			and est.codigoperiodo = p.codigoperiodo
			ORDER BY 2";
			//and est.codigosituacioncarreraestudiante not like '1%'
			//and est.codigosituacioncarreraestudiante not like '5%'
		}
		$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud".mysql_error());
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_apellido']))
	{
		$apellido = $_GET['busqueda_apellido'];
		if($_GET['tipobusqueda'] == "Universidad")
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.numerodocumento, p.nombreperiodo
			FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo p  
			WHERE eg.apellidosestudiantegeneral LIKE '$apellido%'		
			$strperidosesion
			and eg.idestudiantegeneral = est.idestudiantegeneral
			and ed.idestudiantegeneral = eg.idestudiantegeneral
			and c.codigocarrera = est.codigocarrera
			and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			$strperiodo
			and est.codigoperiodo = p.codigoperiodo
			ORDER BY 3, est.codigoperiodo";
			//and est.codigosituacioncarreraestudiante not like '1%'
			//and est.codigosituacioncarreraestudiante not like '5%'
			//AND est.codigocarrera = '$codigocarrera'
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		}
		if($_GET['tipobusqueda'] == "Facultad")
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.numerodocumento, p.nombreperiodo
			FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo p 
			WHERE eg.apellidosestudiantegeneral LIKE '$apellido%'		
			$strperidosesion
			and eg.idestudiantegeneral = est.idestudiantegeneral
			and ed.idestudiantegeneral = eg.idestudiantegeneral
			and c.codigocarrera = est.codigocarrera
			and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			and est.codigocarrera = '".$_SESSION['codigofacultad']."'
			$strperiodo
			and est.codigoperiodo = p.codigoperiodo
			ORDER BY 2";
			//and est.codigosituacioncarreraestudiante not like '1%'
			//and est.codigosituacioncarreraestudiante not like '5%'
			//AND est.codigocarrera = '$codigocarrera'
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		}
		if($_GET['busqueda_apellido'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_documento']))
	{
		$documento = $_GET['busqueda_documento'];
		if($_GET['tipobusqueda'] == "Universidad")
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.numerodocumento, p.nombreperiodo
			FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo p 
			WHERE ed.numerodocumento LIKE '$documento%'		
			$strperidosesion
			and eg.idestudiantegeneral = est.idestudiantegeneral
			and ed.idestudiantegeneral = eg.idestudiantegeneral
			and c.codigocarrera = est.codigocarrera
			and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			$strperiodo
			and est.codigoperiodo = p.codigoperiodo
			ORDER BY 3, est.codigoperiodo";
			//and est.codigosituacioncarreraestudiante not like '1%'
			//and est.codigosituacioncarreraestudiante not like '5%'
			//AND est.codigocarrera = '$codigocarrera'
			//echo "$query_solicitud<br>";
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		}
		if($_GET['tipobusqueda'] == "Facultad")
		{
			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.numerodocumento, p.nombreperiodo
			FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c, periodo p  
			WHERE ed.numerodocumento LIKE '$documento%'		
			$strperidosesion
			and eg.idestudiantegeneral = est.idestudiantegeneral
			and ed.idestudiantegeneral = eg.idestudiantegeneral
			and c.codigocarrera = est.codigocarrera
			and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
			and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
			and est.codigocarrera = '".$_SESSION['codigofacultad']."'
			$strperiodo
			and est.codigoperiodo = p.codigoperiodo
			ORDER BY 2";
			//and est.codigosituacioncarreraestudiante not like '1%'
			//and est.codigosituacioncarreraestudiante not like '5%'
			//AND est.codigocarrera = '$codigocarrera'
			//echo "$query_solicitud<br>";
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		}
		if($_GET['busqueda_documento'] == "")
			$vacio = true;
	}
	//if(!$vacio)
	//{
		//echo "<br>$query_solicitud<br>";
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
			$idestudiantegeneral = $solicitud["idestudiantegeneral"];
			$codigoestudiante = $solicitud["numerodocumento"];
			$nombre = $solicitud["nombre"];
			$numerodocumento = $solicitud["numerodocumento"];			
			$nombreperiodo = $solicitud["nombreperiodo"];			
			if(!isset($_GET['aplicaarp']))
			{
				echo "<tr>
					<td class='Estilo1'><a href='estudiante.php?codigocreado=$codigoestudiante'>$nombre&nbsp;</a></td>
					<td class='Estilo1' align='center'>$numerodocumento&nbsp;</td>
					<td class='Estilo1'>$nombreperiodo&nbsp;</td>				
					</tr>";
			}
			else
			{
				echo "<tr>
					<td class='Estilo1'><a href='estudiante.php?idestudiantegeneral=$idestudiantegeneral'>$nombre&nbsp;</a></td>
					<td class='Estilo1' align='center'>$numerodocumento&nbsp;</td>
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
