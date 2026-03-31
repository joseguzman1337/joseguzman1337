<?php 
require_once('../../../Connections/sala2.php'); 
session_start();
require_once('seguridadmateriasgrupos.php');
$codigocarrera = $_SESSION['codigofacultad'];
$idgrupo = $_GET['idgrupo1'];
$codigodocente = $_GET['codigodocente1'];
$codigomateria = $_GET['codigomateria1'];
$codigomaterianovasoft = $_GET['codigomaterianovasoft1'];
$carrera = $_GET['carrera1'];
if(isset($_GET['insgrp1']))
	$insgrp = $_GET['insgrp1'];
else if(isset($_GET['documentodocente1']))
{
	$documentodocente = $_GET['documentodocente1'];
	$insgrp = "?idgrupo1=$idgrupo&codigodocente1=$codigodocente&codigomateria1=$codigomateria&codigomaterianovasoft1=$codigomaterianovasoft&carrera1=$carrera&documentodocente1=$documentodocente";
}
else
	$insgrp = "?idgrupo1=$idgrupo&codigodocente1=$codigodocente&codigomateria1=$codigomateria&codigomaterianovasoft1=$codigomaterianovasoft&carrera1=$carrera";
//echo $doc;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Adicionar docente</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma}
.Estilo2 {font-size: x-small}
.Estilo4 {font-size: xx-small; font-weight: bold; }
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
		window.location.reload("adicionardocente.php'.$insgrp.'&busqueda=nombre"); 
	} 
    if (tipo == 2)
	{
		window.location.reload("adicionardocente.php'.$insgrp.'&busqueda=apellido"); 
	} 
    if (tipo == 3)
	{
		window.location.reload("adicionardocente.php'.$insgrp.'&busqueda=codigo"); 
    } 
    if (tipo == 4)
	{
		window.location.reload("adicionardocente.php'.$insgrp.'&busqueda=documento"); 
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
		window.location.reload("adicionardocente.php?buscar="+busca); 
	} 
} 
</script>';
?>
<form action="adicionardocente.php<?php //echo $insgrp ?>" method="get" name="f1" class="Estilo2" onSubmit="return validar(this)">
  <p align="center" class="Estilo1"><strong>CRITERIO DE B&Uacute;SQUEDA</strong></p>
    <div align="center" class="Estilo1">
      <table width="400" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
      <tr>
        <td width="200">
	    <span class="Estilo4">Búsqueda por: </span>	    <select name="tipo" onChange="cambia_tipo()">
		    <option value="0">Seleccionar</option>
		    <option value="1">Nombre</option>
		    <option value="2">Apellido</option>
		    <option value="3">Código</option>
		    <option value="4">Documento</option>
	    </select>
	&nbsp;
	    </td>
	    <td>&nbsp;
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
?>
	    </td>
      </tr>
      <tr>
  	    <td colspan="2" align="center"><input name="buscar" type="submit" value="Buscar">&nbsp;
        <input type="button" value="Cancelar" onClick="window.close()"></td>
      </tr>
    <?php
}
if(isset($_GET['buscar']))
{
	$insgrp = $_GET['insgrp1'];
?>
      </table>
    </div>
  <p align="center" class="Estilo1">
    <input type="button" value="Cancelar" onClick="window.close()">
  </p> 
  <p align="center" class="Estilo1"><strong>Seleccione el profesor que desee actualizar de la siguiente tabla: </strong></p>
    <div align="center" class="Estilo1">
      <table width="400" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
      <tr>
        <td align="center"><span class="Estilo2"><strong>Nombre Docente</strong>&nbsp;</span></td>
        <td align="center"><span class="Estilo2"><strong>Cédula</strong>&nbsp;</span></td>
        <td align="center"><span class="Estilo2"><strong>Código</strong>&nbsp;</span></td>
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
			$insgrp = "$insgrp&documentodocente1=$cc&docente1=$docente";
		?>
	      <tr>
		    <?php
			echo "<td><a href='adicionardocente.php$insgrp'>$docente<td>
				<td>$cc&nbsp;</td>
				<td>$cod&nbsp;</td>
			</tr>";
		}
	}
?>
      </table>
    </div>
  <p align="center" class="Estilo1">
    <input type="button" value="Cancelar" onClick="window.close()">
  </p> 
  <p align="center" class="Estilo1">
  <?php
}
/*		echo "<script language='javascript'>  window.location.reload('creditos.php?busqueda_credito=".$sol."&buscar=Buscar')</script>";
*/
if(isset($_GET['documentodocente1']))
{
	echo "fpogpfdgpdofigp";
	echo "<script language='javascript'>
			window.opener.recargar('".$insgrp."');
			window.opener.focus();
			window.close();
	  </script>";
}
?>
  </p>
  <div align="center">
    <span class="Estilo1">
    <input type="hidden" name="insgrp1" value="<?php echo $insgrp ?>">
  </span>  </div>
</form>
</body>
</html>
