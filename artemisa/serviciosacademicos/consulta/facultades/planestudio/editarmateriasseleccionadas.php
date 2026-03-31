<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();
include_once('../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
include (realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
    
require_once("../../../funciones/validacion.php");
require_once("../../../funciones/errores_plandeestudio.php");

require_once('seguridadplandeestudio.php');
if(isset($_GET['planestudio']))
{
	$idplanestudio = $_GET['planestudio'];
}
if(isset($_POST['regresar']))
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=visualizarplandeestudio.php?planestudio=".$idplanestudio."'>";
}
$query_planestudio = "select p.idplanestudio, p.nombreplanestudio, p.fechacreacionplanestudio,
p.responsableplanestudio, p.cargoresponsableplanestudio, p.cantidadsemestresplanestudio,
c.nombrecarrera, p.numeroautorizacionplanestudio, t.nombretipocantidadelectivalibre,
p.cantidadelectivalibre, p.fechainioplanestudio, p.fechavencimientoplanestudio
from planestudio p, carrera c, tipocantidadelectivalibre t
where p.codigocarrera = c.codigocarrera
and p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre
and p.idplanestudio = '$idplanestudio'";
$planestudio = $db->GetRow($query_planestudio);
$row_planestudio = $planestudio;
$totalRows_planestudio = count($planestudio);

$formulariovalido = 1;

/********* COMBO TIPO MATERIA **************/
$query_tipomateria = "select nombretipomateria, codigotipomateria from tipomateria";
$tipomateriacombo = $db->GetAll($query_tipomateria);
$row_tipomateria = $tipomateriacombo;
$totalRows_tipomateria = count($tipomateriacombo);

/********* COMBO FROMACION PROFESIONAL **************/
$query_formacionacademica = "select codigoformacionacademica, nombreformacionacademica
from formacionacademica";
$formacionacademica = $db->GetAll($query_formacionacademica);
$row_formacionacademica = $formacionacademica;
$totalRows_formacionacademica = count($formacionacademica);

/********* COMBO AREA ACADEMICA **************/
$query_areaacademica = "select codigoareaacademica, nombreareaacademica
from areaacademica";
$areaacademica = $db->GetAll($query_areaacademica);
$row_areaacademica = $areaacademica;
$totalRows_areaacademica = count($areaacademica);
?>
<html>
<head>
<title>Editar materias seleccionadas</title>
</head>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo2 {
	font-family: sans-serif;
	font-size: 10px;
}
.Estilo3 {
	font-family: Tahoma;
	font-size: 9px;
	width: 15px
}
-->
</style>
<body>
<div align="center">
<form name="f1" method="post" action="editarmateriasseleccionadas.php?planestudio=<?php echo $idplanestudio;?>">
<p class="Estilo1" align="center"><strong>PLAN DE ESTUDIO</strong></p>
<table width="780" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
  	<td align="center" bgcolor="#C5D5D6"><strong>Nº Plan Estudio</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Nombre</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha</strong></td>
  </tr>
  <tr>
	<td align="center"><?php echo $idplanestudio; ?></td>
	<td align="center">	 <?php echo $row_planestudio['nombreplanestudio']; ?>	  </td>
	<td align="center"><?php echo preg_replace("/[0-9]+:[0-9]+:[0-9]+/","",$row_planestudio['fechacreacionplanestudio']); ?></td>
  </tr>
  <tr>
  	<td align="center" colspan="2" bgcolor="#C5D5D6"><strong>Nombre Encargado</strong></td>
  	<td align="center" bgcolor="#C5D5D6"><strong>Cargo</strong></td>
  </tr>
  <tr>
	<td align="center" colspan="2"><?php echo $row_planestudio['responsableplanestudio']; ?>
	  </td>
	<td align="center"><?php echo $row_planestudio['cargoresponsableplanestudio']; ?>
	  </td>
  </tr>
  <tr>
  	<td align="center" bgcolor="#C5D5D6"><strong>Nº Semestres</strong></td>
  	<td align="center" bgcolor="#C5D5D6"><strong>Carrera</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Autorización Nº</strong></td>
  </tr>
  <tr>
  	<td align="center"><?php echo $row_planestudio['cantidadsemestresplanestudio']; ?></td>
	<td align="center"><?php echo $row_planestudio['nombrecarrera']; ?></td>
	<td align="center"><?php echo $row_planestudio['numeroautorizacionplanestudio']; ?></td>
  </tr>
 <tr>
  	<!-- <td align="center"><strong>Tipo de Electivas</strong></td>
	<td align="center"><strong>Cantidad</strong></td> -->
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Inicio</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Vencimiento</strong></td>
	<td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
  	<!-- <td align="center"><?php echo $row_planestudio['nombretipocantidadelectivalibre']; ?></td>
	<td align="center"><?php echo $row_planestudio['cantidadelectivalibre']; ?></td> -->
	<td align="center"><?php echo preg_replace("/[0-9]+:[0-9]+:[0-9]+/","",$row_planestudio['fechainioplanestudio']); ?></td>
	<td align="center"><?php echo preg_replace("/[0-9]+:[0-9]+:[0-9]+/","",$row_planestudio['fechavencimientoplanestudio']); ?></td>
  </tr>
</table>
<table width="780" border="1" cellpadding='2' cellspacing='1' bordercolor='#D76B00'>
  <tr>
	<td width="390" align="center">
<?php
$tienemateriasporeditar = false;
$query_materiassineditar = "select d.codigomateria, m.nombremateria
from detalleplanestudio d, materia m
where d.idplanestudio = '$idplanestudio'
and d.codigomateria = m.codigomateria
and d.semestredetalleplanestudio = '0'
order by 2";
$materiassineditar = $db->GetAll($query_materiassineditar);
$totalRows_materiassineditar = count($materiassineditar);
if($totalRows_materiassineditar != "")
{
	$tienemateriasporeditar = true;
?>
	<p align="center"><strong>Asignaturas  Sin Modificar</strong></p>
	<select name="listados" size="12" style="width:380px" class="Estilo2">
<?php
	foreach($materiassineditar as $row_materiassineditar)
	{
		$nombremateria = $row_materiassineditar['nombremateria'];
		$codigomateria = $row_materiassineditar['codigomateria'];
?>
      <option value="<?php echo $codigomateria; ?>"><?php echo "$nombremateria &nbsp;&nbsp; $codigomateria"; ?></option>
      <?php
	}
}
?>
    </select>
<?php
$query_materiaseditadas = "select d.codigomateria, m.nombremateria
from detalleplanestudio d, materia m
where d.idplanestudio = '$idplanestudio'
and d.codigomateria = m.codigomateria
and d.semestredetalleplanestudio not like '0'
order by 2";
$materiaseditadas = $db->GetAll($query_materiaseditadas);
$totalRows_materiaseditadas = count($materiaseditadas);
if($totalRows_materiaseditadas != "")
{
?>
	<p align="center"><strong>Asignaturas  Modificadas</strong></p>
	<select name="listados" size="12" style="width:380px" class="Estilo2">
<?php
	foreach($materiaseditadas as $row_materiaseditadas)
	{
		$nombremateria = $row_materiaseditadas['nombremateria'];
		$codigomateria = $row_materiaseditadas['codigomateria'];
?>
      <option value="<?php echo $codigomateria; ?>"><?php echo "$nombremateria &nbsp;&nbsp; $codigomateria"; ?></option>
      <?php
	}
}
?>
    </select>
	<p align="center">
<?php
if(!isset($_POST['accionmateria']) && !isset($_POST['aceptaredicion']) && !isset($_GET['accionmateria']))
{
?>
	<input type="submit" name="accionmateria" value="Editar" style="width: 80px"> <input type="submit" name="accionmateria" value="Visualizar" style="width: 80px">
<?php
}
else
{
?>
	<input type="submit" name="otramateria" value="Otra" style="width: 60px">
<?php
}
?>
	</p>
</td>
    <td width="390" align="center" valign="top">&nbsp;
<?php
/*foreach($_POST as $key => $value)
{
	echo "$key => $value";
}*/
if(isset($_POST['accionmateria']) || isset($_POST['aceptaredicion']) || isset($_GET['accionmateria']))
{
	$entropost = false;
	$entroget = false;
	if(isset($_POST['listados']))
	{
		$entropost = true;
		$codigoeditarmateria = $_POST['listados'];
	}
	if(isset($_GET['listados']))
	{
		$entroget = true;
		$codigoeditarmateria = $_GET['listados'];
	}
	if($entropost || $entroget)
	{
		$query_editarmateriaplanestudio = "select d.codigomateria, m.nombremateria, d.semestredetalleplanestudio, d.valormateriadetalleplanestudio, d.numerocreditosdetalleplanestudio,
		d.codigotipomateria, t.nombretipomateria, d.fechainiciodetalleplanestudio, d.fechavencimientodetalleplanestudio, m.numerohorassemanales,
		d.codigoformacionacademica, d.codigoareaacademica, a.nombreareaacademica, f.nombreformacionacademica
		from detalleplanestudio d, materia m, tipomateria t, formacionacademica f, areaacademica a
		where d.idplanestudio = '$idplanestudio'
		and d.codigomateria = m.codigomateria
		and d.codigotipomateria = t.codigotipomateria
		and d.codigomateria = '$codigoeditarmateria'
		and d.codigoformacionacademica = f.codigoformacionacademica
		and d.codigoareaacademica = a.codigoareaacademica";
		//echo "AAAJK<br>$query_materiasplanestudio";
		$editarmateriaplanestudio = $db->GetRow($query_editarmateriaplanestudio);
		$totalRows_editarmateriaplanestudio = count($editarmateriaplanestudio);
		if($totalRows_editarmateriaplanestudio != "")
		{
			$row_editarmateriaplanestudio = $editarmateriaplanestudio;
			$nombre = $row_editarmateriaplanestudio['nombremateria'];
			$codigo = $row_editarmateriaplanestudio['codigomateria'];
			$semestre = $row_editarmateriaplanestudio['semestredetalleplanestudio'];
			$valor = $row_editarmateriaplanestudio['valormateriadetalleplanestudio'];
			$creditos = $row_editarmateriaplanestudio['numerocreditosdetalleplanestudio'];
			$horassemanales = $row_editarmateriaplanestudio['numerohorassemanales'];
			$tipomateria = $row_editarmateriaplanestudio['nombretipomateria'];
			$codigotipomateria = $row_editarmateriaplanestudio['codigotipomateria'];
			$codigoformacionacademica = $row_editarmateriaplanestudio['codigoformacionacademica'];
			$nombreformacionacademica = $row_editarmateriaplanestudio['nombreformacionacademica'];
			$codigoareaacademica = $row_editarmateriaplanestudio['codigoareaacademica'];
			$nombreareaacademica = $row_editarmateriaplanestudio['nombreareaacademica'];
			$fechainicio = preg_replace(" /[0-9]+:[0-9]+:[0-9]+/","",$row_editarmateriaplanestudio['fechainiciodetalleplanestudio']);
			$fechavencimiento = preg_replace(" /[0-9]+:[0-9]+:[0-9]+/","",$row_editarmateriaplanestudio['fechavencimientodetalleplanestudio']);
			if($_POST['accionmateria'] == "Editar" || isset($_POST['aceptaredicion']) || $_GET['accionmateria'] == "Editar")
			{
?>
<p align="center"><strong>Edición</strong></p>
<?php
				require_once("editarmateria.php");
			}
			if($_POST['accionmateria'] == "Visualizar" || $_GET['accionmateria'] == "Visualizar")
			{
?>
<p align="center"><strong>Visualización</strong></p>
<?php
				require_once("visualizarmateria.php");
			}
		}
	}
	else
	{
		if(!$entroget && !$entropost)
		{
?>
<script language="javascript">
	alert("Debe seleccionar una materia en Asignaturas");
	history.go(-1);
</script>
<?php
		}
	}
}

?>
	</td>
  <tr>
    <td colspan="3" align="center">
	<input type="button" name="regresar" value="Regresar" style="width:80px" onClick="regresarvisualizar()">
	<input type="button" name="continuar" value="Continuar" style="width:80px" onClick="continuarmateriasporsemestre()"
<?php if($tienemateriasporeditar) echo "disabled";?>>
	</td>
  </tr>
</table>
</form>
<?php
if($formulariovalido)
{
	if(isset($_POST['aceptaredicion']))
	{
		if(isset($_POST['emtipomateria']))
		{
			$query_upddetalleplanestudio = "UPDATE detalleplanestudio
			SET semestredetalleplanestudio='$validarsemestre', fechainiciodetalleplanestudio='$validarfechainicio', fechavencimientodetalleplanestudio='$fechavencimiento', codigoestadodetalleplanestudio='101', codigotipomateria='".$_POST['emtipomateria']."', codigoformacionacademica='".$_POST['emformacionacademica']."', codigoareaacademica='".$_POST['emareaacademica']."'
			WHERE codigomateria = '$codigoeditarmateria'
			and idplanestudio = '$idplanestudio'";
			//echo "$query_upddetalleplanestudio";
			//exit();
		}
		else
		{
			$query_upddetalleplanestudio = "UPDATE detalleplanestudio
			SET semestredetalleplanestudio='$validarsemestre', numerocreditosdetalleplanestudio='$validarcreditos', fechainiciodetalleplanestudio='$validarfechainicio', fechavencimientodetalleplanestudio='$fechavencimiento', codigoestadodetalleplanestudio='101', codigotipomateria='4', codigoformacionacademica='".$_POST['emformacionacademica']."', codigoareaacademica='".$_POST['emareaacademica']."'
			WHERE codigomateria = '$codigoeditarmateria'
			and idplanestudio = '$idplanestudio'";
			//echo "$query_upddetalleplanestudio";
			//exit();
		}
		$upddetalleplanestudio = $db->Execute($query_upddetalleplanestudio);

		echo '<script language="javascript">
		window.location.href="editarmateriasseleccionadas.php?planestudio='.$idplanestudio.'&listados='.$codigoeditarmateria.'&accionmateria=Visualizar";
		</script>';
	}
}
?>
</div>
</body>
<?php
if(!isset($_POST['regresar']))
{
	if($fechainicio != "")
	{
		echo '<script language="javascript">
		function limitesemestre(texto)
		{
			if(texto.value > '.$row_planestudio['cantidadsemestresplanestudio'].')
			{
				texto.value = '.$row_planestudio['cantidadsemestresplanestudio'].';
				return;
			}
			if(texto.value == "")
			{
				texto.value = '.$semestre.';
				return;
			}
		}
		function contadorsemestre(accion)
		{
			var cont;
			cont = document.f1.emsemestre.value;
			if(accion == 1)
			{
				if(cont == '.$row_planestudio['cantidadsemestresplanestudio'].')
				{
					return;
				}
				cont++;
			}
			if(accion == 2)
			{
				if(cont < 1)
				{
					document.f1.emsemestre.value = 0;
					return;
				}
				cont--;
			}
			document.f1.emsemestre.value = cont;
		}
		function limpiarinicio(texto)
		{
			if(texto.value == "'.$fechainicio.'")
				texto.value = "";
		}

		function limpiarvencimiento(texto)
		{
			if(texto.value == "2999-12-31")
				texto.value = "";
		}

		function iniciarinicio(texto)
		{
			if(texto.value == "")
				texto.value = "'.$fechainicio.'";
		}

		function iniciarvencimiento(texto)
		{
			if(texto.value == "")
				texto.value = "2999-12-31";
		}

		</script>';
	}
	echo '<script language="javascript">
	function regresarvisualizar()
	{
		window.location.href="visualizarplandeestudio.php?planestudio='.$idplanestudio.'";
	}
	</script>';
}
echo '<script language="javascript">
function continuarmateriasporsemestre()
{
	window.location.href="materiasporsemestre.php?planestudio='.$idplanestudio.'";
}
</script>';
?>
<script language="javascript">
function regresarinicio()
{
	window.location.href="plandeestudioinicial.php"
}

/*function limpiarcampo(texto)
{
	texto.value = "";
}*/
</script>
</html>
