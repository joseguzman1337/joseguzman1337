<? 
  
 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";  
 include_once "../inc/"."parametros.inc.php";  
 Conexion();

 include_once "../inc/"."identif.php";
 Administracion();
 	
?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio();?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {
	margin:0px;
	background-color: #006599;
	margin-left: 11px;
}
body, td, th {
	color: #000000;
}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #000000;
}
.style23 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
.style42 {color: #FFFFFF; font-size: 9px; font-family: verdana; }
.style44 {color: #66FFFF}
.style45 {color: #FFFFFF}
.style46 {
	color: #006699;
	font-family: Verdana;
	font-size: 11px;
}
.style47 {color: #666666}
-->
</style>
<base target="_self">
</head>
<script>
function observaciones(observaciones,IdCatalogo,Nomcat)
{
  ventana=window.open("modcatalogos.php?id="+IdCatalogo+"&obs="+observaciones+"&cat="+Nomcat,"Catalogos","scrollbars=yes,width=550,height=250");

}
function reg_busqueda(IdPedido,IdCatalogo,Nomcat)
{
	document.forms.form1.action="reg_busq.php";
	document.forms.form1.Id_Pedido.value=IdPedido;
	document.forms.form1.Id_Catalogo.value=IdCatalogo;
	document.forms.form1.Nombre_Catalogo.value=Nomcat;
	document.forms.form1.submit();
}
</script>
<?
	include_once "../inc/"."fgenped.php";
	include_once "../inc/"."fgentrad.php";
	$Mensajes = Comienzo ("bus-001",$IdiomaSitio);
 
?>

<body topmargin="0">
<div align="left">
  <table width="70%"  border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#ececec">
    <tr align="center" bgcolor="#0099FF">
      <td height="20" colspan="5" class="style42">
	<? echo $Mensajes["tit-1"]." <span class='style44'>".$Id_Pedido."</span>"; ?></td>
    </tr>
    <tr bgcolor="#0099CC" class="style42">
      <td width="10" height="20" align="right" valign="middle" class="style23">        <div align="left"><span class="style45"></span></div></td>
      <td height="20" align="right" valign="middle" class="style23" width="50%"><div align="left" class="style45"><? echo $Mensajes["tf-1"]; ?></div></td>
      <td height="20" align="right" valign="middle" class="style23" width="20%"><div align="center" class="style45"><? echo $Mensajes["tf-2"]; ?></div></td>
      <td height="20" align="right" valign="middle" class="style23" width="30%"><div align="center" class="style45"><? echo $Mensajes["tf-3"]; ?></div></td>
      <td width="25" height="20" align="right" valign="middle" class="style23"><div align="center"><span class="style45"><? //echo $Mensajes["tf-4"]; ?></span></div></td>
    </tr>
<?
     $Instruccion = "SELECT Catalogos.Id,Catalogos.Nombre,Busquedas.Fecha,Busquedas.Resultado,Catalogos.Link,Catalogos.observaciones,Catalogos.numero FROM";
	 $Instruccion.=" Catalogos";
	 $Instruccion.=" LEFT JOIN Busquedas ON (Busquedas.Id_Catalogo=Catalogos.Id AND Busquedas.Id_Pedido='$Id_Pedido')";
	 $Instruccion.=" ORDER BY Catalogos.numero asc,Catalogos.Nombre asc ";
     //echo $Instruccion;
     $result = mysql_query($Instruccion);
     echo mysql_error();
     while($row = mysql_fetch_row($result))
     {
	 	if ($row[3]=="")
		{
			$row[3]=0;
		}
		
		if ($row[2]=="")
		{
			$row[2]="0000-00-00";
		}
		
		
	 	$Biblioteca=$row[1];
		switch ($row[3])
		{
			case 0:
				$Leyenda = $Mensajes["ley-1"];
				break;
			case 1:
				$Leyenda = $Mensajes["ley-2"];
				break;
			case 2:
				$Leyenda = $Mensajes["ley-3"];
				break;
			case 3:
				$Leyenda = $Mensajes["ley-4"];
		}
 		
 
  ?> 



    <tr bgcolor="#D4D0C8">
      <td align="right" valign="middle" bgcolor="#ececec" class="style23"><div align="left"></div></td>
      <td align="right" valign="middle" bgcolor="#ececec" class="style23" width="50%"><div align="left"><span class="style46"><? echo $Biblioteca; ?></span><br>
    <a href="<? echo $row[4]; ?>" target="_blank"><? echo $row[4]; ?></a></div></td>
      <td align="right" valign="middle" bgcolor="#CCCCCC" class="style23" width="20%"><div align="center" class="style47"><? echo $row[2]; ?></div></td>
      <td align="right" valign="middle" bgcolor="#CCCCCC" class="style23" width="30%"><div align="center">
        <p><? echo $Leyenda; ?></p>
        </div></td>
      <td align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="center">
	  
	  <input type="button" value="O" name="obs" OnClick="observaciones(<? echo "'".$row[5]."',".$row[0].",'".$Biblioteca."'"; ?>)">
	  <input type="button" value="+" name="+" OnClick="reg_busqueda(<? echo "'".$Id_Pedido."',".$row[0].",'".$Biblioteca."'"; ?>)"></td>
    </tr>
	<? } ?>
    </table>
<form name="form1" method="post">
     	<input type="hidden" name="Id_Pedido">
		<input type="hidden" name="Id_Catalogo">
		<input type="hidden" name="Nombre_Catalogo">		
</form>
<form name="form2">
	<input type="button" class="style23" value="<? echo $Mensajes["bot-1"];?>" OnClick="javascript:self.close()">
</form>

<? 
   
   mysql_free_result($result);
   Desconectar();

?>

</div>
</body>
</html>
