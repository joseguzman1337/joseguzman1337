<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
require_once('../../../../Connections/sala2.php');
require_once("../../../../funciones/validacion.php");
require_once("../../../../funciones/errores_plandeestudio.php");
mysql_select_db($database_sala, $sala);
session_start();
require_once('../seguridadplandeestudio.php');
if(isset($_GET['planestudio']))
{
	$idplanestudio = $_GET['planestudio'];
	$idlineaenfasis = $_GET['lineaenfasis'];
	$codigomateriapapa = $_GET['materiapapa'];
}
$query_lineaenfasis = "select idlineaenfasisplanestudio, idplanestudio, nombrelineaenfasisplanestudio, fechacreacionlineaenfasisplanestudio,
fechainiciolineaenfasisplanestudio, fechavencimientolineaenfasisplanestudio, responsablelineaenfasisplanestudio
from lineaenfasisplanestudio
where idlineaenfasisplanestudio = '$idlineaenfasis'
and idplanestudio = '$idplanestudio'";
$lineaEnfasis = mysql_query($query_lineaenfasis, $sala) or die("$query_planestudio");
$row_lineaenfasis = mysql_fetch_assoc($lineaEnfasis);
$totalRows_lineaenfasis = mysql_num_rows($lineaEnfasis);

$formulariovalido = 1;
?>
<html>
<head>
<title>Editar materias línea de énfasis</title>
</head>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo2 {
	font-family: sans-serif;
	font-size: 9px;
}
-->
</style>
<body>
<div align="center">
<form name="f1" method="post" action="editarmateriaslineadeenfasisseleccionadas.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis&materiapapa=$codigomateriapapa";?>">
<p class="Estilo1" align="center"><strong>LINEA DE ENFASIS</strong></p>
<table width="400" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Nº Plan Estudio</strong></td>
	<td align="center"><strong>Nº Línea de Enfasis</strong></td>
	<td align="center"><strong>Fecha</strong></td>
  </tr>
  <tr>
	<td align="center"><?php echo $idplanestudio; ?></td>
	<td align="center"><?php echo $idlineaenfasis; ?></td>
	<td align="center"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$row_lineaenfasis['fechacreacionlineaenfasisplanestudio']); ?></td>
  </tr>
  <tr bgcolor="#C5D5D6">
	<td align="center"><strong>Nombre De la Línea</strong></td>
  	<td align="center" colspan="2"><strong>Responsable</strong></td>
  </tr>
  <tr>
	  <td align="center"><?php echo $row_lineaenfasis['nombrelineaenfasisplanestudio']; ?></td>
	<td align="center" colspan="2"><?php echo $row_lineaenfasis['responsablelineaenfasisplanestudio']; ?></td>
	</tr>
	<tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Fecha de Inicio</strong></td>
	<td align="center" colspan="2"><strong>Fecha de Vencimiento</strong></td>
  </tr>
  <tr>
  	<td align="center"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$row_lineaenfasis['fechainiciolineaenfasisplanestudio']); ?>
    </td>
	<td align="center" colspan="2"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$row_lineaenfasis['fechavencimientolineaenfasisplanestudio']); ?>
    </td>
  </tr>
</table>
<table width="780" border="1" cellspacing='1' bordercolor='#D76B00'>
  <tr>
	    <td width="390" align="center">
<?php
$query_materiaseditadas = "select d.codigomateriadetallelineaenfasisplanestudio, m.nombremateria
from detallelineaenfasisplanestudio d, materia m
where d.idlineaenfasisplanestudio = '$idlineaenfasis'
and d.idplanestudio = '$idplanestudio'
and d.codigomateria = '$codigomateriapapa'
and d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
order by 2";
$materiaseditadas = mysql_query($query_materiaseditadas, $sala) or die("$query_materiaseditadas");
$totalRows_materiaseditadas = mysql_num_rows($materiaseditadas);
if($totalRows_materiaseditadas != "")
{
?>
	<p align="center"><strong>Asignaturas</strong></p>
	<select name="listados" size="12" style="width:380px" class="Estilo2">
<?php
	while($row_materiaseditadas = mysql_fetch_assoc($materiaseditadas))
	{
		$nombremateria = $row_materiaseditadas['nombremateria'];
		$codigomateria = $row_materiaseditadas['codigomateriadetallelineaenfasisplanestudio'];
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
	echo "$key => $value<br>";
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
		$query_editarmaterialineaenfasis = "select d.codigomateriadetallelineaenfasisplanestudio,
		m.nombremateria, d.semestredetallelineaenfasisplanestudio, d.valormateriadetallelineaenfasisplanestudio,
		d.numerocreditosdetallelineaenfasisplanestudio, d.codigotipomateria, t.nombretipomateria,
		d.fechainiciodetallelineaenfasisplanestudio, d.fechavencimientodetallelineaenfasisplanestudio,
		m.numerohorassemanales
		from detallelineaenfasisplanestudio d, materia m, tipomateria t
		where d.idlineaenfasisplanestudio = '$idlineaenfasis'
		and d.idplanestudio = '$idplanestudio'
		and d.codigomateria = '$codigomateriapapa'
		and d.codigomateriadetallelineaenfasisplanestudio = '$codigoeditarmateria'
		and d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
		and d.codigotipomateria = t.codigotipomateria";
		//echo "AAAJK<br>$query_editarmaterialineaenfasis";
		$editarmaterialineaenfasis = mysql_query($query_editarmaterialineaenfasis, $sala) or die("$query_editarmaterialineaenfasis");
		$totalRows_editarmaterialineaenfasis = mysql_num_rows($editarmaterialineaenfasis);
		if($totalRows_editarmaterialineaenfasis != "")
		{
			$row_editarmaterialineaenfasis = mysql_fetch_assoc($editarmaterialineaenfasis);
			$nombre = $row_editarmaterialineaenfasis['nombremateria'];
			$codigo = $row_editarmaterialineaenfasis['codigomateriadetallelineaenfasisplanestudio'];
			$semestre = $row_editarmaterialineaenfasis['semestredetallelineaenfasisplanestudio'];
			$valor = $row_editarmaterialineaenfasis['valormateriadetallelineaenfasisplanestudio'];
			$creditos = $row_editarmaterialineaenfasis['numerocreditosdetallelineaenfasisplanestudio'];
			$horassemanales = $row_editarmaterialineaenfasis['numerohorassemanales'];
			$tipomateria = $row_editarmaterialineaenfasis['nombretipomateria'];
			$codigotipomateria = $row_editarmaterialineaenfasis['codigotipomateria'];
			$fechainicio = ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_editarmaterialineaenfasis['fechainiciodetallelineaenfasisplanestudio']);
			$fechavencimiento = ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_editarmaterialineaenfasis['fechavencimientodetallelineaenfasisplanestudio']);
			if($_POST['accionmateria'] == "Editar" || isset($_POST['aceptaredicion']) || $_GET['accionmateria'] == "Editar")
			{
?>
<p align="center"><strong>Edición</strong></p>
<?php
				require_once("editarmateriaenfasis.php");
			}
			if($_POST['accionmateria'] == "Visualizar" || $_GET['accionmateria'] == "Visualizar")
			{
?>
<p align="center"><strong>Visualización</strong></p>
<?php
				require_once("visualizarmateriaenfasis.php");
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
<?php
// Seleccion de las materias que son papas
$query_materiabase = "select d.codigomateria, d.semestredetalleplanestudio*1 as semestre, m.nombremateria
from detalleplanestudio d, materia m
where d.idplanestudio = '$idplanestudio'
and d.codigotipomateria = '5'
and m.codigomateria = d.codigomateria
order by 2 ";
$materiabase = mysql_query($query_materiabase, $sala) or die("$query_materiabase");
$totalRows_materiabase = mysql_num_rows($materiabase);
$tieneporeditarlinea = false;
while($row_materiabase = mysql_fetch_assoc($materiabase))
{
	$query_detallelinea = "select idlineaenfasisplanestudio
	from detallelineaenfasisplanestudio
	where idplanestudio = '$idplanestudio'
	and idlineaenfasisplanestudio = '$idlineaenfasis'
	and codigomateria = '".$row_materiabase['codigomateria']."'";
	$detallelinea = mysql_query($query_detallelinea, $sala) or die("$query_detallelinea");
	$row_detallelinea = mysql_fetch_assoc($detallelinea);
	$totalRows_detallelinea = mysql_num_rows($detallelinea);
	if($totalRows_detallelinea == "")
	{
		$tieneporeditarlinea = true;
	}
}
if($tieneporeditarlinea)
{
?>
	<input type="button" name="continuar" value="Continuar" style="width:80px" onClick="window.location.href='<?php echo 'visualizarlineadeenfasis.php?planestudio='.$idplanestudio.'&lineaenfasis='.$idlineaenfasis.'';?>'"
	<?php if($tienemateriasporeditar) echo "disabled";?>>
<?php
}
else
{
?>
	<input type="button" name="continuar" value="Continuar" style="width:80px" onClick="window.location.href='<?php echo 'materiaslineadeenfasisporsemestre.php?planestudio='.$idplanestudio.'&lineaenfasis='.$idlineaenfasis.'&lineamodificar=1';?>'"
	<?php if($tienemateriasporeditar) echo "disabled";?>>
<?php
}
?>
	</td>
  </tr>
</table>
</form>
<?php
if($formulariovalido)
{
	if(isset($_POST['aceptaredicion']))
	{
		$query_updlineaenfasis = "UPDATE detallelineaenfasisplanestudio
		SET fechainiciodetallelineaenfasisplanestudio='$validarfechainicio', fechavencimientodetallelineaenfasisplanestudio='$fechavencimiento', codigoestadodetallelineaenfasisplanestudio='100'
		where idlineaenfasisplanestudio = '$idlineaenfasis'
		and idplanestudio = '$idplanestudio'
		and codigomateria = '$codigomateriapapa'
		and codigomateriadetallelineaenfasisplanestudio = '$codigoeditarmateria'";
		//echo "$query_upddetalleplanestudio";
		//exit();
		$updlineaenfasis = mysql_query($query_updlineaenfasis, $sala) or die("$query_updlineaenfasis");

		echo '<script language="javascript">
		window.location.href="editarmateriaslineadeenfasisseleccionadas.php?planestudio='.$idplanestudio.'&listados='.$codigoeditarmateria.'&accionmateria=Visualizar&lineaenfasis='.$idlineaenfasis.'&materiapapa='.$codigomateriapapa.'";
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
		window.location.href="visualizarhijoslineadeenfasis.php?planestudio='.$idplanestudio.'&lineaenfasis='.$idlineaenfasis.'&materiapapa='.$codigomateriapapa.'";
	}
	</script>';
}
echo '<script language="javascript">
function regresarinicio()
{
	window.location.href="lineadeenfasisinicial.php?planestudio='.$idplanestudio.'&lineaenfasis='.$idlineaenfasis.'"
}
</script>';
?>
</html>
