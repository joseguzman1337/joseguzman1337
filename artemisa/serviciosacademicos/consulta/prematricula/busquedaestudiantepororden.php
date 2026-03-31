<?php
/** USA LAS SIGUIENTES VARIABLES DE SESION
	GENERALES:
	$_SESSION['carrera']
*/
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);
@session_start();
require_once(realpath(dirname(__FILE__)).'/../../funciones/clases/autenticacion/redirect.php' );

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
<meta http-equiv="pragma" content="no-cache"/>
<meta http-equiv="cache-control" content="no-cache"/>
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
		window.location.href="busquedaestudiantepororden.php?busqueda=nombre<?php if(isset($_GET['aplicaarp'])){echo $aplicararp;}?>";
	}
    if (tipo == 2)
	{
		window.location.href="busquedaestudiantepororden.php?busqueda=apellido<?php if(isset($_GET['aplicaarp'])){echo $aplicararp;}?>";
	}
    if (tipo == 3)
	{
		window.location.href="busquedaestudiantepororden.php?busqueda=codigo<?php if(isset($_GET['aplicaarp'])){echo $aplicararp;}?>";
    }
    if (tipo == 4)
	{
		window.location.href="busquedaestudiantepororden.php?busqueda=documento<?php if(isset($_GET['aplicaarp'])){echo $aplicararp;}?>";
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
		window.location.href="busquedaestudiantepororden.php?buscar="+busca;
	}
}
</script>

<body>
<div align="center">
<form name="f1" action="busquedaestudiantepororden.php" method="get">
  <p class="Estilo3">CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="199" bgcolor="#C5D5D6" class="Estilo2"align="center">Búsqueda por:
	    <select name="tipo" onChange="cambia_tipo()">
	            <option value="0">Seleccionar</option>
	            <option value="1">Interlocutor</option>
	            <option value="2">Orden Pago</option>
	            <!-- <option value="3">Código</option> -->
	           <!--  <option value="4">Documento</option> -->
                </select>
	  </td>
	<td class="Estilo2">&nbsp;
	<?php
		if(isset($_GET['busqueda']))
		{
			if($_GET['busqueda']=="nombre")
			{
				echo "<strong>Interlocutor : </strong><input name='busqueda_nombre' type='text'>";
			}
			if($_GET['busqueda']=="apellido")
			{
				echo "<strong>Orden Pago : </strong><input name='busqueda_apellido' type='text'>";
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
<p align="center" class="Estilo2">Se encontraron los siguientes registros:</p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr class="Estilo2">
    <td align="center" bgcolor="#C5D5D6">Interlocutor</td>
    <td align="center" bgcolor="#C5D5D6">Documento</td>
	<td align="center" bgcolor="#C5D5D6">Nombre Estudiante</td>
	<td align="center" bgcolor="#C5D5D6">Facultad</td>
	<td align="center" bgcolor="#C5D5D6">Orden</td>
	<td align="center" bgcolor="#C5D5D6">Estado Orden</td>
	
  </tr>
<?php
  	$vacio = false;
	$strperiodo = "";

	if(isset($_GET['busqueda_nombre']))
	{
		$inter = $_GET['busqueda_nombre'];


			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.numerodocumento,o.codigoestudiante, o.codigoperiodo,c.nombrecarrera,numeroordenpago,codigoestadoordenpago
			FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c,ordenpago o
			WHERE eg.idestudiantegeneral = $inter
			AND eg.idestudiantegeneral = est.idestudiantegeneral
			AND ed.idestudiantegeneral = eg.idestudiantegeneral
			AND c.codigocarrera = est.codigocarrera
			AND o.codigoestudiante = est.codigoestudiante
			order by numeroordenpago desc";
		  //echo $query_solicitud;
		$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud".mysql_error());
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_apellido']))
	{
		$ordenpa = $_GET['busqueda_apellido'];

			$query_solicitud = "SELECT DISTINCT eg.idestudiantegeneral, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre,eg.numerodocumento, o.codigoestudiante, o.codigoperiodo, c.nombrecarrera,numeroordenpago,codigoestadoordenpago
			FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, carrera c,ordenpago o
			WHERE o.numeroordenpago  = $ordenpa
			AND eg.idestudiantegeneral = est.idestudiantegeneral
			AND ed.idestudiantegeneral = eg.idestudiantegeneral
			AND c.codigocarrera = est.codigocarrera
			AND o.codigoestudiante = est.codigoestudiante
			order by numeroordenpago desc";
			//echo $query_solicitud;
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());

		if($_GET['busqueda_apellido'] == "")
			$vacio = true;
	}

	//if(!$vacio)
	//{
		//echo "<br>$query_solicitud<br>";
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
			$idestudiantegeneral = $solicitud["idestudiantegeneral"];
			$orden = $solicitud["numeroordenpago"];
			$nombre = $solicitud["nombre"];
			$numerodocumento = $solicitud["numerodocumento"];
			$carrera = $solicitud["nombrecarrera"];
			$codigoestudiante = $solicitud["codigoestudiante"];
			$codigoperiodo =  $solicitud["codigoperiodo"];

			$query_solicitud2 = "SELECT * from estadoordenpago where codigoestadoordenpago = '".$solicitud["codigoestadoordenpago"]."'";
			//echo $query_solicitud2;
			$res_solicitud2 = mysql_query($query_solicitud2, $sala) or die(mysql_error());
			$solicitud2 = mysql_fetch_assoc($res_solicitud2);

			$estado = $solicitud2["nombreestadoordenpago"];

				echo "<tr>
					<td class='Estilo1'>$idestudiantegeneral&nbsp;</a></td>
					<td class='Estilo1'>$numerodocumento&nbsp;</td>
					<td class='Estilo1'>$nombre&nbsp;</a></td>
					<td class='Estilo1'>$carrera&nbsp;</td>
					<td class='Estilo1'><a href='../../funciones/ordenpago/verorden.php?numeroordenpago=$orden&codigoestudiante=$codigoestudiante&codigoperiodo=$codigoperiodo'>$orden&nbsp;</td>
					<td class='Estilo1'>$estado&nbsp;</td>
					
					</tr>";
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