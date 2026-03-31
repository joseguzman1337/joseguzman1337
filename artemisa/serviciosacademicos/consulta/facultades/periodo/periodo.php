<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
//session_start();
?>
<html>
<head>
<script language="javascript">
var browser = navigator.appName;
function hRefCentral(url){
	if(url.length > 0){
		if(browser == 'Microsoft Internet Explorer'){
			parent.contenidocentral.location.href(url);
		}
		else{
			parent.contenidocentral.location=url;
		}
	}
	return true;
}

function hRefIzq(url){
	if(browser == 'Microsoft Internet Explorer'){
		parent.leftFrame.location.href(url);
	}
	else{
		parent.leftFrame.location=url;
	}
	return true;
}

function destruirFrames(url){
	parent.document.location.href=url;
}
</script>
<title>Periodo</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold; }
.Estilo4 {color: #FF6600}
-->
</style>
</head>
<body>
<div align="center">
<?php
if($_SESSION['MM_Username'] == "admintecnologia" && !isset($_GET['carreraseleccionada']))
{
	// Seleccionar la facultad de la cual se quiere tomar el periodo
	require_once('periodootro.php');
	exit;
}

$query_selperiodo = "select p.codigoperiodo, p.nombreperiodo
from periodo p
where p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
ORDER BY p.codigoperiodo DESC";
$selperiodo = mysql_query($query_selperiodo, $sala) or die(mysql_error());
$row_selperiodo = mysql_fetch_assoc($selperiodo);
$totalRows_selperiodo = mysql_num_rows($selperiodo);

if(isset($_GET['seleccion']))
{
	$_SESSION['codigoperiodosesion'] = $_GET['seleccion'];
	$_SESSION['codigoestadoperiodosesion'] = $_GET['estado'];
?>


<script language="javascript">
//window.location.reload('../consultafacultadesv2.htm');
hRefIzq('../facultadeslv2.php');
hRefCentral('../central.php');
</script>
<?php }
else{ ?>
<script language="javascript">
//window.location.reload('../consultafacultades.htm');
</script>

<?php }?>
<?php
//echo $_SESSION['codigoperiodosesion']."<br>";
//echo $_SESSION['codigoestadoperiodosesion']."<br>";
//echo $_GET['seleccion'];

?>
<form action="periodo.php" name="f1" method="get">
    
	<font face="Tahoma">
	<?php
	if(isset($_SESSION['codigoperiodosesion']))
	{
?>
	</font>
	<p class="Estilo3">Periodo actual: <?php echo $row_selperiodo['nombreperiodo'];?></p>
	<p>
	  <?php
	}
?>
      <span class="Estilo2">Seleccione el periodo que desee de la siguiente tabla</span>
    </p>
	<table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bgcolor="#C5D5D6" class="Estilo2">
      <td align="center">Periodo</td>
      <td align="center">Nombre</td>
	  <td align="center">Estado</td>
    </tr>
<?php
if(!isset($_GET['carreraseleccionada']))
{
	$query_selperiodo = "select p.codigoperiodo, e.nombreestadoperiodo, e.codigoestadoperiodo, p.nombreperiodo
	from periodo p, estadoperiodo e, carreraperiodo cp
	where p.codigoestadoperiodo = e.codigoestadoperiodo
	and cp.codigocarrera = '".$_SESSION['codigofacultad']."'
	and cp.codigoperiodo = p.codigoperiodo
	order by 1 desc";
}
else
{
	$query_selperiodo = "select p.codigoperiodo, e.nombreestadoperiodo, e.codigoestadoperiodo, p.nombreperiodo
	from periodo p, estadoperiodo e, carreraperiodo cp
	where p.codigoestadoperiodo = e.codigoestadoperiodo
	and cp.codigocarrera = '".$_GET['carreraseleccionada']."'
	and cp.codigoperiodo = p.codigoperiodo
	order by 1 desc";
}
$selperiodo = mysql_query($query_selperiodo, $sala) or die("$query_selperiodo".mysql_error());
$totalRows_selperiodo = mysql_num_rows($selperiodo);
if($totalRows_selperiodo != "")
{
	while($row_selperiodo = mysql_fetch_assoc($selperiodo))
	{
?>
    <tr class="Estilo1">
      <td align="center"><a href="periodo.php?seleccion=<?php echo $row_selperiodo['codigoperiodo']."&estado=".$row_selperiodo['codigoestadoperiodo']."&carreraseleccionada"; ?>" target="_self"><?php echo $row_selperiodo['codigoperiodo']; ?></a></td>
	  <td align="left"><font size="2" face="Tahoma"><?php echo $row_selperiodo['nombreperiodo']; ?></font></td>
	  <td align="center"><font size="2" face="Tahoma"><?php echo $row_selperiodo['nombreestadoperiodo']; ?></font></td>
    </tr>
<?php
	}
}
else
{
?>
   <tr class="Estilo1">
 	  <td align="center" colspan="3">No Existen Periodos</td>
    </tr>
<?php
}
?>
</table>
<p class="Estilo2"><font color="#804040" face="Tahoma">Al seleccionar un periodo inactivo, solamente podr&aacute;  visualizar la información<br>
  del mismo ya que no se pueden realizar modificaciones.</font></p>
</form>
</div>
</body>
</html>