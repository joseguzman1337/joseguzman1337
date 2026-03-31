<?php
session_start();
require_once('../../../Connections/sala2.php');
require_once('seguridadlistagrupos.php');
//mysql_select_db($database_sala, $sala);

/********** COMENTAR ***********/
//$_SESSION['MM_Username'] = "gallegodubian";
//$_SESSION['MM_Username'] = "adminmedicina";
//$_SESSION['codigofacultad'] = 100;
//$GLOBALS['MM_Username'];
$carrera = $_SESSION['codigofacultad'];
$usuario=$_SESSION['MM_Username'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];
mysql_select_db($database_sala, $sala);
?>
<html>
<head>
<title>Lista de grupos</title>
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
		window.location.href="listagrupos.php?busqueda=nombre";
	}
    if (tipo == 2)
	{
		window.location.href="listagrupos.php?busqueda=codigo";
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
		window.location.href="listagrupos.php?buscar="+busca;
	}
}
</script>

<body>
<div align="center">
<form name="f1" action="listagrupos.php" method="get">
<?php
if(isset($_SESSION['codigofacultad']))
{
?>
  <p class="Estilo3">CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr class="Estilo2">
    <td width="250" bgcolor="#C5D5D6">
	  <div align="center">Búsqueda por:
	    <select name="tipo" onChange="cambia_tipo()">
		    <option value="0">Seleccionar</option>
		    <option value="1">Nombre</option>
		    <option value="2">Código</option>
	        </select>
&nbsp;	</div></td>
	<td class="Estilo6">&nbsp;
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
  	<td colspan="2" align="center" class="Estilo1"><input name="buscar" type="submit" value="Buscar">&nbsp;</td>
  </tr>
 <?php
	}
	if(isset($_GET['buscar']))
	{
		// Falta adicionar las lineas de enfasis
?>
</table>
  <span class="Estilo8">
  <?php
		$vacio = false;

		if(isset($_GET['busqueda_nombre']))
		{
			$nombre = $_GET['busqueda_nombre'];
			$query_solicitud = "SELECT distinct g.idgrupo, g.codigogrupo, g.nombregrupo, g.maximogrupo, g.matriculadosgrupo, m.nombremateria, m.codigomateria
			FROM grupo g, materia m, detalleplanestudio d, planestudio p
			where g.codigomateria = m.codigomateria
			and m.nombremateria like '$nombre%'
			and g.codigoestadogrupo like '1%'
			and g.codigoperiodo = '$codigoperiodo'
			and p.codigocarrera = '$carrera'
			and m.codigomateria = d.codigomateria
			and d.idplanestudio = p.idplanestudio
			order by m.nombremateria, g.idgrupo";
			//and g.codigomaterianovasoft = m.codigomaterianovasoft
			//and m.codigocarrera = '$carrera'
			//echo "$query_solicitud <br>";
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			$totalRows_solicitud = mysql_num_rows($res_solicitud);
			if($totalRows_solicitud == "")
			{
				$query_solicitud = "SELECT distinct g.idgrupo, g.codigogrupo, g.nombregrupo, g.maximogrupo, g.matriculadosgrupo, m.nombremateria, m.codigomateria
				FROM grupo g, materia m
				where g.codigomateria = m.codigomateria
				and m.nombremateria like '$nombre%'
				and g.codigoestadogrupo like '1%'
				and g.codigoperiodo = '$codigoperiodo'
				and m.codigocarrera = '$carrera'
				order by m.nombremateria, g.idgrupo";
				//and g.codigomaterianovasoft = m.codigomaterianovasoft
				//and m.codigocarrera = '$carrera'
				//echo "$query_solicitud <br>";
				$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			}
			/*$query_materia = "SELECT m.nombremateria, m.codigomateria
			FROM materia m
			where m.nombremateria = '$nombre%'
			and m.codigocarrera = '$carrera'";
			$res_materia = mysql_query($query_materia, $sala) or die(mysql_error());
			$materia = mysql_fetch_assoc($res_materia);
			*/
			if($_GET['busqueda_nombre'] == "")
				$vacio = false;
		}
		if(isset($_GET['busqueda_codigo']))
		{
			$codigo = $_GET['busqueda_codigo'];
			$query_solicitud = "SELECT distinct g.idgrupo, g.codigogrupo, g.nombregrupo, g.maximogrupo,
			g.matriculadosgrupoelectiva, g.matriculadosgrupo, m.nombremateria, m.codigomateria
			FROM grupo g, materia m, detalleplanestudio d, planestudio p
			where g.codigomateria = m.codigomateria
			and m.codigomateria like '$codigo%'
			and g.codigoestadogrupo like '1%'
			and g.codigoperiodo = '$codigoperiodo'
			and p.codigocarrera = '$carrera'
			and m.codigomateria = d.codigomateria
			and d.idplanestudio = p.idplanestudio
			order by m.nombremateria, g.idgrupo";
			//and g.codigomaterianovasoft = m.codigomaterianovasoft
			//and m.codigocarrera = '$carrera'
			$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			$totalRows_solicitud = mysql_num_rows($res_solicitud);
			if($totalRows_solicitud == "")
			{
				$query_solicitud = "SELECT distinct g.idgrupo, g.codigogrupo, g.nombregrupo, g.maximogrupo,
				g.matriculadosgrupoelectiva, g.matriculadosgrupo, m.nombremateria, m.codigomateria
				FROM grupo g, materia m
				where g.codigomateria = m.codigomateria
				and m.codigomateria like '$codigo%'
				and g.codigoestadogrupo like '1%'
				and g.codigoperiodo = '$codigoperiodo'
				and m.codigocarrera = '$carrera'
				order by m.nombremateria, g.idgrupo";
				//and g.codigomaterianovasoft = m.codigomaterianovasoft
				//and m.codigocarrera = '$carrera'
				//echo "$query_solicitud <br>";
				$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			}
			/*
			$query_materia = "SELECT m.nombremateria, m.codigomateria
			FROM materia m
			where m.codigomateria = '$codigo%'
			and m.codigocarrera = '$carrera'";
			$res_materia = mysql_query($query_materia, $sala) or die(mysql_error());
			$materia = mysql_fetch_assoc($res_materia);
			*/
			if($_GET['busqueda_codigo'] == "")
				$vacio = false;
		}
		if(!$vacio)
		{
?>
  </span>
  <p align="center" class="Estilo2">Seleccione el grupo que desee consultar de la siguiente tabla: </p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6" class="Estilo2">
    <td align="center">Nombre Materia</td>
    <td align="center">Codigo Materia</td>
    <td align="center">Código Grupo</td>
    <td align="center">Nombre Grupo</td>
    <td align="center">Cupo</td>
    <td align="center">Prematriculados</td>
    <td align="center">Matriculados</td>
    <td align="center">Total Grupo</td>
  </tr>
<?php
			$quitarmaterias = "";
			while($solicitud = mysql_fetch_assoc($res_solicitud))
			{
				$quitarmaterias = "$quitarmaterias and m.codigomateria <> ".$solicitud["codigomateria"]." ";
				//echo $quitarmaterias;
				$nombremateria = $solicitud["nombremateria"];
				$codigomateria = $solicitud["codigomateria"];
				$idgrupo = $solicitud["idgrupo"];
				$codigogrupo = $solicitud["codigogrupo"];
				$nombregrupo = $solicitud["nombregrupo"];
				$maximogrupo = $solicitud["maximogrupo"];
				$matriculadosgrupo = $solicitud["matriculadosgrupo"];
				$matriculadosgrupoelectiva = $solicitud["matriculadosgrupoelectiva"];

				require("calculoestudiantesinscritos.php");
				$valor_prematriculados = $total_prematriculados + $total_prematriculados2;
				$matriculadosgrupo =  $valor_prematriculados + $total_matriculados;
				echo "<tr>
					<td align='left' class='Estilo1'><a href='listagruposmostrar.php?idgrupo=$idgrupo&codigo=$codigomateria'>$nombremateria&nbsp;</a></td>
					<td align='center' class='Estilo1'>$codigomateria&nbsp;</td>
					<td align='center' class='Estilo1'>$idgrupo&nbsp;</a></td>
					<td align='center' class='Estilo1'>$nombregrupo&nbsp;</td>
					<td align='center' class='Estilo1'>$maximogrupo&nbsp;</td>
					<td align='center' class='Estilo1'>$valor_prematriculados&nbsp;</td>
					<td align='center' class='Estilo1'>$total_matriculados&nbsp;</td>
					<td align='center' class='Estilo1'>$matriculadosgrupo&nbsp;</td>
				</tr>";
			}
			if(isset($_GET['busqueda_nombre']))
			{
				$nombre = $_GET['busqueda_nombre'];
				$query_solicitud = "SELECT distinct g.idgrupo, g.codigogrupo, g.nombregrupo, g.maximogrupo, g.matriculadosgrupo, m.nombremateria, m.codigomateria
				FROM grupo g, materia m
				where g.codigomateria = m.codigomateria
				and m.nombremateria like '$nombre%'
				and g.codigoestadogrupo like '1%'
				and g.codigoperiodo = '$codigoperiodo'
				and m.codigocarrera = '$carrera'
				$quitarmaterias
				order by m.nombremateria, g.idgrupo";
				//and g.codigomaterianovasoft = m.codigomaterianovasoft
				//and m.codigocarrera = '$carrera'
				//echo "$query_solicitud <br>";
				$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			}
			if($_GET['busqueda_nombre'] == "")
				$vacio = false;
			}
			if(isset($_GET['busqueda_codigo']))
			{
				$query_solicitud = "SELECT distinct g.idgrupo, g.codigogrupo, g.nombregrupo, g.maximogrupo,
				g.matriculadosgrupoelectiva, g.matriculadosgrupo, m.nombremateria, m.codigomateria
				FROM grupo g, materia m
				where g.codigomateria = m.codigomateria
				and m.codigomateria like '$codigo%'
				and g.codigoestadogrupo like '1%'
				and g.codigoperiodo = '$codigoperiodo'
				and m.codigocarrera = '$carrera'
				$quitarmaterias
				order by m.nombremateria, g.idgrupo";
				//and g.codigomaterianovasoft = m.codigomaterianovasoft
				//and m.codigocarrera = '$carrera'
				//echo "$query_solicitud <br>";
				$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
			}
			if($_GET['busqueda_codigo'] == "")
				$vacio = false;
			if(!$vacio)
			{
				while($solicitud = mysql_fetch_assoc($res_solicitud))
				{
					$nombremateria = $solicitud["nombremateria"];
					$codigomateria = $solicitud["codigomateria"];
					$idgrupo = $solicitud["idgrupo"];
					$codigogrupo = $solicitud["codigogrupo"];
					$nombregrupo = $solicitud["nombregrupo"];
					$maximogrupo = $solicitud["maximogrupo"];
					$matriculadosgrupo = $solicitud["matriculadosgrupo"];
					$matriculadosgrupoelectiva = $solicitud["matriculadosgrupoelectiva"];

					require("calculoestudiantesinscritos.php");
					$valor_prematriculados = $total_prematriculados + $total_prematriculados2;
					$matriculadosgrupo =  $valor_prematriculados + $total_matriculados;
					echo "<tr>
						<td align='left' class='Estilo1'><a href='listagruposmostrar.php?idgrupo=$idgrupo&codigo=$codigomateria'>$nombremateria&nbsp;</a></td>
						<td align='center' class='Estilo1'>$codigomateria&nbsp;</td>
						<td align='center' class='Estilo1'>$idgrupo&nbsp;</a></td>
						<td align='center' class='Estilo1'>$nombregrupo&nbsp;</td>
						<td align='center' class='Estilo1'>$maximogrupo&nbsp;</td>
						<td align='center' class='Estilo1'>$valor_prematriculados&nbsp;</td>
						<td align='center' class='Estilo1'>$total_matriculados&nbsp;</td>
						<td align='center' class='Estilo1'>$matriculadosgrupo&nbsp;</td>
					</tr>";
				}
			}
?>
</table>
<span class="Estilo7">
<?php
		if($vacio)
		{
			echo "No se encontro ningún resultado";
		}
	}
}
?>
</span>
</form>
</div>
</body>
</html>
