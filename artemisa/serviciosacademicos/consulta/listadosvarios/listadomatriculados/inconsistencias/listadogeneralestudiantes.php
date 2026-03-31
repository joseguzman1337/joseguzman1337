<?php 
require_once('../../../../Connections/salap.php');
//require_once('Connections/sala.php');
mysql_select_db($database_sala, $sala);
session_start();
//require_once('seguridadlistadogeneralestudiantes.php'); 
$GLOBALS['filtrado'];
$_SESSION['filtrado'] = "ninguno";
//$codigocarrera = $_SESSION['codigofacultad'];
//$_SESSION['MM_Username'] = "adminmedicina";
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
.Estilo2 {font-size: x-small}
.Estilo3 {
	font-family: Tahoma;
	font-size: x-small;
	font-weight: bold;
}
.Estilo4 {
	font-size: xx-small;
	font-weight: bold;
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
		window.location.reload("listadogeneralestudiantes.php?busqueda=codigo"); 
	} 
    if (tipo == 2)
	{
		window.location.reload("listadogeneralestudiantes.php?busqueda=semestre"); 
	}
	if (tipo == 3)
	{
		window.location.reload("listadogeneralestudiantes.php?busqueda=facultad"); 
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
		window.location.reload("listadogeneralestudiantes.php?buscar="+busca); 
	} 
} 
</script>

<body>
<div align="center">
<form name="f1" action="listadogeneralestudiantes.php" method="get">
  <p class="Estilo1 Estilo2"><strong>CRITERIO DE B&Uacute;SQUEDA</strong></p>
  <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="250" bgcolor="#C5D5D6" class="Estilo1">
	<span class="Estilo4">Búsqueda por :</span>	<select name="tipo" onChange="cambia_tipo()">
		<option value="0">Seleccionar</option>
		<option value="1">Código Estudiante</option>
		<option value="2">Por Semestre</option>
		<option value="3">Todos los semestres</option>
	</select>
&nbsp;	</td>
	<td class="Estilo1">&nbsp;
<?php
if(isset($_GET['busqueda']))
{
	if($_GET['busqueda']=="codigo")
	{
		echo "Digite un Código : <input name='busqueda_codigo' type='text'>  Corte : <input name='busqueda_corte' type='text' size='1'>";
	}
	if($_GET['busqueda']=="semestre")
	{
		echo "Digite el número del semestre : <input name='busqueda_semestre' type='text'> Corte <input name='busqueda_corte' type='text' size='1'>";
	}
	if($_GET['busqueda']=="facultad")
	{
		echo "Corte <input name='busqueda_facultad' type='text' size='1'>";
		
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
	if(isset($_GET['busqueda_codigo']))
	{
		$codigo = $_GET['busqueda_codigo'];
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=listadogeneralestudiantesmostrar.php?codestudiante=".$codigo."&corte=".$_GET['busqueda_corte']."'>";
	}
	if(isset($_GET['busqueda_semestre']))
	{
		$semestre = $_GET['busqueda_semestre'];
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=listadogeneralestudiantesmostrar.php?semestre=".$semestre."&corte=".$_GET['busqueda_corte']."'>";
	}
if(isset($_GET['busqueda_facultad']))
	{
		$corte3 = $_GET['busqueda_facultad'];
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=listadogeneralestudiantesmostrar.php?semestreinicial=1&facultad&corte=".$corte3."'>";
	}

}
?>
</form>
</div>
</body>
</html>