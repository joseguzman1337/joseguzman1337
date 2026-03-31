<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
/** USA LAS SIGUIENTES VARIABLES DE SESION
	GENERALES:
	$_SESSION['carrera']
*/
require_once('../../../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);
session_start();
require_once('../seguridadplandeestudio.php');
$codigocarrera = $_SESSION['codigofacultad'];

/*require_once('../../../funciones/funcionvalidaingresopagina.php');
if(!validaringresopagina($_SESSION['MM_Username'], $_SERVER['PHP_SELF'], $sala))
{
?>
<script>
	window.location.href="../login.php";
</script>
<?php
}
*/
foreach($_POST as $materia => $valor)
{
   	$asignacion = "\$" . $materia . "='" . $valor . "';";
	//echo $asignacion."<br>";
}
?>
<html>
<head>
<title>Asignación Plan Estudio Estudiante</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
-->
</style>
</head>
<?php echo'
<script language="javascript">
function cambia_tipo()
{
    //tomo el valor del select del tipo elegido
    var tipo
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value
    //miro a ver si el tipo está definido
    if (tipo == 1)
	{
		window.location.href="asignacionplanestudioestudiante.php?busqueda=nombre&planestudio='.$_GET['planestudio'].'";
	}
    if (tipo == 2)
	{
		window.location.href="asignacionplanestudioestudiante.php?busqueda=apellido&planestudio='.$_GET['planestudio'].'";
	}
    if (tipo == 3)
	{
		window.location.href="asignacionplanestudioestudiante.php?busqueda=codigo&planestudio='.$_GET['planestudio'].'";
    }
    if (tipo == 4)
	{
		window.location.href="asignacionplanestudioestudiante.php?busqueda=documento&planestudio='.$_GET['planestudio'].'";
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
		window.location.href="asignacionplanestudioestudiante.php?planestudio='.$_GET['planestudio'].'&buscar="+busca;
	}
}
</script>';
?>
<body>
<div align="center">
<form name="f1" action="asignacionplanestudioestudiante.php" method="get">
  <p class="Estilo1"><strong>CRITERIO DE B&Uacute;SQUEDA DE ESTUDIANTE </strong></p>
  <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="250" class="Estilo1">
	<strong>Búsqueda por:</strong>	<select name="tipo" onChange="cambia_tipo()">
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
    <td class="Estilo1"><strong>Fecha: </strong></td>
    <td class="Estilo1"><?php echo $fechahoy=date("Y-m-d");?>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="4" align="center" class="Estilo1">
	<input type="hidden" value="<?php echo $_GET['planestudio'];?>" name="planestudio">
	<input name="buscar" type="submit" value="Buscar">&nbsp;</td>
  </tr>
  <?php
  }
?>
 <tr>
  <td colspan="4" align="center"><input type="button" name="cancelar" value="Cancelar" onClick="window.location.href='../plandeestudioinicial.php'"></td>
  </tr>
<?php
  if(isset($_GET['buscar']))
  {
  ?>
 </table>
<p align="center" class="Estilo1"><strong>Seleccione el estudiante al que le va asignar el plan de estudio de la siguiente tabla : </strong></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" class="Estilo1"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Cédula</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Código</strong>&nbsp;</td>
  </tr>
<?php
  	$vacio = false;
	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];
		$query_solicitud = "SELECT est.*
		FROM estudiante est
		WHERE est.nombresestudiante LIKE '$nombre%'
		AND est.codigocarrera = '$codigocarrera'
		and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
		ORDER BY est.apellidosestudiante";
		//and est.codigosituacioncarreraestudiante not like '1%'
		//and est.codigosituacioncarreraestudiante not like '5%'
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_apellido']))
	{
		$apellido = $_GET['busqueda_apellido'];
		$query_solicitud = "SELECT est.*
		FROM estudiante est
		WHERE est.apellidosestudiante LIKE '$apellido%'
		AND est.codigocarrera = '$codigocarrera'
		and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
		ORDER BY est.apellidosestudiante";
		//and est.codigosituacioncarreraestudiante not like '1%'
		//and est.codigosituacioncarreraestudiante not like '5%'
		//AND est.codigocarrera = '$codigocarrera'
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_apellido'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_codigo']))
	{
		$codigo = $_GET['busqueda_codigo'];
		$query_solicitud = "SELECT est.*
		FROM estudiante est
		WHERE est.codigoestudiante LIKE '$codigo%'
		AND est.codigocarrera = '$codigocarrera'
		and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
		ORDER BY est.apellidosestudiante";
		//and est.codigosituacioncarreraestudiante not like '1%'
		//and est.codigosituacioncarreraestudiante not like '5%'
		//AND est.codigocarrera = '$codigocarrera'
		//echo "$query_solicitud";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_codigo'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_documento']))
	{
		$documento = $_GET['busqueda_documento'];
		$query_solicitud = "SELECT est.*
		FROM estudiante est
		WHERE est.numerodocumento LIKE '$documento%'
		AND est.codigocarrera = '$codigocarrera'
		and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
		ORDER BY est.apellidosestudiante";
		//and est.codigosituacioncarreraestudiante not like '1%'
		//and est.codigosituacioncarreraestudiante not like '5%'
		//AND est.codigocarrera = '$codigocarrera'
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_documento'] == "")
			$vacio = true;
	}
	if(!$vacio)
	{
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
?>
			<tr>
<?php
			$est = $solicitud["apellidosestudiante"]." ".$solicitud["nombresestudiante"];
			$cc = $solicitud["numerodocumento"];
			$cod = $solicitud["codigoestudiante"];
			$query_planesestudioestudiante = "select p.idplanestudio
			from planestudioestudiante p
			where p.codigoestudiante = '$cod'
			and p.codigoestadoplanestudioestudiante = '101'";
			$planesestudioestudiante = mysql_query($query_planesestudioestudiante, $sala) or die("$query_planesestudioestudiante");
			$totalRows_planesestudioestudiante = mysql_num_rows($planesestudioestudiante);
			if($totalRows_planesestudioestudiante == "")
			{

?>
				<td><?php echo "<a href='nuevoplanestudioestudiante.php?estudiante=$cod&planestudio=".$_GET['planestudio']."'>$est&nbsp;</a>";?></td>
<?php
			}
			else
			{
				echo "<td><a href='editarplanestudioestudiante.php?estudiante=$cod&planestudio=".$_GET['planestudio']."'>$est&nbsp;</a></td>";
			}
?>
				<td>
<?php
 			echo "$cc&nbsp;";
?>
				</td>
				<td>
<?php
			echo "$cod&nbsp;";
?>
				</td>
<?php
		}
?>
			</tr>
<?php
	}
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
