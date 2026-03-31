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
if(isset($_GET['Eliminar']))
{
	$orden->eliminarfechaordenpago($_GET['fecha'], $_GET['valor']);
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
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><strong>Tipo de Matricula </strong></div></td>
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><strong>Paguese Hasta </strong></div></td>      
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><strong>Total a Pagar </strong></div></td>
	<td width="20%" class="Estilo4 Estilo1">&nbsp;</td>
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
if($totalRows_selfechas != "")
{
	$contadorfechas = 1;
	do
	{
?>
    <tr>
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo "Pago $contadorfechas";?></span></div></td>
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $fechas['fechaordenpago'];?></span></div></td>
    <td width="20%" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6">$&nbsp;<?php echo number_format($fechas['valorfechaordenpago'],2);?></span></div></td>
	<td class="Estilo4 Estilo1" width="20%" align="center"><span class="Estilo6">&nbsp;<input type="button" name="Eliminar" value="Eliminar" onClick="confirmar('<?php echo "eliminarfecha.php?numeroordenpago=$numeroordenpago&codigoestudiante=$codigoestudiante&codigocarrera=$codigocarrera&codigoperiodo=$codigoperiodo&codigoindicadortipocarrera=$codigoindicadortipocarrera&fecha=".$fechas['fechaordenpago']."&valor=".$fechas['valorfechaordenpago'];?>')"></span></td>
  </tr>
<?php
		$contadorfechas ++;
	}
	while($fechas=mysql_fetch_array($queryfechas));
}
?>
 <tr>
    <td class="Estilo4 Estilo1" colspan="4" align="center"><span class="Estilo6"><strong><input type="submit" value="Cerrar" name="Cerrar" style="width: 80px"></strong></span></td>
  </tr>
</table>
</form>
</body>
<script language="javascript">
	function confirmar(dir)
	{
		if(confirm("¿Desea eliminar esta fecha?"))
		{
			window.location.reload(dir+"&Eliminar");
		}
	}
</script>
</html>
