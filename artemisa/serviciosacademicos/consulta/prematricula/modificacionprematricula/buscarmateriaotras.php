<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/validacion.php');
require_once('../../../funciones/errores_horario.php');
mysql_select_db($database_sala, $sala);
session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php' );
//require_once('seguridadmateriasgrupos.php');
//$idplanestudio = $_GET['planestudio'];
$codigocarrera = $_SESSION['codigofacultad'];
$codigoperiodo  = $_SESSION['codigoperiodosesion'];
//echo "<br>".$_SESSION['materiascargasesion']."<br>";
//echo strlen($_GET['matequitar']);
//echo $idplanestudio;
//$dirini = "?codigomateria1=$codigomateria&carrera1=$carrera";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Buscar Materia</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: 9px;
}
.Estilo2 {font-size: 14px}
.Estilo3 {font-family: Tahoma; font-size: 12px; }
.Estilo4 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
-->
</style>
</head>
<body>
<?php echo '
<script language="javascript">
function cambia_tipo()
{
    //tomo el valor del select del tipo elegido
    var tipo
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value
    //miro a ver si el tipo está definido
    if (tipo == 1)
	{
		window.location.href="buscarmateriaotras.php?planestudio='.$idplanestudio.'&busqueda=nombre";
	}
    if (tipo == 2)
	{
		window.location.href="buscarmateriaotras.php?planestudio='.$idplanestudio.'&busqueda=codigo";
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
		window.location.href="buscarmateriaotras.php?planestudio='.$idplanestudio.'&"+busca;
	}
}
</script>';
?>
<div align="center">
<form name="f1" action="buscarmateriaotras.php" method="get">
  <p class="Estilo1 Estilo2"><strong>B&Uacute;SQUEDA DE MATERIA OTRAS</strong></p>
  <table width="500" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="200" bgcolor="#C5D5D6" class="Estilo3">
	  <div align="center"><strong>Búsqueda por:</strong>	      <select name="tipo" onChange="cambia_tipo()">
		    <option value="0">Seleccionar</option>
		    <option value="1">Nombre</option>
		    <option value="2">Código</option>
	        </select>
	</div></td>
	<td width="283" class="Estilo4">&nbsp;
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
  	<td colspan="2" align="center" class="Estilo1"><input name="buscar" type="submit" value="Buscar">&nbsp;<input type="button" value="Cancelar" onClick="window.close()"></td>
  </tr>
<?php
}
?>
<tr>
<td align="center" colspan="2">
<p align="center" class="Estilo1"><input type="button" value="Regresar" onClick="window.location.href='buscarmateria.php'"></p>
</td>
</tr>
<?php
if(isset($_GET['buscar']))
{
?>
</table>
<p align="center" class="Estilo3"><strong>Seleccione la materia de la siguiente tabla</strong></p>
<table width="500" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" bgcolor="#C5D5D6" class="Estilo3"><strong>Código Materia</strong>&nbsp;</td>
    <td align="center" bgcolor="#C5D5D6" class="Estilo3"><strong>Nombre Materia</strong>&nbsp;</td>
	<td align="center" bgcolor="#C5D5D6" class="Estilo3"><strong>Carrera</strong>&nbsp;</td>
  </tr>
<?php
	$vacio = false;
	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];
		$query_solicitud = "select DISTINCT m.nombremateria, m.codigomateria, c.nombrecarrera, pee.idplanestudio
		from grupomateria g, detallegrupomateria d, materia m, carrera c, planestudioestudiante pee
		where g.codigoperiodo = '$codigoperiodo'
		and g.codigotipogrupomateria not like '100'
		and m.nombremateria like '%$nombre%'
		and d.idgrupomateria = g.idgrupomateria
		and m.codigomateria = d.codigomateria
		".$_SESSION['materiascargasesion']."
		and c.codigocarrera = m.codigocarrera
		and pee.codigoestudiante = '".$_SESSION['codigo']."'
		order by m.nombremateria";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_nombre'] == "")
			$vacio = false;
	}
	if(isset($_GET['busqueda_codigo']))
	{
		$codigoest = $_GET['busqueda_codigo'];
		$query_solicitud = "select DISTINCT m.nombremateria, m.codigomateria, c.nombrecarrera, pee.idplanestudio
		from grupomateria g, detallegrupomateria d, materia m, carrera c, planestudioestudiante pee
		where g.codigoperiodo = '$codigoperiodo'
		and g.codigotipogrupomateria not like '100'
		and d.idgrupomateria = g.idgrupomateria
		and m.codigomateria like '$codigoest%'
		".$_SESSION['materiascargasesion']."
		and c.codigocarrera = m.codigocarrera
		and pee.codigoestudiante = '".$_SESSION['codigo']."'
		order by m.nombremateria";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_codigo'] == "")
			$vacio = false;
	}
	if(!$vacio)
	{
		//echo "$query_solicitud<br>";

		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
			$nombremateria = $solicitud["nombremateria"];
			$codigomateria = $solicitud["codigomateria"];
			$nombrecarrera = $solicitud["nombrecarrera"];
			$nombreplanestudio = $solicitud["nombreplanestudio"];
			$numerocreditos = $solicitud["numerocreditos"];
			$semestredetalleplanestudio = $solicitud["semestredetalleplanestudio"];
			$idplanestudio = $solicitud["idplanestudio"];
			echo "<tr>
				<td class='Estilo1'><a href='buscarmateriaotras.php?aceptar=$codigomateria&idplan=$idplanestudio'>$codigomateria&nbsp;</a></td>
				<td class='Estilo1'>$nombremateria&nbsp;</td>
				<td class='Estilo1'>$nombrecarrera&nbsp;</td>
			</tr>";
		}
		echo '<tr><td colspan="6" align="center"><input type="button" value="Cancelar" onClick="window.close()"></td></tr>';
	}
?>
</table>
<p align="center" class="Estilo1">
<?php
}
/*		echo "<script language='javascript'>  window.location.href='creditos.php?busqueda_credito=".$sol."&buscar=Buscar'</script>";
*/
if(isset($_GET['aceptar']))
{
	$idplanestudio = $_GET['idplan'];
	$materiaseleccionada = $_GET['aceptar'];
	//echo "?programausadopor=facultad = $materiaseleccionada";
	//exit();
	$codigoperiodo = $_SESSION['codigoperiodosesion'];
	$usuario = $_SESSION['MM_Username'];
	$codigoest = $_SESSION['codigo'];
	/*$query_selplanestudio="select p.idplanestudio, e.codigocarrera
	from planestudioestudiante p, estudiante e
	where p.codigoestudiante = '$codigo'
	and p.codigoestadoplanestudioestudiante like '1%'
	and e.codigoestudiante = p.codigoestudiante";
	//echo "<br> $query_selplanestudio<br>";
	//exit();
	$selplanestudio=mysql_db_query($database_sala,$query_selplanestudio) or die("$query_selplanestudio");
	//$totalRows_idprem = mysql_num_rows($idprem);
	$row_selplanestudio=mysql_fetch_array($selplanestudio);
	$idplanestudio = $row_selplanestudio['idplanestudio'];
	*/

	$query_inscarga="INSERT INTO cargaacademica(idcargaacademica, codigoestudiante, codigomateria, codigoperiodo, idplanestudio, usuario, fechacargaacademica, codigoestadocargaacademica)
    VALUES(0, '$codigoest', '$materiaseleccionada', '$codigoperiodo', '$idplanestudio', '$usuario', '2005-3-18 5:44:5.0', '100')";
	//echo "<br> $query_inscarga";
	$inscarga=mysql_db_query($database_sala,$query_inscarga) or die("$query_inscarga".mysql_error());
	//exit();
	echo "<script language='javascript'>
			window.opener.actualizar('?programausadopor=facultad');
			window.opener.focus();
			window.close();
	  </script>";
}
?>
</p>
</form>
</div>
</body>
</html>
