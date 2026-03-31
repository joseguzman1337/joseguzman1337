<? 
  
 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";  
 include_once "../inc/"."parametros.inc.php";  
 Conexion();

 include_once "../inc/"."identif.php";
 Administracion();
 

 

 if (isset($update))
 {
 $Instruccion = "UPDATE Catalogos SET  observaciones='".$obs."' WHERE Id=".$id;
 //echo $Instruccion;
 $result = mysql_query($Instruccion); 
 }

 $inst="select * from Catalogos where Id=".$id;
 $result1 = mysql_query($inst); 
 $row=mysql_fetch_row($result1);
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
<body topmargin="0">
<div align="left">
<FORM METHOD=POST ACTION="modcatalogos.php">
<table width="70%"  border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#ececec">
 <tr><td>&nbsp;</td></tr>
 <tr align="center" bgcolor="#0099FF">
    <td height="20" colspan="5" class="style42">
    Catalogo
	</td>
 <td height="20" colspan="5" class="style42">
    <? echo $row[1];?>
	</td>
 </tr>
 <tr align="center" bgcolor="#0099FF">
    <td height="20" colspan="5" class="style42">
    Observaciones
	</td>
 <td height="20" colspan="5" class="style42">
    <TEXTAREA NAME="obs" ROWS="4" COLS="40"><? echo $row[3];?></TEXTAREA>
	</td>
 </tr>
<tr align="center" bgcolor="#0099FF">
    <td height="20" colspan="5" class="style42">
    <INPUT TYPE="submit" value="Enviar">
	<INPUT TYPE="hidden" name="update" value="update">
	<INPUT TYPE="hidden" name="id" value="<? echo $id;?>">
    <INPUT TYPE="hidden" name="cat" value="<? echo $cat;?>">
	</td>
 <td height="20" colspan="5" class="style42">
   <INPUT TYPE="button" value="Cerrar Ventana" onClick="javascript:window.close();">
	</td>
 </tr>
</table>  
</form>
</div>
</body>
</html>
