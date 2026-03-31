<? include_once("../inc/numeroaletras.php");?>
<html>
<body>
<table border="0" width="100%">
<tr>
<td width="75%">
<img src="institucional.gif" width="100" height="60">X&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Recibo Nro: <? echo $id_recibo;?></td><td width="25%"><?  $Dia = date ("d");
    $Mes = date ("m");
    $Anio = date ("Y");
    $FechaHoy =$Anio."-".$Mes."-".$Dia;
	echo "Fecha: &nbsp;".$FechaHoy;?>
</td>
</tr>
<tr>
<td>&nbsp;<td></td>&nbsp;</td>
</tr>
<tr>
<td>Id Pedido :&nbsp;&nbsp;&nbsp;<b><? echo $idPedido;?></b><td></td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;<td></td>&nbsp;</td>
</tr>

<tr>
<td>Recibi de&nbsp;&nbsp; : <b><? echo $nombre;?></b><td></td>&nbsp;</td>
</tr>
<tr>
<td>La Cantidad de &nbsp;&nbsp; <? echo makewords($totalapagar); ?><td></td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td><td>&nbsp;</td>
</tr>
<tr>
<td>En concepto de Reprints</td><td>&nbsp;</td>
</tr>
<tr>
<td>La cantidad de &nbsp;&nbsp;<b><? echo $cantPag; ?></b>&nbsp;&nbsp;paginas con un valor de&nbsp;&nbsp;<b><? echo $valorPag;?>&nbsp;&nbsp;</b>&nbsp;&nbsp;centavos </td><td>&nbsp;</td>
</tr>
<tr>
<td width="70%">Son $ <b><? echo $totalapagar;?></b></td><td width="30">Firma: &nbsp;</td>
</tr>
</table>
<br>
<br>
<br>
-------------------------------------------------------------------------------------------------------------
<br>
<br>
<table border="0" width="100%">
<tr>
<td width="75%">
<img src="institucional.gif" width="100" height="60">X&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Recibo Nro: <? echo $id_recibo;?></td><td width="25%"><?  $Dia = date ("d");
    $Mes = date ("m");
    $Anio = date ("Y");
    $FechaHoy =$Anio."-".$Mes."-".$Dia;
	echo "Fecha: &nbsp;".$FechaHoy;?>
</td>
</tr>
<tr>
<td>&nbsp;<td></td>&nbsp;</td>
</tr>
<tr>
<td>Id Pedido :&nbsp;&nbsp;&nbsp;<b><? echo $idPedido;?></b><td></td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;<td></td>&nbsp;</td>
</tr>

<tr>
<td>Recibi de&nbsp;&nbsp; : <b><? echo $nombre;?></b><td></td>&nbsp;</td>
</tr>
<tr>
<td>La Cantidad de &nbsp;&nbsp; <? echo makewords($totalapagar); ?><td></td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td><td>&nbsp;</td>
</tr>
<tr>
<td>En concepto de Reprints</td><td>&nbsp;</td>
</tr>
<tr>
<td>La cantidad de &nbsp;&nbsp;<b><? echo $cantPag; ?></b>&nbsp;&nbsp;paginas con un valor de&nbsp;&nbsp;<b><? echo $valorPag;?>&nbsp;&nbsp;</b>&nbsp;&nbsp;centavos </td><td>&nbsp;</td>
</tr>
<tr>
<td width="70%">Son $ <b><? echo $totalapagar;?></b></td><td width="30">Firma: &nbsp;</td>
</tr>
</table>

</body>
</html>