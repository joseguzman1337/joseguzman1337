<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_ConsSolNOmb = "SELECT * FROM tsolinom ORDER BY tsolinom.FechaSol, tsolinom.Apellido, tsolinom.Nombres";
$ConsSolNOmb = mysql_query($query_ConsSolNOmb, $conexion) or die(mysql_error());
$row_ConsSolNOmb = mysql_fetch_assoc($ConsSolNOmb);
$totalRows_ConsSolNOmb = mysql_num_rows($ConsSolNOmb);
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
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4 Estilo24"><span class="Estilo24">CONSULTA</span> <span class="Estilo24">DE SOLICITUDES DE NOMBRAMIENTO</span> </div></td>
  </tr>
</table>
<table width="841" border="0">
  <tr>
    <td bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONFORMANDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="1">
  <tr>
    <td>IdSolici</td>
    <td>UnidSoli</td>
    <td>FechaSol</td>
    <td>Apellido</td>
    <td>Nombres</td>
    <td>CCSolic</td>
    <td>Cargo</td>
    <td>Categor</td>
    <td>CentroCo</td>
    <td>FechaIni</td>
    <td>FechaFin</td>
    <td>AsigDesc</td>
    <td>AsigDedi</td>
    <td>TallDesc</td>
    <td>TallDedi</td>
    <td>PracDesc</td>
    <td>PracDedi</td>
    <td>DiTGDesc</td>
    <td>DiTGDedi</td>
    <td>LaboDesc</td>
    <td>LaboDedi</td>
    <td>InveDesc</td>
    <td>InveDedi</td>
    <td>PublDesc</td>
    <td>PublDedi</td>
    <td>AsesDesc</td>
    <td>AsesDedi</td>
    <td>EdCoDesc</td>
    <td>EdCoDedi</td>
    <td>ReunDesc</td>
    <td>ReunDedi</td>
    <td>PrClDesc</td>
    <td>PrClDedi</td>
    <td>PrSoDesc</td>
    <td>PrSoDedi</td>
    <td>TrCaDesc</td>
    <td>TrCaDedi</td>
    <td>DedicTot</td>
    <td>PuntCoor</td>
    <td>Direccio</td>
    <td>Observac</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_ConsSolNOmb['IdSolici']; ?></td>
      <td><?php echo $row_ConsSolNOmb['UnidSoli']; ?></td>
      <td><?php echo $row_ConsSolNOmb['FechaSol']; ?></td>
      <td><?php echo $row_ConsSolNOmb['Apellido']; ?></td>
      <td><?php echo $row_ConsSolNOmb['Nombres']; ?></td>
      <td><?php echo $row_ConsSolNOmb['CCSolic']; ?></td>
      <td><?php echo $row_ConsSolNOmb['Cargo']; ?></td>
      <td><?php echo $row_ConsSolNOmb['Categor']; ?></td>
      <td><?php echo $row_ConsSolNOmb['CentroCo']; ?></td>
      <td><?php echo $row_ConsSolNOmb['FechaIni']; ?></td>
      <td><?php echo $row_ConsSolNOmb['FechaFin']; ?></td>
      <td><?php echo $row_ConsSolNOmb['AsigDesc']; ?></td>
      <td><?php echo $row_ConsSolNOmb['AsigDedi']; ?></td>
      <td><?php echo $row_ConsSolNOmb['TallDesc']; ?></td>
      <td><?php echo $row_ConsSolNOmb['TallDedi']; ?></td>
      <td><?php echo $row_ConsSolNOmb['PracDesc']; ?></td>
      <td><?php echo $row_ConsSolNOmb['PracDedi']; ?></td>
      <td><?php echo $row_ConsSolNOmb['DiTGDesc']; ?></td>
      <td><?php echo $row_ConsSolNOmb['DiTGDedi']; ?></td>
      <td><?php echo $row_ConsSolNOmb['LaboDesc']; ?></td>
      <td><?php echo $row_ConsSolNOmb['LaboDedi']; ?></td>
      <td><?php echo $row_ConsSolNOmb['InveDesc']; ?></td>
      <td><?php echo $row_ConsSolNOmb['InveDedi']; ?></td>
      <td><?php echo $row_ConsSolNOmb['PublDesc']; ?></td>
      <td><?php echo $row_ConsSolNOmb['PublDedi']; ?></td>
      <td><?php echo $row_ConsSolNOmb['AsesDesc']; ?></td>
      <td><?php echo $row_ConsSolNOmb['AsesDedi']; ?></td>
      <td><?php echo $row_ConsSolNOmb['EdCoDesc']; ?></td>
      <td><?php echo $row_ConsSolNOmb['EdCoDedi']; ?></td>
      <td><?php echo $row_ConsSolNOmb['ReunDesc']; ?></td>
      <td><?php echo $row_ConsSolNOmb['ReunDedi']; ?></td>
      <td><?php echo $row_ConsSolNOmb['PrClDesc']; ?></td>
      <td><?php echo $row_ConsSolNOmb['PrClDedi']; ?></td>
      <td><?php echo $row_ConsSolNOmb['PrSoDesc']; ?></td>
      <td><?php echo $row_ConsSolNOmb['PrSoDedi']; ?></td>
      <td><?php echo $row_ConsSolNOmb['TrCaDesc']; ?></td>
      <td><?php echo $row_ConsSolNOmb['TrCaDedi']; ?></td>
      <td><?php echo $row_ConsSolNOmb['DedicTot']; ?></td>
      <td><?php echo $row_ConsSolNOmb['PuntCoor']; ?></td>
      <td><?php echo $row_ConsSolNOmb['Direccio']; ?></td>
      <td><?php echo $row_ConsSolNOmb['Observac']; ?></td>
    </tr>
    <?php } while ($row_ConsSolNOmb = mysql_fetch_assoc($ConsSolNOmb)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($ConsSolNOmb);
?>
