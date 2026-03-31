<?php
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
$ruta="../../../funciones/";
require_once('../../../funciones/ordenpago/claseordenpago.php');
$numeroordenpago = $_GET['numeroordenpago'];
$codigoestudiante = $_GET['codigoestudiante'];
$codigocarrera = $_GET['codigocarrera'];
$codigoperiodo = $_GET['codigoperiodo'];

$orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo, $numeroordenpago, $idprematricula=1, $fechaentregaordenpago=0, $codigoestadoordenpago=70);
if(isset($_GET['Aceptar']))
{
	$orden->insertardetalleordenpago($_GET['codigoconcepto'], $_GET['cantidad'], $_GET['valor'], 1);
	
	$query_delfechaordenpago = "DELETE FROM fechaordenpago 
	WHERE numeroordenpago = '$numeroordenpago'"; 
	$delfechaordenpago = mysql_query($query_delfechaordenpago,$sala) or die("$query_delfechaordenpago<br>".mysql_error()); 
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
<table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#E9E9E9">
    <tr bordercolor="#E9E9E9"> 
      <td colspan="4" class="Estilo1 Estilo4 Estilo1"> <div align="center"><strong>ADICIONAR DETALLE 
          ORDEN DE PAGO </strong></div></td>
    </tr>
    <tr bgcolor="#E9E9E9"> 
      <td class="Estilo1 Estilo4 Estilo1" width="20%"> <div align="center" class="Estilo20"><strong>C&oacute;digo 
      Concepto </strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1" width="50%"> <div align="center" class="Estilo20"><strong>Concepto</strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1" width="10%"> <div align="center" class="Estilo20"><strong>Cantidad</strong></div></td>
	  <td class="Estilo1 Estilo4 Estilo1" width="20%"> <div align="center" class="Estilo20"><strong>Valor</strong></div></td>
    </tr>
<?php 
$banderadeudas = 0; 
$query_deudas = "SELECT * 
FROM detalleordenpago d,concepto c,tipoconcepto t
WHERE d.numeroordenpago = '$numeroordenpago'
AND d.codigoconcepto = c.codigoconcepto
AND c.codigotipoconcepto = t.codigotipoconcepto";	
$deudas=mysql_query($query_deudas,$sala);
$totalRows_deudas = mysql_num_rows($deudas);     
$row_deudas=mysql_fetch_array($deudas);  
$fechaconpecuniarios = false;

$quitarconceptos = "";
if($totalRows_deudas != "")
{
	do
	{  
		$quitarconceptos = "$quitarconceptos and c.codigoconcepto <> '".$row_deudas['codigoconcepto']."'";
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
    <td class="Estilo4 Estilo1" width="10%" align="center"><span class="Estilo6"><strong><strong><?php echo $row_deudas['cantidaddetalleordenpago'];?></strong></strong></span></td>
    <td class="Estilo4 Estilo1" width="20%" align="right"><span class="Estilo6">$&nbsp;&nbsp;<?php echo number_format($row_deudas['valorconcepto'],2);?></span></td>
  </tr>
<?php	 
	}
	while ($row_deudas=mysql_fetch_array($deudas));
}
if(isset($_GET['Adicionar']))
{
?>
    <tr>
    <td class="Estilo4 Estilo1"  width="20%" align="center"><span class="Estilo6"><strong><strong>&nbsp;</strong></strong></span></td>
    <td class="Estilo4 Estilo1"  width="50%" align="left"><span class="Estilo6"><strong><span class="Estilo6"><strong><strong>
	<select name="codigoconcepto" style="font-size:9px">
	<option value="0">Seleccione</option>
<?php
	$query_selconcepto = "SELECT c.codigoconcepto, c.nombreconcepto, c.codigotipoconcepto 
	FROM concepto c
	WHERE c.codigoestado like '1%'
	$quitarconceptos
	order by 2";	
	$selconcepto = mysql_query($query_selconcepto,$sala);
	$totalRows_selconcepto = mysql_num_rows($selconcepto);   
	while($row_selconcepto = mysql_fetch_array($selconcepto))
	{
?>
  <option value="<?php echo $row_selconcepto['codigoconcepto'];?>">
<?php 
		echo $row_selconcepto['nombreconcepto'];
		if($row_selconcepto['codigotipoconcepto'] == 01)
		{
			echo "(+)";
		}	
		if($row_selconcepto['codigotipoconcepto'] == 02)
		{
			echo "(-)";
		}
?>
</option>
<?php
	}
?>	
	</select>
	</strong></strong></span>
	<span class="Estilo8 Estilo20"> </span></strong></span></td>
    <td class="Estilo4 Estilo1" width="10%" align="center"><span class="Estilo6"><strong><strong><input type="text" name="cantidad" style="font-size:9px"></strong></strong></span></td>
    <td class="Estilo4 Estilo1" width="20%" align="right"><span class="Estilo6"><input type="text" name="valor" style="font-size:9px"></span></td>
  </tr>
  <tr>
    <td class="Estilo4 Estilo1"  width="20%" align="center" colspan="4"><span class="Estilo6"><strong><strong><input type="submit" value="Aceptar" name="Aceptar" style="width: 80px"><input type="button" value="Cancelar" name="Cancelar" onClick="history.go(-1)" style="width: 80px"></strong></strong></span></td>
    </tr>
<?php
}
else
{
?>
    <tr>
    <td class="Estilo4 Estilo1"  width="20%" align="center" colspan="4"><span class="Estilo6"><strong><strong><input type="submit" value="Adicionar" name="Adicionar" style="width: 80px"><input type="submit" value="Cerrar" name="Cerrar" style="width: 80px"></strong></strong></span></td>
    </tr>
<?php
}
?>
</table>	 
</form>
</body>
</html>
