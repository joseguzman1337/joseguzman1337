<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_Colaboradores = "SELECT * FROM tlistacol ORDER BY NombCol ASC";
$Colaboradores = mysql_query($query_Colaboradores, $conexion) or die(mysql_error());
$row_Colaboradores = mysql_fetch_assoc($Colaboradores);
$totalRows_Colaboradores = mysql_num_rows($Colaboradores);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo22 {color: #FFFFFF; font-weight: bold; }
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
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" width="137" height="61" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">LISTADO<br />
      COLABORADORES A T&Eacute;RMINO FIJO E INDEFINIDO </div></td>
  </tr>
</table>
<table width="838" border="0">
  <tr>
    <td width="832" bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<form id="form1" name="form1" method="post" action="">
  <table border="1" bgcolor="#FFFFCC">
    <tr>
      <td>IdColab</td>
      <td>NombCol</td>
      <td>CarCol</td>
      <td>FeInCol</td>
      <td>FeReCol</td>
      <td>CodCol</td>
      <td>ContCol</td>
      <td>DepCol</td>
      <td>TodCampos</td>
    </tr>
    <?php do { ?>
      <tr>
        <td nowrap="nowrap"><?php echo $row_Colaboradores['IdColab']; ?></td>
        <td nowrap="nowrap"><?php echo $row_Colaboradores['NombCol']; ?></td>
        <td nowrap="nowrap"><?php echo $row_Colaboradores['CarCol']; ?></td>
        <td nowrap="nowrap"><?php echo $row_Colaboradores['FeInCol']; ?></td>
        <td nowrap="nowrap"><?php echo $row_Colaboradores['FeReCol']; ?></td>
        <td nowrap="nowrap"><?php echo $row_Colaboradores['CodCol']; ?></td>
        <td nowrap="nowrap"><?php echo $row_Colaboradores['ContCol']; ?></td>
        <td nowrap="nowrap"><?php echo $row_Colaboradores['DepCol']; ?></td>
        <td nowrap="nowrap"><?php echo $row_Colaboradores['TodCampos']; ?></td>
      </tr>
      <?php } while ($row_Colaboradores = mysql_fetch_assoc($Colaboradores)); ?>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Colaboradores);
?>
