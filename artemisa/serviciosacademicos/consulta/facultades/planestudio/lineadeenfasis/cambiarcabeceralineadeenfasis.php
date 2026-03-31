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
<title>Nueva línea de énfasis</title>
</head>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
-->
</style>
<body>
<div align="center">
<form name="f1" method="post" action="cambiarcabeceralineadeenfasis.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis";?>">
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
	<td align="center"><?php echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_lineaenfasis['fechacreacionlineaenfasisplanestudio']); ?></td>
  </tr>
  <tr bgcolor="#C5D5D6">
	<td align="center"><strong>Nombre De la Línea</strong></td>
  	<td align="center" colspan="2"><strong>Responsable</strong></td>
  </tr>
  <tr>
	  <td align="center"><input name="lenombre" type="text" size="20" value="<?php if(isset($_POST['lenombre'])) echo $_POST['lenombre']; else echo $row_lineaenfasis['nombrelineaenfasisplanestudio'];?>" >
	 <font color="#FF0000" size="-1">
<?php
		if(isset($_POST['lenombre']))
		{
			$nombre = $_POST['lenombre'];
			$imprimir = true;
			$nombrerequerido = validar($nombre,"requerido",$error1,&$imprimir);
			$formulariovalido = $formulariovalido*$nombrerequerido;
		}
?>
	  </font></td>
	<td align="center" colspan="2"><input name="leresponsable" type="text" size="20" value="<?php if(isset($_POST['leresponsable'])) echo $_POST['leresponsable']; else echo $row_lineaenfasis['responsablelineaenfasisplanestudio'];?>">
	<font color="#FF0000" size="-1">
<?php
		if(isset($_POST['leresponsable']))
		{
			$nombreencargado = $_POST['leresponsable'];
			$imprimir = true;
			$nombreencargadorequerido = validar($nombreencargado,"requerido",$error1,&$imprimir);
			$formulariovalido = $formulariovalido*$nombreencargadorequerido;
		}
?>
	  </font></td>
	</tr>
	<tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Fecha de Inicio</strong></td>
	<td align="center" colspan="2"><strong>Fecha de Vencimiento</strong></td>
  </tr>
  <tr>
  	<td align="center"><input name="lefechainicio" type="text" size="10" value="<?php if(isset($_POST['lefechainicio'])) echo $_POST['lefechainicio']; else echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_lineaenfasis['fechainiciolineaenfasisplanestudio']);?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
      <font size="1" face="Tahoma"><font color="#FF0000">
<?php
		if(isset($_POST['lefechainicio']))
		{
			$fechainicio = $_POST['lefechainicio'];
			$imprimir = true;
			$fechainiciofecha = validar($fechainicio,"fecha",$error3,&$imprimir);
			//echo "asda".$pefechainiciofecha;
			$formulariovalido = $formulariovalido*$fechainiciofecha;
			if($formulariovalido == 1)
			{
				$inicio = ereg_replace("-","",$_POST['lefechainicio']);
				$vencimiento = ereg_replace("-","",$_POST['lefechavencimiento']);
				if($inicio > $vencimiento)
				{
					echo "La Fecha de Inicio debe ser menor que la Fecha de Vencimiento";
					$formulariovalido = 0;
				}
				if($inicio == $vencimiento)
				{
					echo "La Fecha de Inicio debe ser diferente que la Fecha de Vencimiento";
					$formulariovalido = 0;
				}
			}
		}
?>
      </font></font></td>
	<td align="center" colspan="2"><input name="lefechavencimiento" type="text" size="10" value="<?php if(isset($_POST['lefechavencimiento'])) echo $_POST['lefechavencimiento']; else echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_lineaenfasis['fechavencimientolineaenfasisplanestudio']);?>" onBlur="iniciarvencimiento(this)" onFocus="limpiarvencimiento(this)">
      <font size="1" face="Tahoma"><font color="#FF0000">
      <?php
		if(isset($_POST['lefechavencimiento']))
		{
			$fechavencimiento = $_POST['lefechavencimiento'];
			$imprimir = true;
			$fechavencimientofecha = validar($fechavencimiento,"fecha",$error3,&$imprimir);
			$formulariovalido = $formulariovalido*$fechavencimientofecha;
			if($formulariovalido == 1)
			{
				$inicio = ereg_replace("-","",$_POST['lefechainicio']);
				$vencimiento = ereg_replace("-","",$_POST['lefechavencimiento']);
				if($inicio > $vencimiento)
				{
					echo "La Fecha de Vencimiento debe ser mayor que la Fecha de Vencimiento";
					$formulariovalido = 0;
				}
				if($inicio == $vencimiento)
				{
					echo "La Fecha de Vencimiento debe ser diferente que la Fecha de Inicio";
					$formulariovalido = 0;
				}
			}
		}
?>
      </font></font></td>
  </tr>
  <tr>
  	<td colspan="4" align="center"><br>
  	  <input type="submit" value="Aceptar" name="aceptarcabecera">
  	  <input type="button" value="Regresar" name="cancelarcabecera" onClick="window.location.href='visualizarlineadeenfasis.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis";?>'"></td>
  </tr>
</table>
<?php
if(isset($_POST['aceptarcabecera']))
{
	if($formulariovalido)
	{
		$query_updlineaenfasis = "UPDATE lineaenfasisplanestudio
		SET nombrelineaenfasisplanestudio='$nombre', fechainiciolineaenfasisplanestudio='$fechainicio', fechavencimientolineaenfasisplanestudio='$fechavencimiento', responsablelineaenfasisplanestudio='$nombreencargado', codigoestadolineaenfasisplanestudio='101'
		WHERE idlineaenfasisplanestudio = '$idlineaenfasis'
		and idplanestudio = '$idplanestudio'";
		$updlineaenfasis = mysql_query($query_updlineaenfasis, $sala) or die("$query_updlineaenfasis");

		echo '<script language="javascript">
		window.location.href="visualizarlineadeenfasis.php?planestudio='.$idplanestudio.'&lineaenfasis='.$idlineaenfasis.'";
		</script>';
	}
}
?>
</form>
</div>
</body>
<script language="javascript">
function limpiarinicio(texto)
{
	if(texto.value == "aaaa-mm-dd")
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
		texto.value = "aaaa-mm-dd";
}

function iniciarvencimiento(texto)
{
	if(texto.value == "")
		texto.value = "2999-12-31";
}

function contadorsemestre(accion)
{
	var cont;
	cont = document.f1.pesemestre.value;
	if(accion == 1)
	{
		if(cont == 12)
		{
			return;
		}
		cont++;
	}
	if(accion == 2)
	{
		if(cont == 1)
		{
			return;
		}
		cont--;
	}
	document.f1.pesemestre.value = cont;
}

function limitesemestre(texto)
{
	if(texto.value > 12)
	{
		texto.value = 12;
		return;
	}
}
</script>
</html>
