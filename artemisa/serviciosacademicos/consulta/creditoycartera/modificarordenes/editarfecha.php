<?php
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
$ruta="../../../funciones/";
require_once('../../../funciones/ordenpago/claseordenpago.php');
$numeroordenpago = $_GET['numeroordenpago'];
$codigoestudiante = $_GET['codigoestudiante'];
$codigocarrera = $_GET['codigocarrera'];
$codigoperiodo = $_GET['codigoperiodo'];
$codigoindicadortipocarrera = $_GET['codigoindicadortipocarrera'];

$orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo, $numeroordenpago, $idprematricula=1, $fechaentregaordenpago=0, $codigoestadoordenpago=70);
if(isset($_GET['Aceptar']))
{
	$orden->modificarfechaordenpago($_GET['fechaini'], $_GET['valorini'], $_GET['fecha'], $_GET['valor']);
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
<table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#E9E9E9">
  <tr bordercolor="#E9E9E9"> 
    <td colspan="4" class="Estilo4 Estilo1"> 
    <div align="center"><strong>FECHAS DE PAGO</strong></div></td>
  </tr>
  <tr bgcolor="#E9E9E9">
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><strong>Tipo de Matricula </strong></div></td>
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><strong>Paguese Hasta </strong></div></td>      
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><strong>Total a Pagar </strong></div></td>
	<td width="20%" class="Estilo4 Estilo1">&nbsp;</td>
  </tr>
</table>
<table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#E9E9E9">
<?php 
if(!ereg("^3.+$",$codigoindicadortipocarrera))
{
	$fecha="SELECT DISTINCT f.fechaordenpago, f.porcentajefechaordenpago, f.valorfechaordenpago 
			FROM fechaordenpago f
			WHERE f.numeroordenpago = '$numeroordenpago' 
			ORDER BY f.porcentajefechaordenpago ";					
	//echo "$fecha <br>";
}
else
{
	$fecha="SELECT DISTINCT f.fechaordenpago, f.porcentajefechaordenpago, f.valorfechaordenpago 
			FROM fechaordenpago f
			WHERE f.numeroordenpago = '$numeroordenpago' 
			ORDER BY f.porcentajefechaordenpago ";					
	//echo "$fecha <br>";
}
$queryfechas=mysql_query($fecha,$sala);     
$totalRows_selfechas = mysql_num_rows($queryfechas);     
$fechas=mysql_fetch_array($queryfechas);
$quitarpagos = "";
$editar = false;
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
if($totalRows_selfechas != "")
{
	$contadorfechas = 1;
	do
	{
		if(!isset($_GET['Editar'.$contadorfechas]))
		{
?>
    <tr>
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo "Pago $contadorfechas";?></span></div></td>
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $fechas['fechaordenpago'];?></span></div></td>
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6">$&nbsp;<?php echo number_format($fechas['valorfechaordenpago'],2);?></span></div></td>
	<td class="Estilo4 Estilo1" width="20%" align="center"><span class="Estilo6">&nbsp;<input type="submit" name="Editar<?php echo $contadorfechas;?>" value="Editar"></span></td>
  </tr>
<?php
		}
		else
		{
			$editar = true;
?>
  <tr>
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6">
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
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><input type="text" name="fecha" style="font-size:9px" size="8" maxlength="10" readonly="true" value="<?php echo $fechas['fechaordenpago'];?>"></span></div></td>
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6">$&nbsp;<input type="text" name="valor" style="font-size:9px" value="<?php echo $fechas['valorfechaordenpago'];?>"></span></div></td>
	<td class="Estilo4 Estilo1" width="20%" align="center"><span class="Estilo6">
	<input type="hidden" name="valorini" value="<?php echo $fechas['valorfechaordenpago'];?>">
	<input type="hidden" name="fechaini" value="<?php echo $fechas['fechaordenpago'];?>">
	<input type="submit" name="Aceptar" value="OK" style="font-size:9px"> <input type="button" name="Aceptar" value="Cancelar" style="font-size:9px" onClick="window.location.reload('editarfecha.php?<?php echo "numeroordenpago=$numeroordenpago&codigoestudiante=$codigoestudiante&codigocarrera=$codigocarrera&codigoperiodo=$codigoperiodo&codigoindicadortipocarrera=$codigoindicadortipocarrera";?>')"></span></td>
  </tr>
<?php	
		}
		$contadorfechas ++;
	}
	while($fechas=mysql_fetch_array($queryfechas));
}
if(!$editar)
{
?>
 <tr>
    <td class="Estilo4 Estilo1" colspan="4" align="center"><span class="Estilo6"><strong><input type="submit" value="Cerrar" name="Cerrar" style="width: 80px"></strong></span></td>
  </tr>
<?php
}
?>  
</table>
</form>
</body>
<?php
if($editar)
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
