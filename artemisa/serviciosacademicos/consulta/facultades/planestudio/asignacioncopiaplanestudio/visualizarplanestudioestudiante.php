<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);
//session_start();
?>
<html>
<head>
<title>Visualizar Plan de Estudio a un Estudiante</title>
</head>
<body>
<div align="center">
<form action="" method="post" name="f1">
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
$query_solicitud = "select pe.idplanestudio, concat(e.apellidosestudiante,' ',e.nombresestudiante) as nombre, p.nombreplanestudio, e.numerodocumento, pe.fechainicioplanestudioestudiante, pe.fechavencimientoplanestudioestudiante
from planestudioestudiante pe, estudiante e, planestudio p
where pe.codigoestudiante = '".$_GET['estudiante']."'
and pe.codigoestadoplanestudioestudiante = '101'
and pe.idplanestudio = p.idplanestudio
and p.codigoestadoplanestudio = '100'
and pe.codigoestudiante = e.codigoestudiante";
//AND est.codigocarrera = '$codigocarrera'
$res_solicitud = mysql_query($query_solicitud, $sala) or die("$query_solicitud");
$solicitud = mysql_fetch_assoc($res_solicitud);
$est = $solicitud["nombre"];
$cc = $solicitud["numerodocumento"];
$cod = $_GET['estudiante'];
$nombreplanestudio = $solicitud["nombreplanestudio"];
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
  <td align="center" colspan="2"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$solicitud["fechainicioplanestudioestudiante"]);?></td>
	<td align="center" colspan="2"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$solicitud["fechavencimientoplanestudioestudiante"]);?></td>
  </tr>
</table>
<p>
<input type="button" onClick="history.go(-3)" value="Regresar">
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
