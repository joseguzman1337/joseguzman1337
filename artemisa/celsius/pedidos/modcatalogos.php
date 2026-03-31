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
<link href="../celsius.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #0099CC;
}
-->
</style>
<link href="celsius.css" rel="stylesheet" type="text/css">
</head>

<body>
<FORM METHOD=POST ACTION="modcatalogos.php">
<table width="400" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#E4E4E4">
  <tr bgcolor="#0099CC" background="images/tabla-bg.jpg">
    <td height="20" colspan="2"><div align="center" class="style8">Cat&aacute;logo: <span class="style8"><? echo $row[1];?></span></div></td>
  </tr>
  <tr bgcolor="#F3F3F1">
    <td width="100" align="right" valign="top" bgcolor="#F3F3F1"><p align="right" class="style4">Observaciones:</p>    </td>
    <td width="300" align="left" bgcolor="#F3F3F1">    <TEXTAREA NAME="obs" ROWS="4" COLS="40"><? echo $row[3];?></TEXTAREA></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input name="Submit" type="submit" class="style2" value="Enviar">
   <INPUT TYPE="button" value="Cerrar Ventana" class="style2" onClick="javascript:window.close();">
	<INPUT TYPE="hidden" name="update" value="update">
	<INPUT TYPE="hidden" name="id" value="<? echo $id;?>">
    <INPUT TYPE="hidden" name="cat" value="<? echo $cat;?>">
</div></td>
  </tr>
</table>
</body>
</html>
