<?php
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
$ruta="../../";
require_once('../claseordenpago.php');
$numeroordenpago = $_GET['numeroordenpago'];
$codigoestudiante = $_GET['codigoestudiante'];
$codigocarrera = $_GET['codigocarrera'];
$codigoperiodo = $_GET['codigoperiodo'];
$codigoindicadortipocarrera = $_GET['codigoindicadortipocarrera'];

$orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo, $numeroordenpago, $idprematricula=1, $fechaentregaordenpago=0, $codigoestadoordenpago=70);
if(isset($_GET['Aceptar']))
{
	//($fechadetallefechafinanciera, $porcentajedetallefechafinanciera, $totalconrecargo)
	$orden->insertarfechaordenpago($_GET['fecha'], 0, $_GET['valor']);
}
if(isset($_GET['Cerrar']))
{
	//echo "?numeroordenpago=$numeroordenpago&codigoestudiante=$codigoestudiante&codigocarrera=$codigocarrera";
	//exit();
	echo "<script language='javascript'>
	window.opener.recargar('?numeroordenpago=$numeroordenpago&codigoestudiante=$codigoestudiante&codigocarrera=$codigocarrera');
	window.opener.focus();
	window.close();
   	</script>";
}

$query_deudas = "SELECT * 
FROM detalleordenpago d,concepto c,tipoconcepto t
WHERE d.numeroordenpago = '$numeroordenpago'
AND d.codigoconcepto = c.codigoconcepto
AND c.codigotipoconcepto = t.codigotipoconcepto";	
$deudas=mysql_query($query_deudas,$sala);
$totalRows_deudas = mysql_num_rows($deudas);
$valordeudas = 0;     
while($row_deudas=mysql_fetch_array($deudas))
{
	if($row_deudas['codigotipoconcepto'] == 01)
	{
		$valordeudas = $valordeudas + $row_deudas['valorconcepto'];
	}	
	if($row_deudas['codigotipoconcepto'] == 02)
	{
		$valordeudas = $valordeudas - $row_deudas['valorconcepto'];
	}
}
?>
<html>
<head>
<style type="text/css">
<!--
.Estilo1 {
	font-family: tahoma;
	font-size: x-small;
}
.Estilo2 {font-size: x-small}
.Estilo16 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo17 {font-size: 16px}
.Estilo18 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo19 {
	font-size: xx-small;
	font-weight: bold;
}
.Estilo20 {font-size: xx-small}
.Estilo21 {font-size: 12px}
-->
</style>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<title>Adicionar fecha</title>
<script language="javascript">
function validar(formulario) 
{
	if(formulario.idfechafinaciera.value == 0) 
	{
		alert("Debe seleccionar un concepto");
		formulario.codigoconcepto.focus();
		return (false);
  	}
	//fecha = new Date();
	/*if(formulario.fecha.value.search(/^(1[0-9]{3})-([1-9]{1}|0[1-9]{1}|1[0-2]{1})-([1-9]{1}|[0-2]{1}[1-9]{1}|3[0-1]{1}|10|20)$/))
	{
		alert("La fecha debe ser igual o mayor a la de hoy");
		formulario.fecha.select();
		formulario.fecha.focus();
		return (false);
  	}*/
	if(formulario.fecha.value == "")
	{
		alert("Debe digitar una fecha");
		formulario.fecha.select();
		formulario.fecha.focus();
		return (false);
  	}
	if(formulario.valor.value.search(/^[0-9]+$/))
	{
		alert("El valor debe ser numérico");
		formulario.valor.select();
		formulario.valor.focus();
		return (false);
  	}
	if(formulario.valor.value <= 0)
	{
		alert("El valor debe ser mayor que cero");
		formulario.valor.select();
		formulario.valor.focus();
		return (false);
  	}
}
</script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
</head>

<body>
<form name="form1" method="get" action="" onSubmit = "return validar(this)">
<input type="hidden" name="numeroordenpago" value="<?php echo $numeroordenpago; ?>">
<input type="hidden" name="codigoestudiante" value="<?php echo $codigoestudiante; ?>">
<input type="hidden" name="codigocarrera" value="<?php echo $codigocarrera; ?>">
<input type="hidden" name="codigoperiodo" value="<?php echo $codigoperiodo; ?>">
<input type="hidden" name="codigoindicadortipocarrera" value="<?php echo $codigoindicadortipocarrera; ?>">
<table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bordercolor="#006600"> 
    <td colspan="4" class="Estilo4 Estilo1"> 
    <div align="center"><strong>FECHAS DE PAGO</strong></div></td>
  </tr>
  <tr bgcolor="#C5D5D6">
    <td width="232" class="Estilo4 Estilo1"><div align="center"><strong>Tipo de Matricula </strong></div></td>
    <td width="200" class="Estilo4 Estilo1"><div align="center"><strong>Paguese Hasta </strong></div></td>      
    <td width="175" class="Estilo4 Estilo1"><div align="center"><strong>Total a Pagar </strong></div></td>
  </tr>
</table>
<table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#FF9900">
<?php 
if(!ereg("^3.+$",$codigoindicadortipocarrera))
{
	$fecha="select distinct f.fechaordenpago, f.porcentajefechaordenpago, d.nombredetallefechafinanciera, f.valorfechaordenpago
	from fechaordenpago f, detallefechafinanciera d
	where f.fechaordenpago = d.fechadetallefechafinanciera
	and f.porcentajefechaordenpago = d.porcentajedetallefechafinanciera
	and f.numeroordenpago = '$numeroordenpago'
	order by f.porcentajefechaordenpago";					
	//echo "$fecha <br>";
}
else
{
	$fecha="select distinct f.fechaordenpago, f.porcentajefechaordenpago, d.nombredetallefechaeducacioncontinuada as nombredetallefechafinanciera, f.valorfechaordenpago
	from fechaordenpago f, detallefechaeducacioncontinuada d
	where f.fechaordenpago = d.fechadetallefechaeducacioncontinuada
	and f.porcentajefechaordenpago = d.porcentajedetallefechaeducacioncontinuada
	and f.numeroordenpago = '$numeroordenpago'
	order by f.porcentajefechaordenpago";					
	//echo "$fecha <br>";
}
$queryfechas=mysql_query($fecha,$sala);     
$totalRows_selfechas = mysql_num_rows($queryfechas);     
$fechas=mysql_fetch_array($queryfechas);
$quitarpagos = "";
if($totalRows_selfechas == "")
{
	$fecha="select distinct f.fechaordenpago, f.porcentajefechaordenpago, f.valorfechaordenpago
	from fechaordenpago f
	where f.numeroordenpago = '$numeroordenpago'
	order by f.porcentajefechaordenpago";					
	//echo "$fecha <br>";
	$queryfechas=mysql_query($fecha,$sala);    
	$totalRows_selfechas = mysql_num_rows($queryfechas);     
	$fechas=mysql_fetch_array($queryfechas);
	$fechas['nombredetallefechafinanciera'] = "Pago 1";
	$quitarpagos = $quitarpagos." and d.nombredetallefechafinanciera <> 'Pago 1'";
}
$contadorfechas = 1;
if($totalRows_selfechas != "")
{
	do
	{
?>
    <tr>
    <td width="232" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo "Pago $contadorfechas";?></span></div></td>
    <td width="200" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $fechas['fechaordenpago'];?></span></div></td>
    <td width="175" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6">$&nbsp;<?php echo number_format($fechas['valorfechaordenpago'],2);?></span></div></td>
  </tr>
<?php
			$contadorfechas ++;
	}
	while($fechas=mysql_fetch_array($queryfechas));
}
if(isset($_GET['Adicionar']))
{
?>
  <tr>
    <td width="232" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6">
<?php
	$query_seltipomatricula = "select d.nombredetallefechafinanciera, d.idfechafinanciera
	from detallefechafinanciera d, fechafinanciera f
	where f.idfechafinanciera = d.idfechafinanciera
	and f.codigoperiodo = '$codigoperiodo'
	and f.codigocarrera = '$codigocarrera'
	group by 1";	
	$seltipomatricula = mysql_query($query_seltipomatricula,$sala);
	$totalRows_seltipomatricula = mysql_num_rows($seltipomatricula); 
	$row_seltipomatricula = mysql_fetch_array($seltipomatricula);    
?>	
	<input type="text" value="<?php echo "Pago $contadorfechas"; ?>" name="idfechafinaciera" readonly="true" size="15" style="font-size:9px">
	</span></div></td>
    <td width="200" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><input type="text" name="fecha" style="font-size:9px" size="8" maxlength="10" readonly="true"></span></div></td>
    <td width="175" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6">$&nbsp;<input type="text" name="valor" style="font-size:9px" value="<?php echo $valordeudas;?>"></span></div></td>
  </tr>
  <tr>
    <td class="Estilo4 Estilo1" colspan="3" align="center"><input type="submit" name="Aceptar" value="Aceptar" style="width: 80px"><input type="button" value="Cancelar" name="Cancelar" onClick="history.go(-1)" style="width: 80px"></td>
	
<?php
}
if(!isset($_GET['Adicionar']))
{
?>
 <tr>
    <td class="Estilo4 Estilo1" colspan="3" align="center"><span class="Estilo6"><strong><input type="submit" value="Adicionar" name="Adicionar" style="width: 80px"><input type="submit" value="Cerrar" name="Cerrar" style="width: 80px"></strong></span></td>
  </tr>
</table>
<?php
}
?>  
</form>
</body>
<?php
if(isset($_GET['Adicionar']))
{
?>
<script type="text/javascript">
	Calendar.setup(
	{ inputField : "fecha", // ID of the input field
		ifFormat : "%Y-%m-%d", // the date format
		text : "fecha" // ID of the button
	});
</script>
<?php
}
?>
</html>
