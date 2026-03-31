<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio(); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana;
	color: #000000;
	font-size: 9px;
}
body {
	background-color: #006599;
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
	color: #00CCFF;
}
a:active {
	text-decoration: none;
	color: #000000;
}
-->
</style></head>

<body>

<?

    
   include_once "../inc/"."conexion.inc.php";
   Conexion();
   include_once "../inc/"."fgenped.php";
   include_once "../inc/"."fgentrad.php";
    global $IdiomaSitio;  
   $Mensajes = Comienzo ("ayu-001",$IdiomaSitio);


   $expresion = "SELECT Heading,Texto_Ayuda FROM Campos ";
   $expresion =  $expresion."WHERE Tipo_Material=".$Tabla." AND Numero_Campo=".$campo." AND Codigo_Idioma=".$IdiomaSitio;

   $result = mysql_query($expresion);
   $row = mysql_fetch_row($result);
   if (mysql_num_rows($result)>0)
   {
?>

<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#E4E4E4">
  <tr align="left" valign="middle" bgcolor="#CCCCCC">
    <td height="20" colspan="2"><div align="center"> <img src="../images/square-lb.gif" width="8" height="8"><? echo $row[0]; ?><img src="../images/square-lb.gif" width="8" height="8"></div></td>
  </tr>
  <tr align="left" valign="middle">
    <td colspan="2"><table width="480"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr valign="middle">
        <td width="30" align="center"><img src="../images/help.gif" width="22" height="22"></td>
        <td width="450" align="left"><? echo $row[1]; ?></td>
      </tr>
    </table>    
      <hr></td>
  </tr>
  <tr>
    <td width="470">&nbsp;</td>
    <td width="30" align="center"><a href="javascript:window.print();"><img border=0 src="../images/printer.gif" width="32" height="33"></a></td>
  </tr>
</table>
<?
   }

   mysql_free_result($result);
   Desconectar();
?>
</body>
</html>
