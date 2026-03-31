<?php
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/validacion.php');
require_once('../../../funciones/errores_horario.php');
mysql_select_db($database_sala, $sala);
session_start();
require_once('seguridadmateriasgrupos.php');

if(isset($_REQUEST['eliminar'])){
	$query_upddocentegrupo = "UPDATE DocenteModuloHorario
			SET codigoestado=200
			WHERE DocenteModuloHorarioId = ".$_REQUEST['idmodulohorario'];
	$datos_query=mysql_query($query_upddocentegrupo, $sala) or die("$query_upddocentegrupo");
	echo '<script>alert("Eliminacion realizada correctamente"); window.close();</script>';
}

$codigocarrera = $_SESSION['codigofacultad'];
$codigomateria = $_GET['codigomateria1'];
$carrera = $_GET['carrera1'];
$dirini = "?codigomateria1=$codigomateria&carrera1=$carrera";
if(isset($_GET['grupo1']))
{
	$grupo=$_GET['grupo1'];
	$idgrupo=$_GET['idgrupo1'];
}
if(isset($_POST['grupo1']))
{
	$grupo=$_POST['grupo1'];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Editar docente</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold; }
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
		window.location.href="agregardocente.php'.$dirini.'&grupo1='.$grupo.'&idgrupo1='.$idgrupo.'&busqueda=nombre";
	}
    if (tipo == 2)
	{
		window.location.href="agregardocente.php'.$dirini.'&grupo1='.$grupo.'&idgrupo1='.$idgrupo.'&busqueda=apellido";
	}
    if (tipo == 3)
	{
		window.location.href="agregardocente.php'.$dirini.'&grupo1='.$grupo.'&idgrupo1='.$idgrupo.'&busqueda=codigo";
    }
    if (tipo == 4)
	{
		window.location.href="agregardocente.php'.$dirini.'&grupo1='.$grupo.'&idgrupo1='.$idgrupo.'&busqueda=documento";
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
		window.location.href="agregardocente.php'.$dirini.'&grupo=buscar='.$grupo.'&"+busca;
	}
}
</script>';
?>
<div align="center">
<form name="f1" action="agregardocente.php<?php echo $dirini; ?>" method="get">
  <input type="hidden" name="grupo1" value="<?php echo $grupo; ?>">
  <input type="hidden" name="idgrupo1" value="<?php echo $idgrupo; ?>">
  <p class="Estilo3">CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="550" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr class="Estilo2">
    <td width="200" align="center" bgcolor="#C5D5D6">Búsqueda por:
      <select name="tipo" onChange="cambia_tipo()">
		    <option value="0">Seleccionar</option>
		    <option value="1">Nombre</option>
		    <option value="2">Apellido</option>
		    <option value="3">Código</option>
		    <option value="4">Documento</option>
          </select>
    </td>
	<td align="center">&nbsp;
	<?php
if(isset($_GET['busqueda']))
{
	if($_GET['busqueda']=="nombre")
	{
		echo "Digite un Nombre: <input name='busqueda_nombre' type='text'>";
	}
	if($_GET['busqueda']=="apellido")
	{
		echo "Digite un Apellido: <input name='busqueda_apellido' type='text'>";
	}
	if($_GET['busqueda']=="codigo")
	{
		echo "Digite un Código: <input name='busqueda_codigo' type='text'>";
	}
	if($_GET['busqueda']=="documento")
	{
		echo "Digite un No. Documento: <input name='busqueda_documento' type='text'>";
	}
?>
	<div align="center"></div></td>
  </tr>
  <tr>
  	<td colspan="2" align="center" class="Estilo1"><input name="buscar" type="submit" value="Buscar">&nbsp;<input type="button" value="Cancelar" onClick="window.close()"></td>
  </tr>
<?php
}
if(isset($_GET['buscar']))
{
?>
</table>

<?php 
	$query_select = "SELECT dmh.DocenteModuloHorarioId, doc.iddocente, doc.nombredocente, doc.apellidodocente, doc.numerodocumento FROM DocenteModuloHorario dmh INNER JOIN docente doc ON dmh.iddocente = doc.iddocente WHERE idgrupo = ".$idgrupo." AND dmh.codigoestado = 100";
	$datosselect=mysql_query($query_select, $sala) or die("$query_select");	
	$totalRows_datosselect = mysql_num_rows($datosselect);
	if($totalRows_datosselect != ""){
	?>
	
<p class="Estilo3">Existentes</p>

<table width="550" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
<tr>
	<td bgcolor="#C5D5D6" class="Estilo2">Nombre</td>
	<td bgcolor="#C5D5D6" class="Estilo2">Documento</td>
	<td bgcolor="#C5D5D6" class="Estilo2">Accion</td>
</tr>
	<?php
		while($anteriores = mysql_fetch_assoc($datosselect))
		{			
			echo '<tr>
					<td>'.$anteriores['nombredocente'].' '.$anteriores['apellidodocente'].'</td>
					<td>'.$anteriores['numerodocumento'].'</td>
					<td> <a href="datos_agregar_docente.php?idgrupo='.$idgrupo.'&iddocente='.$anteriores['iddocente'].'">Editar</a> | <a href="'.$_SERVER['REQUEST_URI'].'&eliminar=1&idmodulohorario='.$anteriores['DocenteModuloHorarioId'].'">Eliminar</a> </td>
				</tr>';
		}
	}
	echo '</table>';
?>


<p align="center" class="Estilo1"><input type="button" value="Cancelar" onClick="window.close()"></p>
<p align="center" class="Estilo2"><strong>Seleccione el profesor que desee actualizar de la siguiente tabla: </strong></p>
<table width="550" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6" class="Estilo2">
    <td align="center" class="Estilo1"><strong>Nombre Docente</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Cédula</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Código</strong>&nbsp;</td>
  </tr>
<?php
	$vacio = false;
	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];
		$query_solicitud = "SELECT
					doc.*
				FROM
					docente doc
				WHERE
					doc.nombredocente LIKE '$nombre%'
                                      and doc.codigoestado like '1%'
					ORDER BY doc.apellidodocente";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_apellido']))
	{
		$apellido = $_GET['busqueda_apellido'];
		$query_solicitud = "SELECT
					doc.*
				FROM
					docente doc
				WHERE
					doc.apellidodocente LIKE '$apellido%'
                                      and doc.codigoestado like '1%'
					ORDER BY doc.apellidodocente";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_apellido'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_codigo']))
	{
		$codigo = $_GET['busqueda_codigo'];
		$query_solicitud = "SELECT
					doc.*
				FROM
					docente doc
				WHERE
					doc.codigodocente LIKE '$codigo%'
                                      and doc.codigoestado like '1%'
					ORDER BY doc.apellidodocente";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_codigo'] == "")
			$vacio = true;
	}
	if(isset($_GET['busqueda_documento']))
	{
		$documento = $_GET['busqueda_documento'];
		$query_solicitud = "SELECT
					doc.*
				FROM
					docente doc
				WHERE
					doc.numerodocumento LIKE '$documento%'
                                       and doc.codigoestado like '1%'
				ORDER BY doc.apellidodocente";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_documento'] == "")
			$vacio = true;
	}
	if(!$vacio)
	{
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
			$docente = $solicitud["nombredocente"]." ".$solicitud["apellidodocente"];
			$cc = $solicitud["numerodocumento"];
			$cod = $solicitud["codigodocente"];
			echo "<tr class='Estilo1'>
				<td><a href='agregardocente.php$dirini&documentodocente1=$cc&grupo1=$grupo&idgrupo1=$idgrupo'>$docente&nbsp;</a></td>
				<td align='center'>$cc&nbsp;</td>
				<td align='center'>$cod&nbsp;</td>
			</tr>";
		}
		echo '<tr><td colspan="3" align="center"><input type="button" value="Cancelar" onClick="window.close()"></td></tr>';
	}
?>
</table>
<p class="Estilo1">
<?php
}
/*		echo "<script language='javascript'>  window.location.href='creditos.php?busqueda_credito=".$sol."&buscar=Buscar')</script>";
*/
if(isset($_GET['documentodocente1']))
{
	$documentodocente=$_GET['documentodocente1'];
	$query_upddocentegrupo = "UPDATE grupo
	SET numerodocumento='$documentodocente'
	WHERE idgrupo = '$idgrupo'";
	//echo "<br>UPDATE GRUPO:".$query_upddocentegrupo;
	$upddocentegrupo = mysql_query($query_upddocentegrupo, $sala) or die(mysql_error());
	//exit();
	$iddocente = $_REQUEST['iddocente'];
	echo "<script language='javascript'>
			window.location.href = 'datos_agregar_docente.php?idgrupo=".$idgrupo."&iddocente=".$iddocente."';
	  </script>";
}
?>
</p>
</form>
</div>
</body>
</html>