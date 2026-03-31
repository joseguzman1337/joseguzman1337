<?php require_once('Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_Directivos = "SELECT * FROM tjefdep ORDER BY JefDepen ASC";
$Directivos = mysql_query($query_Directivos, $conexion) or die(mysql_error());
$row_Directivos = mysql_fetch_assoc($Directivos);
$totalRows_Directivos = mysql_num_rows($Directivos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo22 {color: #FFFFFF; font-weight: bold; }
.Estilo24 {color: #FFFFFF}
.Estilo4 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="838" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="IMAGENES/LOGOBOSQUETH.jpg" width="146" height="65" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4 Estilo24">FORMULARIO DE AUTENTICACION DE USUARIO<br />
      PARA DILIGENCIAR EVALUACION DE DESEMPE&Ntilde;O<br />
      DE COLABORADORES CONTRATADOS A T&Eacute;RMINO FIJO E INDEFINIDO </div></td>
  </tr>
</table>
<table width="841" border="0">
  <tr>
    <td bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p>LISTADO DE JEFES</p>
<form id="form1" name="form1" method="post" action="">
  <table border="1">
    <tr>
      <td>CCJefDep</td>
      <td>JefDepen</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_Directivos['CCJefDep']; ?></td>
        <td><?php echo $row_Directivos['JefDepen']; ?></td>
      </tr>
      <?php } while ($row_Directivos = mysql_fetch_assoc($Directivos)); ?>
  </table>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Directivos);
?>
