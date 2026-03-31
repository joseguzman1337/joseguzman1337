<?php
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
$ruta="../../";
require_once('../claseordenpago.php');
$numeroordenpago = $_GET['numeroordenpago'];
$codigoestudiante = $_GET['codigoestudiante'];
$codigocarrera = $_GET['codigocarrera'];
$codigoperiodo = $_GET['codigoperiodo'];

$orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo, $numeroordenpago);
if(isset($_GET['Eliminar']))
{
	$orden->eliminardetalleordenpago($_GET['codigoconcepto']);
}
if(isset($_GET['Cerrar']))
{
	echo "<script language='javascript'>
	window.opener.recargar('?numeroordenpago=$numeroordenpago&codigoestudiante=$codigoestudiante&codigocarrera=$codigocarrera');
	window.opener.focus();
	window.close();
   	</script>";
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
<title>Adicionar detalle</title>
<script language="javascript">
function validar(formulario) 
{
	if(formulario.codigoconcepto.value == 0) 
	{
		alert("Debe seleccionar un concepto");
		formulario.codigoconcepto.focus();
		return (false);
  	}
	if(formulario.cantidad.value.search(/^[0-9]+$/))
	{
		alert("La cantidad debe ser numérica");
		formulario.cantidad.select();
		formulario.cantidad.focus();
		return (false);
  	}
	if(formulario.valor.value.search(/^[0-9]+$/))
	{
		alert("El valor debe ser numérico");
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
<table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bordercolor="#336633"> 
      <td colspan="5" class="Estilo1 Estilo4 Estilo1"> <div align="center"><strong>EDITAR DETALLE 
          ORDEN DE PAGO </strong></div></td>
    </tr>
    <tr bgcolor="#C5D5D6"> 
      <td class="Estilo1 Estilo4 Estilo1" width="20%"> <div align="center" class="Estilo20"><strong>C&oacute;digo 
      Concepto </strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1" width="50%"> <div align="center" class="Estilo20"><strong>Concepto</strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1" width="10%"> <div align="center" class="Estilo20"><strong>Cantidad</strong></div></td>
	  <td class="Estilo1 Estilo4 Estilo1" width="20%"> <div align="center" class="Estilo20"><strong>Valor</strong></div></td>
	  <td class="Estilo1 Estilo4 Estilo1" width="20%"> <div align="center" class="Estilo20"><strong>&nbsp;</strong></div></td>
    </tr>
<?php 
$banderadeudas = 0; 
$query_deudas = "SELECT * 
FROM detalleordenpago d,concepto c,tipoconcepto t
WHERE d.numeroordenpago = '$numeroordenpago'
AND d.codigoconcepto = c.codigoconcepto
AND c.codigotipoconcepto = t.codigotipoconcepto";	
$deudas=mysql_query($query_deudas,$sala);
//echo "$query_deudas";
$totalRows_deudas = mysql_num_rows($deudas);     
$row_deudas=mysql_fetch_array($deudas);  
$fechaconpecuniarios = false;
if($totalRows_deudas != "")
{
	do
	{  
		if($row_deudas['codigotipodetalleordenpago'] == '2' )//&& $solucion['codigotipoconcepto'] == '01')
		{
			$banderadeudas = 1;
		}	
		if($row_deudas['codigotipodetalleordenpago'] == '3' )//&& $solucion['codigotipoconcepto'] == '01')
		{
			$fechaconpecuniarios = true;
		}
?>
    <tr>
    <td class="Estilo4 Estilo1"  width="20%" align="center"><span class="Estilo6"><strong><strong><?php echo $row_deudas['codigoconcepto'];?></strong></strong></span></td>
    <td class="Estilo4 Estilo1"  width="50%" align="left"><span class="Estilo6"><strong>
<?php 
		echo $row_deudas['nombreconcepto'];
		if($row_deudas['codigotipoconcepto'] == 01)
		{
			echo "(+)";
		}	
		if($row_deudas['codigotipoconcepto'] == 02)
		{
			echo "(-)";
		}
?>
	<span class="Estilo8 Estilo20"> </span></strong></span></td>
    <td class="Estilo4 Estilo1" width="10%" align="center"><span class="Estilo6"><strong><strong>&nbsp;<?php echo $row_deudas['cantidaddetalleordenpago'];?></strong></strong></span></td>
    <td class="Estilo4 Estilo1" width="20%" align="right"><span class="Estilo6">$&nbsp;<?php echo number_format($row_deudas['valorconcepto'],2);?></span></td>
	<td class="Estilo4 Estilo1" width="20%" align="right"><span class="Estilo6">&nbsp;<input type="button" name="Eliminar<?php echo $row_deudas['codigoconcepto'];?>" value="Eliminar" onClick="confirmar('<?php echo "eliminardetalle.php?numeroordenpago=$numeroordenpago&codigoestudiante=$codigoestudiante&codigocarrera=$codigocarrera&codigoperiodo=$codigoperiodo&codigoconcepto=".$row_deudas['codigoconcepto'];?>')"></span></td>
  </tr>
<?php		
	}
	while ($row_deudas=mysql_fetch_array($deudas));
}
?>
    <tr>
    <td class="Estilo4 Estilo1"  width="20%" align="center" colspan="5"><span class="Estilo6"><strong><input type="submit" value="Cerrar" name="Cerrar" style="width: 80px"></strong></span></td>
    </tr>
<?php
?>
</table>	 
</form>
</body>
<script language="javascript">
	function confirmar(dir)
	{
		if(confirm("¿Desea eliminar este concepto?"))
		{
			window.location.reload(dir+"&Eliminar");
		}
	}
</script>
</html>
