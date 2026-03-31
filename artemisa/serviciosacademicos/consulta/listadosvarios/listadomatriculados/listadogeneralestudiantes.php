<?php 
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//require_once('seguridadlistadogeneralestudiantes.php'); 
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);


$GLOBALS['filtrado'];
$_SESSION['filtrado'] = "ninguno";
//$codigocarrera = $_SESSION['codigofacultad'];
//$_SESSION['MM_Username'] = "adminmedicina";
?>
<html>
<head>
<title>Lista de grupos</title>
<style type="text/css">

.Estilo1 {
	font-family: Tahoma;
	font-size: xx-small;
}
.Estilo5 {font-size: 14px}
.Estilo8 {font-family: Tahoma; font-size: 12; }
.Estilo9 {
	font-size: 12;
	font-weight: bold;
}
.Estilo10 {
	font-family: Tahoma;
	font-size: 12px;
	font-weight: bold;
}

</style>
</head>
<script language="javascript">
function cambia_tipo()
{ 
    //tomo el valor del select del tipo elegido 
    var tipo 
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value 
    /*
     * Caso 90076
     * @modified Luis Dario Gualteros 
     * <castroluisd@unbosque.edu.co>
     * Se adiciona el objeto window.location.href para que redireccione al archivo que contiene cada una de las consultas 
     * dependiendo el filtro de busqueda.
     * @since Mayo 26 de 2017
    */
    if (tipo == 1)
	{
		 window.location.href="listadogeneralestudiantes.php?busqueda=codigo"; 
	} 
    if (tipo == 2)
	{
		window.location.href="listadogeneralestudiantes.php?busqueda=semestre"; 
	}
	if (tipo == 3)
	{
		window.location.href="listadogeneralestudiantes.php?busqueda=facultad"; 
	}  
} 
   //End caso 90076
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
  <p class="Estilo1 Estilo5"><strong>CRITERIO DE B&Uacute;SQUEDA</strong></p>
  <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="280" bgcolor="#C5D5D6" class="Estilo8">
	  <div align="center"><span class="Estilo9">Búsqueda por :</span>	        
	    <select name="tipo" onChange="cambia_tipo()">
		    <option value="0">Seleccionar</option>
		    <option value="1">Documento Estudiante</option>
		    <option value="2">Por Semestre</option>
		    <option value="3">Todos los semestres</option>
	        </select>
	</div></td>
	<td width="410" class="Estilo10">&nbsp;
<?php

if(isset($_GET['busqueda']))
{
    if($_GET['busqueda']=="codigo")
	{
		echo "Digite No. Documento : <input name='busqueda_codigo' type='text' size='10'>&nbsp;&nbsp;&nbsp;&nbsp; Corte : <input name='busqueda_corte' type='text' size='1'>";
	}
	if($_GET['busqueda']=="semestre")
	{
		echo "Digite Semestre : <input name='busqueda_semestre' type='text' size='1'> &nbsp;&nbsp;&nbsp;&nbsp; Corte : <input name='busqueda_corte' type='text' size='1'>";
	}
	if($_GET['busqueda']=="facultad")
	{
		echo "Corte <input name='busqueda_facultad' type='text' size='1'>";
		
	}
?>
	<div align="center"></div></td>
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
		$documento = $_GET['busqueda_codigo'];
		mysql_select_db($database_sala, $sala);
		$query_solicitud = "SELECT distinct eg.idestudiantegeneral, est.codigoestudiante, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
		c.nombrecarrera, eg.numerodocumento, est.codigoperiodo
		FROM estudiante est, estudiantegeneral eg, estudiantedocumento ed, documento d, carrera c 
		WHERE ed.numerodocumento LIKE '$documento%'
		AND est.codigocarrera like '$car%'
		and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
		and eg.idestudiantegeneral = est.idestudiantegeneral
		and ed.idestudiantegeneral = eg.idestudiantegeneral
		and c.codigocarrera = est.codigocarrera
		and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."'
		and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'
		ORDER BY 3, est.codigoperiodo";
		//and est.codigosituacioncarreraestudiante not like '1%'
		//and est.codigosituacioncarreraestudiante not like '5%'
		//AND est.codigocarrera = '$codigocarrera'
		//echo "$query_solicitud<br>";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		$cadenacodigo = "";
		$cuentacodigos = 0;
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
			$cadenacodigo = $cadenacodigo."codestudiante".$cuentacodigos."=".$solicitud['codigoestudiante']."&";
			$cuentacodigos = $cuentacodigos + 1;
		}
		//echo "<br>".$cadenacodigo;
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=listadogeneralestudiantesmostrar.php?".$cadenacodigo."corte=".$_GET['busqueda_corte']."'>";
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