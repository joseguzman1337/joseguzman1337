<?php require_once('../Connections/conexion.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_ConsSolNom = 1;
$pageNum_ConsSolNom = 0;
if (isset($_GET['pageNum_ConsSolNom'])) {
  $pageNum_ConsSolNom = $_GET['pageNum_ConsSolNom'];
}
$startRow_ConsSolNom = $pageNum_ConsSolNom * $maxRows_ConsSolNom;

mysql_select_db($database_conexion, $conexion);
$query_ConsSolNom = "SELECT * FROM tsolinom";
$query_limit_ConsSolNom = sprintf("%s LIMIT %d, %d", $query_ConsSolNom, $startRow_ConsSolNom, $maxRows_ConsSolNom);
$ConsSolNom = mysql_query($query_limit_ConsSolNom, $conexion) or die(mysql_error());
$row_ConsSolNom = mysql_fetch_assoc($ConsSolNom);

if (isset($_GET['totalRows_ConsSolNom'])) {
  $totalRows_ConsSolNom = $_GET['totalRows_ConsSolNom'];
} else {
  $all_ConsSolNom = mysql_query($query_ConsSolNom);
  $totalRows_ConsSolNom = mysql_num_rows($all_ConsSolNom);
}
$totalPages_ConsSolNom = ceil($totalRows_ConsSolNom/$maxRows_ConsSolNom)-1;

$queryString_ConsSolNom = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ConsSolNom") == false && 
        stristr($param, "totalRows_ConsSolNom") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ConsSolNom = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ConsSolNom = sprintf("&totalRows_ConsSolNom=%d%s", $totalRows_ConsSolNom, $queryString_ConsSolNom);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo10 {font-size: 14px; }
.Estilo11 {	font-family: Tahoma;
	font-size: 14px;
	font-weight: bold;
}
.Estilo12 {color: #596221; font-weight: bold; font-family: Tahoma; font-size: 14px; }
.Estilo2 {font-family: Tahoma}
.Estilo4 {color: #596221;
	font-weight: bold;
}
.Estilo5 {color: #596221; font-weight: bold; font-family: Tahoma; }
.Estilo6 {font-size: 12px}
.Estilo1 {font-size: 16px;
	font-weight: bold;
	color: #FFFFFF;
	font-family: Tahoma;
}
.Estilo13 {color: #0000FF}
.Estilo16 {font-weight: bold; font-family: Tahoma;}
.Estilo19 {color: #596221; font-weight: bold; font-size: 9px; font-family: Tahoma; }
-->
</style>
</head>

<body>
<table width="850" border="1">
  <tr>
    <td width="152" bgcolor="#98BD0D"><div align="center"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="A" width="141" height="61" /></div></td>
    <td width="682" bgcolor="#98BD0D"><p align="center" class="Estilo1">SOLICITUD DE NOMBRAMIENTO DOCENTE </p></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#FFB112" class="Estilo4"><div align="center" class="Estilo2">DEPARTAMENTO DE TALENTO HUMANO - CONFORMANDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<br />
<table width="852" border="1">
  <tr>
    <td align="center" class="Estilo19">IR AL PRIMERO </td>
    <td align="center" class="Estilo19">ANTERIOR</td>
    <td align="center" class="Estilo19">SIGUIENTE</td>
    <td align="center" class="Estilo19">IR AL &Uacute;LTIMO </td>
  </tr>
  <tr>
    <td width="211"><div align="center">
      <?php if ($pageNum_ConsSolNom > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ConsSolNom=%d%s", $currentPage, 0, $queryString_ConsSolNom); ?>"><img src="First.gif" border=0 /></a>
          <?php } // Show if not first page ?>
    </div></td>
    <td width="217"><div align="center">
      <?php if ($pageNum_ConsSolNom > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ConsSolNom=%d%s", $currentPage, max(0, $pageNum_ConsSolNom - 1), $queryString_ConsSolNom); ?>"><img src="Previous.gif" border=0 /></a>
          <?php } // Show if not first page ?>
    </div></td>
    <td width="192"><div align="center">
      <?php if ($pageNum_ConsSolNom < $totalPages_ConsSolNom) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ConsSolNom=%d%s", $currentPage, min($totalPages_ConsSolNom, $pageNum_ConsSolNom + 1), $queryString_ConsSolNom); ?>"><img src="Next.gif" border=0 /></a>
          <?php } // Show if not last page ?>
    </div></td>
    <td width="204"><div align="center">
      <?php if ($pageNum_ConsSolNom < $totalPages_ConsSolNom) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ConsSolNom=%d%s", $currentPage, $totalPages_ConsSolNom, $queryString_ConsSolNom); ?>"><img src="Last.gif" border=0 /></a>
          <?php } // Show if not last page ?>
    </div></td>
  </tr>
</table>
<form method="post" name="form1">
  <table width="851" border="1" bordercolor="#000000" bgcolor="#FFFFCC">
    <tr>
      <td width="253" class="Estilo4"><div align="right" class="Estilo10">
        <div align="left"><span class="Estilo2"><strong>Fecha</strong></span></div>
      </div></td>
      <td width="582" bgcolor="#FFFFFF"><span class="Estilo13"><?php echo $row_ConsSolNom['FechaSol']; ?></span></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10">
        <div align="left"><span class="Estilo2"><strong>Unidad&nbsp;  Solicitante</strong></span></div>
      </div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo13"><?php echo $row_ConsSolNom['UnidSoli']; ?></span></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10">
        <div align="left"><span class="Estilo2"><strong>Apellidos   completos </strong></span></div>
      </div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo13"><?php echo $row_ConsSolNom['Apellido']; ?></span></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10">
        <div align="left"><span class="Estilo2"><strong>Nombres</strong> completos</span> </div>
      </div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo13"><?php echo $row_ConsSolNom['Nombres']; ?></span></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10">
        <div align="left"><span class="Estilo2"><strong>Documento  de identidad</strong></span></div>
      </div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo13"><?php echo $row_ConsSolNom['CCSolic']; ?></span></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10">
        <div align="left"><span class="Estilo2"><strong>Cargo</strong></span></div>
      </div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo13"><?php echo $row_ConsSolNom['Cargo']; ?></span></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10">
        <div align="left"><span class="Estilo2"><strong>Categor&iacute;a</strong></span></div>
      </div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo13"><?php echo $row_ConsSolNom['Categor']; ?></span></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10">
        <div align="left"><span class="Estilo2"><strong>Centro de  costo</strong></span></div>
      </div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo13"><?php echo $row_ConsSolNom['CentroCo']; ?></span></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10">
        <div align="left"><span class="Estilo2"><strong>Fecha  inicial</strong></span></div>
      </div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo13"><?php echo $row_ConsSolNom['FechaIni']; ?></span></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10">
        <div align="left"><span class="Estilo2"><strong>Fecha  final</strong></span></div>
      </div></td>
      <td bgcolor="#FFFFFF"><span class="Estilo13"><?php echo $row_ConsSolNom['FechaFin']; ?></span></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="852" border="1" bordercolor="#000000" bgcolor="#FFFFCC">
    <tr>
      <th colspan="3" scope="col"><div align="center"><strong class="Estilo5">Actividad Acad&eacute;mica a Realizar</strong></div></th>
    </tr>
    
    <tr>
      <th width="251" scope="col"><span class="Estilo6"></span></th>
      <th width="389" class="Estilo4" scope="col"><span class="Estilo2">Descripci&oacute;n</span></th>
      <th width="190" class="Estilo4" scope="col"><span class="Estilo2">Dedicaci&oacute;n</span></th>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo16">
        <div align="left">Asignaturas</div>
      </div></th>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['AsigDesc']; ?></span></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['AsigDedi']; ?></span></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo16">
        <div align="left">Talleres</div>
      </div></th>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['TallDesc']; ?></span></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['TallDedi']; ?></span></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo16">
        <div align="left">Pr&aacute;cticas</div>
      </div></th>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['PracDesc']; ?></span></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['PracDedi']; ?></span></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo16">
        <div align="left">Direcci&oacute;n  de trabajos de grado</div>
      </div></th>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['DiTGDesc']; ?></span></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['DiTGDedi']; ?></span></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo16">
        <div align="left">Laboratorios</div>
      </div></th>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['LaboDesc']; ?></span></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['LaboDedi']; ?></span></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo16">
        <div align="left">Investigaci&oacute;n</div>
      </div></th>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['InveDesc']; ?></span></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['InveDedi']; ?></span></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo16">
        <div align="left">Publicaci&oacute;n</div>
      </div></th>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['PublDesc']; ?></span></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['PublDedi']; ?></span></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo16">
        <div align="left">Asesor&iacute;a</div>
      </div></th>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['AsesDesc']; ?></span></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['AsesDedi']; ?></span></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo16">
        <div align="left">Educaci&oacute;n  continuada</div>
      </div></th>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['EdCoDesc']; ?></span></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['EdCoDedi']; ?></span></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo16">
        <div align="left">Reuniones</div>
      </div></th>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['ReunDesc']; ?></span></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['ReunDedi']; ?></span></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo16">
        <div align="left">Preparaci&oacute;n  de clases</div>
      </div></th>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['PrClDesc']; ?></span></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['PrClDedi']; ?></span></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo16">
        <div align="left">Proyecci&oacute;n  social</div>
      </div></th>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['PrSoDesc']; ?></span></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['PrSoDedi']; ?></span></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo16">
        <div align="left">Trabajo  de Campo (salidas)</div>
      </div></th>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['TrCaDesc']; ?></span></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['TrCaDedi']; ?></span></td>
    </tr>
    <tr>
      <th height="23" scope="row">&nbsp;</th>
      <td><p align="right" class="Estilo5">Dedidaci&oacute;n total </p></td>
      <td><span class="Estilo13"><?php echo $row_ConsSolNom['DedicTot']; ?></span></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="853" border="1" bordercolor="#000000">
    <tr>
      <th width="252" bgcolor="#FFFFCC" class="Estilo12" scope="col"><div align="right" class="Estilo11">
        <div align="left">Puntos  por Coordinaci&oacute;n </div>
      </div></th>
      <th width="585" bgcolor="#FFFFCC" scope="col"><div align="left" class="Estilo13"><?php echo $row_ConsSolNom['PuntCoor']; ?></div></th>
    </tr>
    <tr>
      <th bgcolor="#FFFFCC" class="Estilo12" scope="row"><div align="right" class="Estilo11">
        <div align="left">Direcci&oacute;n</div>
      </div></th>
      <td bgcolor="#FFFFCC"><span class="Estilo13"><?php echo $row_ConsSolNom['Direccio']; ?></span></td>
    </tr>
    <tr>
      <th bgcolor="#FFFFCC" class="Estilo12" scope="row"><div align="left">Observaciones</div></th>
      <td bgcolor="#FFFFCC"><span class="Estilo13"><?php echo $row_ConsSolNom['Observac']; ?></span></td>
    </tr>
    <tr>
      <th colspan="2" bgcolor="#FFFFCC" class="Estilo12" scope="row">&nbsp;</th>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="853" border="1" bordercolor="#000000">
    <tr>
      <th width="418" bgcolor="#FFFFCC" class="Estilo12" scope="row"><div align="left">
        <p>&nbsp;</p>
        <p>&nbsp;</p>
      </div></th>
      <td width="419" bgcolor="#FFFFCC">&nbsp;</td>
    </tr>
    <tr>
      <th valign="bottom" bgcolor="#FFFFCC" class="Estilo12" scope="row"><div align="left">
        <p>Rafael S&aacute;nchez Par&iacute;s<br />
          Vicerrector Administrativo </p>
        </div></th>
      <td valign="bottom" bgcolor="#FFFFCC"><span class="Estilo12">
        <div align="left">Solicitante</div>
      </span></td>
    </tr>
  </table>
  <p> </p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ConsSolNom);
?>
