<? include_once("../inc/numeroaletras.php");
   include_once "../inc/var.inc.php";
   include_once "../inc/"."conexion.inc.php";
   Conexion();

$array_ids=array("1");
$array_ids=split(":",$pedidos);


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Recibo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {
	background-color: #F8F8F0;
}
-->
</style>
<link href="../images/recibo.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="669"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="669" height="73"  border="0" align="center" background="../images/head.jpg">
        <tr>
          <td width="269">&nbsp;</td>
          <td width="200"><div align="center" class="style4">Recibo n&uacute;mero: <span class="style1"><? echo $id_recibo;?> </span></div></td>
          <td width="200" valign="middle" class="style4"><div align="center">Fecha: <span class="style1"><?  $Dia = date ("d");
    $Mes = date ("m");
    $Anio = date ("Y");
    $FechaHoy =$Anio."-".$Mes."-".$Dia;
	echo " ".$FechaHoy;?></span></div></td>
        </tr>
    </table>      <hr width="669" size="1" noshade class="style4">
    <table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td><table width="550" height="200" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr><td class="style6">Id Pedido</td><td class="style6">Cantidad de Paginas</td><td class="style6">Total</td></tr>
		  <?

           for ($i=0;$i<sizeof($array_ids)-1;$i++)
           {
             $instruccion="select Id,Numero_Paginas from PedHist where Id='".$array_ids[$i]."'";
			 //echo $instruccion;
			 $result=mysql_query($instruccion);
			 $row=mysql_fetch_row($result);
             //echo "ValorPag:".$valorPag;
		   ?>
		  <tr><td class="style6"><? echo $row[0];?></td><td class="style6"><? echo $row[1];?></td><td class="style6"><? echo ($valorPag*$row[1])."$";?></td>
          </tr>
		  <?
		  }?>
			<tr>  
			  <td width="75%" class="style6" colspan="4">
			  Recib&iacute; de: <? echo $nombre;?>&nbsp;&nbsp;&nbsp;la cantidad de:&nbsp;&nbsp;<? echo $totalapagar." $";?>&nbsp;&nbsp; <? echo makewords($totalapagar); ?>&nbsp;&nbsp;en concepto de Reprints             </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
			<td width="275" height="50" align="center" valign="middle" class="style4"><p align="center">______________________________<br>
              Firma</p>              </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>---------------------------------------------------------------------------------------------------------------</td>
      </tr>
    </table>    </td>
  </tr>
</table>
<br>
<table width="669"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="669" height="73"  border="0" align="center" background="../images/head.jpg">
        <tr>
          <td width="269">&nbsp;</td>
          <td width="200"><div align="center" class="style4">Recibo n&uacute;mero: <span class="style1"><? echo $id_recibo;?> </span></div></td>
          <td width="200" valign="middle" class="style4"><div align="center">Fecha: <span class="style1"><?  $Dia = date ("d");
    $Mes = date ("m");
    $Anio = date ("Y");
    $FechaHoy =$Anio."-".$Mes."-".$Dia;
	echo " ".$FechaHoy;?></span></div></td>
        </tr>
    </table>      <hr width="669" size="1" noshade class="style4">
    <table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td><table width="550" height="200" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr><td class="style6">Id Pedido</td><td class="style6">Paginas</td><td class="style6">Total</td></tr>
		  <?

           for ($i=0;$i<sizeof($array_ids)-1;$i++)
           {
             $instruccion="select Id,Numero_Paginas from PedHist where Id='".$array_ids[$i]."'";
			 //echo $instruccion;
			 $result=mysql_query($instruccion);
			 $row=mysql_fetch_row($result);
             //echo "ValorPag:".$valorPag;
		   ?>
		  <tr><td class="style6"><? echo $row[0];?></td><td class="style6"><? echo $row[1];?></td><td class="style6"><? echo ($valorPag*$row[1])."$";?></td>
          </tr>
		  <?
		  }?>
			<tr>  
			  <td width="75%" class="style6" colspan="4">
			  Recib&iacute; de: <? echo $nombre;?>&nbsp;&nbsp;&nbsp;la cantidad de:&nbsp;&nbsp;<? echo $totalapagar." $";?>&nbsp;&nbsp; <? echo makewords($totalapagar); ?>&nbsp;&nbsp;En concepto de Reprints             </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
			<td width="275" height="50" align="center" valign="middle" class="style4"><p align="center">______________________________<br>
              Firma</p>              </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>---------------------------------------------------------------------------------------------------------------</td>
      </tr>
    </table>    </td>
  </tr>
</table>
<INPUT TYPE="submit" value="Imprimir" onclick="javascript:window.print();">
</body>
</html>
