<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
require_once('../../../../Connections/sala2.php' );
require_once('../../../../funciones/validacion.php' );
require_once('../../../../funciones/errores_plandeestudio.php' );
mysql_select_db($database_sala, $sala);
session_start();
$formulariovalido = 1;
?>
<html>
<head>
<title>Editar Plan de Estudio a un Estudiante</title>
</head>
<body>
<div align="center">
<form action="editarplanestudioestudiante.php?<?php echo "estudiante=".$_GET['estudiante']."&planestudio=".$_GET['planestudio']."";?>" method="post" name="f1">
<p align="center" class="Estilo1"><strong>INFORMACION DEL ESTUDIANTE </strong></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" class="Estilo1"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Cédula</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Código</strong>&nbsp;</td>
	<td align="center" class="Estilo1"><strong>Plan de Estudio</strong>&nbsp;</td>
  </tr>
  <tr>
<?php
$query_solicitud = "SELECT est.codigoestudiante, concat(est.apellidosestudiante,' ',est.nombresestudiante) as nombre, est.numerodocumento
FROM estudiante est
WHERE est.codigoestudiante = '".$_GET['estudiante']."'
and est.codigosituacioncarreraestudiante not like '1%'
and est.codigosituacioncarreraestudiante not like '5%'
and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'
ORDER BY est.apellidosestudiante";
$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud");
$solicitud = mysql_fetch_assoc($res_solicitud);
$est = $solicitud["nombre"];
$cc = $solicitud["numerodocumento"];
$cod = $solicitud['codigoestudiante'];

$query_selplan = "select p.nombreplanestudio
from planestudio p
where p.idplanestudio = '".$_GET['planestudio']."'";
$selplan = mysql_query($query_selplan, $sala) or die("$query_selplan");
$row_selplan = mysql_fetch_assoc($selplan);
$nombreplanestudio = $row_selplan["nombreplanestudio"];
?>
	<td><?php echo "$est&nbsp;";?></td>
	<td><?php echo "$cc&nbsp;";?></td>
	<td><?php echo "$cod&nbsp;";?></td>
	<td><?php echo "$nombreplanestudio&nbsp;";?></td>
  </tr>
  <tr>
  	<td align="center" class="Estilo1" colspan="2"><strong>Fecha de Inicio</strong></td>
	<td align="center" class="Estilo1" colspan="2"><strong>Fecha de Vencimiento</strong></td>
  </tr>
  <tr>
  <td align="center" colspan="2"><input name="pefechainicio" type="text" size="10" value="<?php if(isset($_POST['pefechainicio'])) echo $_POST['pefechainicio']; else echo "aaaa-mm-dd";?>" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
      <font size="1" face="Tahoma"><font color="#FF0000">
<?php
		if(isset($_POST['pefechainicio']))
		{
			$fechainicio = $_POST['pefechainicio'];
			$imprimir = true;
			$fechainiciofecha = validar($fechainicio,"fecha",$error3,&$imprimir);
			//echo "asda".$pefechainiciofecha;
			$formulariovalido = $formulariovalido*$fechainiciofecha;
			if($formulariovalido == 1)
			{
				$inicio = ereg_replace("-","",$_POST['pefechainicio']);
				$vencimiento = ereg_replace("-","",$_POST['pefechavencimiento']);
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
	<td align="center" colspan="2"><input name="pefechavencimiento" type="text" size="10" value="<?php if(isset($_POST['pefechavencimiento'])) echo $_POST['pefechavencimiento']; else echo "2999-12-31";?>" onBlur="iniciarvencimiento(this)" onFocus="limpiarvencimiento(this)">
      <font size="1" face="Tahoma"><font color="#FF0000">
      <?php
		if(isset($_POST['pefechavencimiento']))
		{
			$fechavencimiento = $_POST['pefechavencimiento'];
			$imprimir = true;
			$fechavencimientofecha = validar($fechavencimiento,"fecha",$error3,&$imprimir);
			$formulariovalido = $formulariovalido*$fechavencimientofecha;
			if($formulariovalido == 1)
			{
				$inicio = ereg_replace("-","",$_POST['pefechainicio']);
				$vencimiento = ereg_replace("-","",$_POST['pefechavencimiento']);
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
</table>
<p>
<input type="submit" value="Aceptar" name="aceptar">
<input type="button" onClick="history.go(-1)" value="Regresar">
</p>
</form>
</div>
</body>
<script language="javascript">
function regresar()
{
	window.location.href="plandeestudioinicial.php"
}

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
<?php
if(isset($_POST['aceptar']))
{
	if($formulariovalido)
	{
		// Código para saber el nombre del periodo
		$query_updplan = "UPDATE planestudioestudiante
		SET idplanestudio='".$_GET['planestudio']."', fechaasignacionplanestudioestudiante='".date("Y-m-d",time())."', fechainicioplanestudioestudiante='$fechainicio', fechavencimientoplanestudioestudiante='$fechavencimiento'
		WHERE codigoestudiante = '".$_GET['estudiante']."'";
		$updplan = mysql_query($query_updplan, $sala) or die("$query_updplan");
		echo'<script language="javascript">
			window.location.href="visualizarplanestudioestudiante.php?estudiante='.$_GET['estudiante'].'"
		</script>';
	}
}
?>
