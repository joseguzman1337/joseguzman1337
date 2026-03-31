<?

  include_once "../inc/conexion.inc";  
  include_once "../inc/var.inc.php";
  Conexion();
  include_once "../inc/fgenped.php";
  include_once "../inc/fgentrad.php";
  
  

  global $IdiomaSitio;
   $Mensajes = Comienzo ("est-001",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);

     
?>
<html>

<head>
<title>PrEBi</title>
</head>

<body background="../imagenes/banda.jpg">

<p align="center"><img border="0" src="../imagenes/estadistica.jpg">

<br>
<div align="center">
  <center>
<table border="0" width="65%" cellspacing="0" cellpadding="0" height="40">
  <tr>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="35%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="53%" bgcolor="#A9BCD3" valign="middle">&nbsp;</td>
    <td width="4%" bgcolor="#A9BCD3" valign="middle">&nbsp;</td>
  </tr>
  <TR>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="35%" bgcolor="#A9BCD3"><a href="estadcant.php"><font face="MS Sans Serif" size="1" color="#FFFF00"><b><? echo $Mensajes["h-1"]; ?></b></font></a></td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="53%" bgcolor="#A9BCD3" valign="middle"><font face="MS Sans Serif" size="1" color="#000080"><? echo $Mensajes["com-1"]; ?></font></td>
    <td width="4%" bgcolor="#A9BCD3" valign="middle">&nbsp;</td>
  </TR>
  <tr>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="35%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="53%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
  </tr>
  <TR>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="35%" bgcolor="#A9BCD3"><a href="estadret.php"><b><font face="MS Sans Serif" size="1" color="#FFFF00"><? echo $Mensajes["h-2"]; ?></font></b></a></td>
    <td width="4%" bgcolor="#A9BCD3"><font face="MS Sans Serif" size="1" color="#000080">&nbsp;</font></td>
    <td width="53%" bgcolor="#A9BCD3"><font face="MS Sans Serif" size="1" color="#000080"><? echo $Mensajes["com-2"]; ?></font></td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
  </TR>
  <tr>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="35%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="53%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
  </tr>
  <TR>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="35%" bgcolor="#A9BCD3"><font face="MS Sans Serif" size="1" color="#FFFF00">&nbsp;</font><a href="estadus.php"><b><font face="MS Sans Serif" size="1" color="#FFFF00"><? echo $Mensajes["h-3"]; ?></font></b></a></td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="53%" bgcolor="#A9BCD3"><font face="MS Sans Serif" size="1" color="#000080"><? echo $Mensajes["com-3"]; ?></font></td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
  </TR>
  <tr>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="35%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="53%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
  </tr>
  <TR>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="35%" bgcolor="#A9BCD3"><font face="MS Sans Serif" size="1"><font color="#FFFF00"><b>&nbsp;</b></font><a href="estadmat.php"><b><font color="#FFFF00"><? echo $Mensajes["h-4"]; ?></font></b></a></font></td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="53%" bgcolor="#A9BCD3"><font face="MS Sans Serif" size="1" color="#000080"><? echo $Mensajes["com-4"]; ?></font></td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
  </TR>
  <tr>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="35%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="53%" bgcolor="#A9BCD3">&nbsp;</td>
    <td width="4%" bgcolor="#A9BCD3">&nbsp;</td>
  </tr>
</table>

  </center>
</div>

<p ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#008080">cp:</FONT>est-001<br>
</FONT>
</p>
<hr align="center">
<p align="center"><font face="MS Sans Serif" size="1" color="#000080">Sitio
Dinámico desarrollado con tecnologías Open Source por Iniciativa de <b>ISTEC-PrEBi</b>
dependiente de la <b>Universidad Nacional de La Plata</b> en asociación con el
consorcio internacional <b>ISTEC</b>. (c) MMI<br>
<br>
</font><font face="MS Sans Serif" size="1" color="#800000">El presente sitio usa
teconología de scripting PHP 4(c) y administra la base de datos con el motor
MySQL(c).</font>

</body>

<? 
  Desconectar();?>

</html>
