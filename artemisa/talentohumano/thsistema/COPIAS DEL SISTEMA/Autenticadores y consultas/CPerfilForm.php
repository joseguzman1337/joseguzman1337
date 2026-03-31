<?php require_once('../Connections/conexion.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_ConsPerfil = 1;
$pageNum_ConsPerfil = 0;
if (isset($_GET['pageNum_ConsPerfil'])) {
  $pageNum_ConsPerfil = $_GET['pageNum_ConsPerfil'];
}
$startRow_ConsPerfil = $pageNum_ConsPerfil * $maxRows_ConsPerfil;

mysql_select_db($database_conexion, $conexion);
$query_ConsPerfil = "SELECT * FROM tperfil ORDER BY IdPerfil ASC";
$query_limit_ConsPerfil = sprintf("%s LIMIT %d, %d", $query_ConsPerfil, $startRow_ConsPerfil, $maxRows_ConsPerfil);
$ConsPerfil = mysql_query($query_limit_ConsPerfil, $conexion) or die(mysql_error());
$row_ConsPerfil = mysql_fetch_assoc($ConsPerfil);

if (isset($_GET['totalRows_ConsPerfil'])) {
  $totalRows_ConsPerfil = $_GET['totalRows_ConsPerfil'];
} else {
  $all_ConsPerfil = mysql_query($query_ConsPerfil);
  $totalRows_ConsPerfil = mysql_num_rows($all_ConsPerfil);
}
$totalPages_ConsPerfil = ceil($totalRows_ConsPerfil/$maxRows_ConsPerfil)-1;

$queryString_ConsPerfil = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ConsPerfil") == false && 
        stristr($param, "totalRows_ConsPerfil") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ConsPerfil = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ConsPerfil = sprintf("&totalRows_ConsPerfil=%d%s", $totalRows_ConsPerfil, $queryString_ConsPerfil);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo24 {font-size: 10px}
.Estilo3 {color: #596221}
.Estilo4 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
.Estilo5 {font-family: Tahoma; color: #596221; }
.Estilo15 {font-size: 16px}
.Estilo22 {color: #FFFFFF; font-weight: bold; }
.Estilo23 {font-family: Tahoma; font-weight: bold; font-size: 12px; color: #FFFFFF; }
.Estilo33 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo37 {color: #FF0000}
.Estilo39 {font-size: 14px}
.Estilo40 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 14px; }
.Estilo41 {
	font-size: 20px;
	font-weight: bold;
}
.Estilo42 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 12px; }
.Estilo43 {font-size: 10px}
.Estilo45 {color: #0000CC}
.Estilo46 {
	color: #0000FF;
	font-weight: bold;
}
.Estilo47 {color: #0000FF}
.Estilo49 {
	color: #006600;
	font-weight: bold;
}
.Estilo50 {font-family: Tahoma; color: #0000FF; font-weight: bold; }
-->
</style>
<script type="text/JavaScript">
<!--
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
//-->
</script>
</head>

<body>
<table width="841" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="277" bgcolor="#98BD0D"><div align="center" class="Estilo23"><span class="Estilo15">FORMATO DE PERFIL DE CARGO</span></div></td>
    <td width="187" bgcolor="#98BD0D"><div align="center" class="Estilo23">C&oacute;digo: <br />
      E-GTH &ndash;F-PC<br />
      Versi&oacute;n: 02<br />
      Fecha de Actualizaci&oacute;n: 27/04/2010</div></td>
    <td width="204" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/GAPP.jpg" alt="a" width="149" height="53" /></div></td>
  </tr>
</table>
<table width="841" border="0">
  <tr>
    <td bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="840" border="1">
  <tr>
    <td align="center" class="Estilo4">IR AL PRIMERO </td>
    <td align="center" class="Estilo4">ANTERIOR</td>
    <td align="center" class="Estilo4">SIGUIENTE</td>
    <td align="center" class="Estilo4">IR AL &Uacute;LTIMO </td>
  </tr>
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_ConsPerfil > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ConsPerfil=%d%s", $currentPage, 0, $queryString_ConsPerfil); ?>"><img src="First.gif" alt="a" border="0" /></a>
        <?php } // Show if not first page ?>    </td>
    <td width="31%" align="center"><?php if ($pageNum_ConsPerfil > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ConsPerfil=%d%s", $currentPage, max(0, $pageNum_ConsPerfil - 1), $queryString_ConsPerfil); ?>"><img src="Previous.gif" alt="d" border="0" /></a>
        <?php } // Show if not first page ?>    </td>
    <td width="23%" align="center"><?php if ($pageNum_ConsPerfil < $totalPages_ConsPerfil) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ConsPerfil=%d%s", $currentPage, min($totalPages_ConsPerfil, $pageNum_ConsPerfil + 1), $queryString_ConsPerfil); ?>"><img src="Next.gif" alt="c" border="0" /></a>
        <?php } // Show if not last page ?>    </td>
    <td width="23%" align="center"><?php if ($pageNum_ConsPerfil < $totalPages_ConsPerfil) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ConsPerfil=%d%s", $currentPage, $totalPages_ConsPerfil, $queryString_ConsPerfil); ?>"><img src="Last.gif" alt="b" border="0" /></a>
        <?php } // Show if not last page ?>    </td>
  </tr>
</table>
<p class="Estilo4">&nbsp;
Registros <?php echo ($startRow_ConsPerfil + 1) ?> de <?php echo $totalRows_ConsPerfil ?> </p>
<form method="post" name="form1">
  <p>&nbsp;<span class="Estilo47"><span class="Estilo49">CODIGO DEL PERFIL:</span> <?php echo $row_ConsPerfil['IdPerfil']; ?></span></p>
  <table width="841" border="0">
    <tr>
      <td colspan="2" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo4">Unidad Acad&eacute;mica o Administrativa:</span><br /> 
        <span class="Estilo3"><span class="Estilo45"><?php echo $row_ConsPerfil['UnAcad']; ?></span><br />
      </span></td>
      <td width="192" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo5"><strong>Fecha: <span class="Estilo24">(A&ntilde;o-Mes-Dia</span><span class="Estilo43">)<br />
      </span><span class="Estilo46"><?php echo $row_ConsPerfil['FechaDil']; ?></span><br />
        </strong></span></td>
      <td width="203" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo5"><strong>Persona que procesa</strong>:
        <label> <br />
        <span class="Estilo47"><?php echo $row_ConsPerfil['QuiProc']; ?></span><br />
        </label>
      </span></td>
    </tr>
    <tr>
      <td width="213" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo5"><strong>Nombre del Cargo:<br />
            <span class="Estilo47"><?php echo $row_ConsPerfil['NomCargo']; ?></span><br />
      </strong></span></td>
      <td width="215" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo5"><strong>&Aacute;rea:<br />
            <span class="Estilo47"><?php echo $row_ConsPerfil['Area']; ?></span><br />
        <br />
      </strong></span></td>
      <td colspan="2" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo5"><strong>Asignatura:
            <br />              
            <span class="Estilo47"><?php echo $row_ConsPerfil['Asignatura']; ?></span> </strong></span></td>
    </tr>
    <tr>
      <td height="54" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo5"><strong><br />
        N&uacute;mero de Alumnos:<br />
        <span class="Estilo47"><?php echo $row_ConsPerfil['NoAlum']; ?></span> </strong></span></td>
      <td valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo5"><strong><br />
        Creditos asignatura:<br />
        <span class="Estilo47"><?php echo $row_ConsPerfil['Creditos']; ?>      </span></strong></span></td>
      <td valign="top" bgcolor="#FFFFCC" class="Estilo4"><p class="Estilo5"><strong>Nivel del cargo:<br />
        <span class="Estilo47"><?php echo $row_ConsPerfil['NivCargo']; ?></span><br />
        </strong><strong>
          <label></label>
        </strong></p>        </td>
      <td valign="top" bgcolor="#FFFFCC" class="Estilo4"><p><span class="Estilo5"><strong>Escalafon:<br />
        <span class="Estilo47"><?php echo $row_ConsPerfil['Escalafon']; ?></span><br />
        </strong></span></p>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td><p align="center" class="Estilo4">De acuerdo  al organigrama de la unidad a la cual corresponde el cargo, por favor  especifique los cargos colaterales y los cargos que le reportan</p></td>
    </tr>
  </table>
  <table width="840" border="0">
    <tr>
      <td colspan="2" bgcolor="#FFFFCC"><p align="center" class="Estilo5"><strong>CARGO DEL JEFE INMEDIATO</strong>: <span class="Estilo46"><?php echo $row_ConsPerfil['CargJeIn']; ?></span> </p></td>
    </tr>
    <tr>
      <td width="414" bgcolor="#FFFFCC"><div align="center" class="Estilo5"><strong>CARGOS COLATERALES</strong></div></td>
      <td width="416" bgcolor="#FFFFCC"><div align="center" class="Estilo5"><strong>CARGOS QUE LE REPORTAN</strong></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5 Estilo47 Estilo47"><?php echo $row_ConsPerfil['CargCol1']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5 Estilo47"><?php echo $row_ConsPerfil['CargRep1']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5 Estilo47"><?php echo $row_ConsPerfil['CargCol2']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5 Estilo47"><?php echo $row_ConsPerfil['CargRep2']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5 Estilo47"><?php echo $row_ConsPerfil['CargCol3']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5 Estilo47"><?php echo $row_ConsPerfil['CargRep3']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5 Estilo47"><?php echo $row_ConsPerfil['CargCol4']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5 Estilo47"><?php echo $row_ConsPerfil['CargRep4']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5 Estilo47"><?php echo $row_ConsPerfil['CargCol5']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5 Estilo47"><?php echo $row_ConsPerfil['CargRep5']; ?></div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="832" border="0">
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><p align="center">Describa a  continuaci&oacute;n las relaciones INTERNAS que tiene el cargo y la  actividad que se desarrolla.</p></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="209" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>CON QU&Eacute; CARGO</strong></div></td>
      <td width="210" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&iquest;PARA QU&Eacute;?</strong></div></td>
      <td width="185" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICE DE GESTI&Oacute;N CUANTITATIVO</strong><br />
              <span class="Estilo24">numerador<br />
                -------------------<br />
                denominador</span><br />
      </div></td>
      <td width="210" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICES DE GESTI&Oacute;N CUALITATIVO</strong></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['CarReIn1']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ObReIn1']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiNu1']; ?></div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiCu11']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu12']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu13']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu14']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiDe1']; ?></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['CarReIn2']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ObReIn2']; ?></div></td>
      <td height="44" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiNu2']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiCu21']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu22']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu23']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu24']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiDe2']; ?></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['CarReIn3']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ObReIn3']; ?></div></td>
      <td height="44" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiNu3']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiCu31']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu32']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu33']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu34']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiDe3']; ?></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['CarReIn4']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ObReIn4']; ?></div></td>
      <td height="48" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiNu4']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiCu41']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu42']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu43']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu44']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiDe4']; ?></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['CarReIn5']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ObReIn5']; ?></div></td>
      <td height="45" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiNu5']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiCu51']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu52']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu53']; ?><br />
        <?php echo $row_ConsPerfil['IgRiCu54']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgRiDe5']; ?></div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="832" border="0">
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><p align="center">Describa a  continuaci&oacute;n las relaciones EXTERNAS que tiene el cargo y la  actividad que se desarrolla.</p></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="209" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>CON QU&Eacute; CARGO</strong></div></td>
      <td width="210" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&iquest;PARA QU&Eacute;?</strong></div></td>
      <td width="185" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICE DE GESTI&Oacute;N CUANTITATIVO</strong><br />
              <span class="Estilo43">numerador<br />
                -------------------<br />
                denominador</span><br />
      </div></td>
      <td width="210" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICES DE GESTI&Oacute;N CUALITATIVO</strong></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['CarReEx1']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ObReEx1']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReNu1']; ?></div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReCu11']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu12']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu13']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu14']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReDe1']; ?></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['CarReEx2']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ObReEx2']; ?></div></td>
      <td height="44" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReNu2']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReCu21']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu22']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu23']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu24']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReDe2']; ?></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['CarReEx3']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ObReEx3']; ?></div></td>
      <td height="44" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReNu3']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReCu31']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu32']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu33']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu34']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReDe3']; ?></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['CarReEx4']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ObReEx4']; ?></div></td>
      <td height="48" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReNu4']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReCu41']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu42']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu43']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu44']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReDe4']; ?></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['CarReEx5']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ObReEx5']; ?></div></td>
      <td height="45" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReNu5']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReCu51']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu52']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu53']; ?><br />
              <?php echo $row_ConsPerfil['IgReCu54']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['IgReDe5']; ?></div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td colspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <p class="Estilo4">Seleccione los niveles acad&eacute;micos  y escriba los t&iacute;tulos requeridos para el desempe&ntilde;o del cargo </p>
      </div>
          <div align="center"></div></td>
    </tr>
    <tr>
      <td width="176" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>NIVEL</strong></div></td>
      <td width="654" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&iquest;EN QU&Eacute;?</strong></div></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo47">
        <label> <?php echo $row_ConsPerfil['Prof1']; ?></label>
      </span></td>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47">
          <label></label>
          <?php echo $row_ConsPerfil['ProfNiv1']; ?></div></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['Prof2']; ?></div></td>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ProfNiv2']; ?></div></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['Prof3']; ?></div></td>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ProfNiv3']; ?></div></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['Prof4']; ?></div></td>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ProfNiv4']; ?></div></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['Prof5']; ?></div></td>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['ProfNiv5']; ?></div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>CONOCIMIENTOS REQUERIDOS PARA DESEMPE&Ntilde;AR EL CARGO</strong>
        <p>Especifique  el tipo de conocimientos y el nivel requerido para desempe&ntilde;ar el cargo. Tics, Idiomas,  pedagog&iacute;a / andragog&iacute;a, servicio al cliente conocimientos espec&iacute;ficos del &aacute;rea,  otros.</p>
        <p>&nbsp;</p>
      </div></td>
    </tr>
    <tr>
      <td width="655" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Conocimientos en:</div></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Nivel</div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4 Estilo47"><?php echo $row_ConsPerfil['Conoc1']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCon1']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4 Estilo47"><?php echo $row_ConsPerfil['Conoc2']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCon2']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4 Estilo47"><?php echo $row_ConsPerfil['Conoc3']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCon3']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4 Estilo47"><?php echo $row_ConsPerfil['Conoc4']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCon4']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4 Estilo47"><?php echo $row_ConsPerfil['Conoc5']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCon5']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4 Estilo47"><?php echo $row_ConsPerfil['Conoc6']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCon6']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4 Estilo47"><?php echo $row_ConsPerfil['Conoc7']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCon7']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4 Estilo47"><?php echo $row_ConsPerfil['Conoc8']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCon8']; ?></div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
        <p><strong>CAPACITACI&Oacute;N QUE LA UNIVERSIDAD O FACULTAD <br />
          DEBEN BRINDAR PARA DESEMPE&Ntilde;AR  EL CARGO</strong></p>
        <p>Especifique  la capacitaci&oacute;n requerida y el nivel requerido para desempe&ntilde;ar el cargo. <br />
Tics,  Idiomas, pedagog&iacute;a / andragog&iacute;a, servicio al cliente conocimientos espec&iacute;ficos  del &aacute;rea, otros.</p>
        <p>&nbsp;</p>
      </div></td>
    </tr>
    <tr>
      <td width="655" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>Capacitaci&oacute;n en</strong>:</div></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Nivel</div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['Capac1']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCap1']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['Capac2']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCap2']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['Capac3']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCap3']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['Capac4']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCap4']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['Capac5']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCap5']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['Capac6']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCap6']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['Capac7']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCap7']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['Capac8']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['NivCap8']; ?></div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
        <p><strong>EXPERIENCIA LABORAL PARA DESEMPE&Ntilde;AR EL CARGO</strong></p>
        <p>Especifique el  tipo de experiencia requerida para este cargo e indique el tiempo m&iacute;nimo en  meses o a&ntilde;os.</p>
        <p>&nbsp;</p>
      </div></td>
    </tr>
    <tr>
      <td width="655" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>Experiencia en</strong>:</div></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Nivel</div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['ExpLab1']; ?></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['TiExLa1']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['ExpLab2']; ?>&nbsp;</td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['TiExLa2']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['ExpLab3']; ?>&nbsp;</td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['TiExLa3']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['ExpLab4']; ?>&nbsp;</td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['TiExLa4']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['ExpLab5']; ?>&nbsp;</td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['TiExLa5']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['ExpLab6']; ?>&nbsp;</td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['TiExLa6']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['ExpLab7']; ?>&nbsp;</td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['TiExLa7']; ?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo50"><?php echo $row_ConsPerfil['ExpLab8']; ?>&nbsp;</td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo47"><?php echo $row_ConsPerfil['TiExLa8']; ?></div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <p align="center"><strong>OBJETIVO DEL CARGO</strong><br />
            Describa la raz&oacute;n de ser del cargo. (Qu&eacute;  hace, quien lo hace y para qui&eacute;n se hace).</p>
      </div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="justify" class="Estilo47"><?php echo $row_ConsPerfil['ObCargo']; ?></div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="845" border="0">
    <tr>
      <td colspan="5" bgcolor="#FFFFCC" class="Estilo4"><p align="center">Relacione a  continuaci&oacute;n las responsabilidades tanto <strong><u><br />
        ACAD&Eacute;MICAS</u></strong> como <strong><u>ADMINISTRATIVAS</u></strong> del  cargo.</p></td>
    </tr>
    <tr>
      <td colspan="5" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="185" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo33">RESPONSABILIDADES ACAD&Eacute;MICAS</div></td>
      <td width="194" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>PERIODICIDAD</strong></div></td>
      <td width="162" bgcolor="#FFFFCC" class="Estilo4"><div align="center">TIPO</div></td>
      <td width="167" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICE DE GESTI&Oacute;N CUANTITATIVO</strong><br />
              <span class="Estilo24">numerador<br />
                -------------------<br />
                denominador</span><br />
      </div></td>
      <td width="115" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICES DE GESTI&Oacute;N CUALITATIVO</strong></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAcad1']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4">
        <div align="center"><?php echo $row_ConsPerfil['PeReAc1']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAc1']; ?></div></td>
      <td height="50" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRANu1']; ?></div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgRAcCu11']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu12']; ?><br />
		<?php echo $row_ConsPerfil['IgRAcCu13']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu14']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td height="46" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRADe1']; ?></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAcad2']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4">
        <div align="center"><?php echo $row_ConsPerfil['PeReAc2']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAc2']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRANu2']; ?></div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgRAcCu21']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu22']; ?><br />
		<?php echo $row_ConsPerfil['IgRAcCu23']; ?><br />
		<?php echo $row_ConsPerfil['IgRAcCu24']; ?><br />
		<br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRADe2']; ?></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAcad3']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4">
        <div align="center"><?php echo $row_ConsPerfil['PeReAc3']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAc3']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRANu3']; ?></div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgRAcCu31']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu32']; ?><br />
		<?php echo $row_ConsPerfil['IgRAcCu33']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu34']; ?><br />
        <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRADe3']; ?></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAcad4']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4">
      <div align="center"><?php echo $row_ConsPerfil['PeReAc4']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAc4']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRANu4']; ?></div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgRAcCu41']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu42']; ?><br />
		<?php echo $row_ConsPerfil['IgRAcCu43']; ?><br />
		<?php echo $row_ConsPerfil['IgRAcCu44']; ?><br />
		<br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRADe4']; ?></div></td>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAcad5']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4">
      <div align="center"><?php echo $row_ConsPerfil['PeReAc5']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAc5']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRANu5']; ?></div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgRAcCu51']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu52']; ?><br />
		<?php echo $row_ConsPerfil['IgRAcCu53']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu54']; ?><br />
        <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRADe5']; ?></div></td>
      </div></td>
    </tr>
  </table>
  <table width="845" border="0">

    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAcad6']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4">
        <div align="center"><?php echo $row_ConsPerfil['PeReAc6']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAc6']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRANu6']; ?></div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgRAcCu61']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu62']; ?><br />
		<?php echo $row_ConsPerfil['IgRAcCu63']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu64']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRADe6']; ?></div></td>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAcad7']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4">
        <div align="center"><?php echo $row_ConsPerfil['PeReAc7']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAc7']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRANu7']; ?></div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgRAcCu71']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu72']; ?><br />
		<?php echo $row_ConsPerfil['IgRAcCu73']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu74']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRADe6']; ?></div></td>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAcad8']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4">
        <div align="center"><?php echo $row_ConsPerfil['PeReAc8']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAc8']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRANu8']; ?></div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgRAcCu81']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu82']; ?><br />
		<?php echo $row_ConsPerfil['IgRAcCu83']; ?><br />
        <?php echo $row_ConsPerfil['IgRAcCu84']; ?><br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IGeRADe8']; ?></div></td>
      </div></td>
    </tr>
  </table>
  <table width="845" border="0">
    
    <tr>
      <td colspan="5" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="185" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo33">RESPONSABILIDADES ADMINISTRATIVAS </div></td>
      <td width="194" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>PERIODICIDAD</strong></div></td>
      <td width="162" bgcolor="#FFFFCC" class="Estilo4"><div align="center">TIPO</div></td>
      <td width="167" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICE DE GESTI&Oacute;N CUANTITATIVO</strong><br />
              <span class="Estilo24">numerador<br />
                -------------------<br />
                denominador</span><br />
      </div></td>
      <td width="115" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICES DE GESTI&Oacute;N CUALITATIVO</strong></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAdm1']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['PeReAd1']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAd1']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div>
        <?php echo $row_ConsPerfil['IgeRAdNu1']; ?></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"> <?php echo $row_ConsPerfil['IgRAdCu11']; ?><br />
          <?php echo $row_ConsPerfil['IgRAdCu12']; ?><?php echo $row_ConsPerfil['IgRAdCu13']; ?><?php echo $row_ConsPerfil['IgRAdCu14']; ?><br />
        <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgeRAdDe1']; ?></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAdm2']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['PeReAd2']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAd2']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div>
        <?php echo $row_ConsPerfil['IgeRAdNu2']; ?></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"> <?php echo $row_ConsPerfil['IgRAdCu21']; ?><br />
          <?php echo $row_ConsPerfil['IgRAdCu22']; ?><?php echo $row_ConsPerfil['IgRAdCu23']; ?><?php echo $row_ConsPerfil['IgRAdCu24']; ?><br />
        <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgeRAdDe2']; ?></div></td>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAdm3']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['PeReAd3']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAd3']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div>
        <?php echo $row_ConsPerfil['IgeRAdNu3']; ?></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"> <?php echo $row_ConsPerfil['IgRAdCu31']; ?><br />
          <?php echo $row_ConsPerfil['IgRAdCu32']; ?><?php echo $row_ConsPerfil['IgRAdCu33']; ?><?php echo $row_ConsPerfil['IgRAdCu34']; ?><br />
        <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgeRAdDe3']; ?></div></td>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAdm4']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['PeReAd4']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAd4']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div>
        <?php echo $row_ConsPerfil['IgeRAdNu4']; ?></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"> <?php echo $row_ConsPerfil['IgRAdCu41']; ?><br />
          <?php echo $row_ConsPerfil['IgRAdCu42']; ?><?php echo $row_ConsPerfil['IgRAdCu43']; ?><?php echo $row_ConsPerfil['IgRAdCu44']; ?><br />
        <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgeRAdDe4']; ?></div></td>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAdm5']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['PeReAd5']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAd5']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div>
        <?php echo $row_ConsPerfil['IgeRAdNu5']; ?></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"> <?php echo $row_ConsPerfil['IgRAdCu51']; ?><br />
          <?php echo $row_ConsPerfil['IgRAdCu52']; ?><?php echo $row_ConsPerfil['IgRAdCu53']; ?><?php echo $row_ConsPerfil['IgRAdCu54']; ?><br />
        <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgeRAdDe5']; ?></div></td>
      </div></td>
    </tr>
  </table>
  <table width="845" border="0">
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAdm6']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['PeReAd6']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAd6']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div>
        <?php echo $row_ConsPerfil['IgeRAdNu6']; ?></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"> <?php echo $row_ConsPerfil['IgRAdCu61']; ?><br />
          <?php echo $row_ConsPerfil['IgRAdCu62']; ?><?php echo $row_ConsPerfil['IgRAdCu63']; ?><?php echo $row_ConsPerfil['IgRAdCu64']; ?><br />
        <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgeRAdDe6']; ?></div></td>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAdm7']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['PeReAd7']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAd7']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div>
        <?php echo $row_ConsPerfil['IgeRAdNu7']; ?></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"> <?php echo $row_ConsPerfil['IgRAdCu71']; ?><br />
          <?php echo $row_ConsPerfil['IgRAdCu72']; ?><?php echo $row_ConsPerfil['IgRAdCu73']; ?><?php echo $row_ConsPerfil['IgRAdCu74']; ?><br />
        <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgeRAdDe7']; ?></div></td>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['ResAdm8']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['PeReAd8']; ?></div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['TiReAd8']; ?></div></td>
      <td height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div>
        <?php echo $row_ConsPerfil['IgeRAdNu8']; ?></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center"> <?php echo $row_ConsPerfil['IgRAdCu81']; ?><br />
          <?php echo $row_ConsPerfil['IgRAdCu82']; ?><?php echo $row_ConsPerfil['IgRAdCu83']; ?><?php echo $row_ConsPerfil['IgRAdCu84']; ?><br />
        <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><?php echo $row_ConsPerfil['IgeRAdDe8']; ?></div></td>
      </div></td>
    </tr>
  </table>
  <p></p>
  <p></p>
  <table width="844" border="0">
    <tr>
      <td width="838" bgcolor="#FFFFCC" class="Estilo4"><p align="center" class="Estilo41">A continuaci&oacute;n debe determinar los niveles </p>
        <p align="center" class="Estilo41">de las competencias que requiere el cargo</p>
      <p align="center">&nbsp;</p></td>
    </tr>
  </table>
  <table border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td width="307" valign="top" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p><strong>COMPETENCIAS    COGNOSCITIVAS:</strong></p></td>
      <td width="315" valign="top" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p align="justify">Se    refieren a los conocimientos requeridos para el adecuado desempe&ntilde;o del cargo</p></td>
      <td width="213" rowspan="3" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p align="center">Usted debe definir los niveles    esperados seg&uacute;n su criterio teniendo en cuenta el cargo que est&aacute; analizando<strong></strong></p></td>
    </tr>
    <tr>
      <td width="307" valign="top" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p><strong>COMPETENCIAS    INSTRUMENTALES</strong></p></td>
      <td width="315" valign="top" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p align="justify">Se    refieren a las habilidades (aplicaci&oacute;n del conocimiento) requeridas para el    adecuado desempe&ntilde;o del cargo</p></td>
    </tr>
    <tr>
      <td width="307" valign="top" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p><strong>COMPETENCIAS    ACTITUDINALES</strong></p></td>
      <td width="315" valign="top" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p align="justify">Se    refieren a las actitudes y comportamientos&nbsp;    que debe poseer el funcionario para enfrentar con &eacute;xito el entorno    social donde se desempe&ntilde;ar&aacute;</p></td>
    </tr>
  </table>
  <p></p>
  <p></p>
  <p></p>
  <p></p>
  <table width="853" border="1" bordercolor="#FFFFFF" bgcolor="#FFFFCC">
    <tr>
      <td colspan="6" bordercolor="#FFFFFF" class="Estilo4"><div align="center">
        <p><strong>COMPETENCIAS  <span class="Estilo37">COGNOSCITIVAS</span> PARA DESEMPE&Ntilde;AR EL CARGO</strong><br />          
          <strong>Conocimientos que debe  poseer el funcionario para desempe&ntilde;ar adecuadamente el cargo</strong></p>
        <p>&nbsp;</p>
      </div></td>
    </tr>
    
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4"><div align="center">COMPETENCIA</div></td>
      <td width="255" colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><strong>Determine el nivel  requerido</strong></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    en Gerencia estrat&eacute;gica</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCCoGeEs']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    en Gerencia educativa</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCCoGeEd']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    en gesti&oacute;n universitaria</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCCoGeUn']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    en investigaci&oacute;n en su &aacute;rea particular</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCCoInAp']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    generales en investigaci&oacute;n </td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCCoBaIn']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    en metodolog&iacute;as y t&eacute;cnicas de ense&ntilde;anza-aprendizaje</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCCoMeEa']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    &nbsp;en consultor&iacute;a empresarial</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCCoCoEm']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimiento    del entorno pol&iacute;tico, econ&oacute;mico, social y cultural</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCCoEnPo']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    de TICS y desarrollos tecnol&oacute;gicos</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCCoTics']; ?></td>
    </tr>
    
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Dominio    del idioma ingl&eacute;s</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCCoIngl']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Titulaci&oacute;n    de doctorado o su equivalente en experiencia</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCTiDoct']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Titulaci&oacute;n&nbsp; de maestr&iacute;a o su equivalente en experiencia</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCTiMaes']; ?>
</td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Titulaci&oacute;n&nbsp; de especializaci&oacute;n o su equivalente en    experiencia</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCTiEspe']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Titulaci&oacute;n    profesional (pregrado) en carreras afines a la actividad</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCTiPrCa']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Formaci&oacute;n    en docencia universitaria</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCFoDoUn']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    de procesos de apoyo al &eacute;xito estudiantil </td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CCPrApEs']; ?></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="853" border="1" bordercolor="#FFFFFF" bgcolor="#FFFFCC">
    <tr>
      <td colspan="6" bordercolor="#FFFFFF" class="Estilo4"><div align="center">
        <p><strong>COMPETENCIAS  <span class="Estilo37">INSTRUMENTALES</span> PARA DESEMPE&Ntilde;AR EL CARGO</strong><br />
          <strong>Conocimientos que debe  poseer el funcionario para desempe&ntilde;ar adecuadamente el cargo</strong></p>
        <p>&nbsp;</p>
      </div></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4"><div align="center">COMPETENCIA</div></td>
      <td width="255" colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><strong>Determine el nivel  requerido</strong></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Planeaci&oacute;n,    control y seguimiento&nbsp; pol&iacute;tico,    estrat&eacute;gico y administrativo del proyecto&nbsp;    educativo</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIPlCoPe']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Planeaci&oacute;n y gesti&oacute;n de Investigaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIPlGeIn']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Habilidades pedag&oacute;gicas y did&aacute;cticas</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIHaPeDi']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Gesti&oacute;n de procesos de calidad educativa</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIGePrEd']; ?>
</td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Aplicaci&oacute;n de evaluaciones operativas a los procesos de    aprendizaje, evaluaci&oacute;n del aprendizaje y procesos formaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIAPEvOp']; ?>
</td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Direcci&oacute;n de l&iacute;neas y grupos de investigaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIDiLiIn']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Desarrollo de investigaci&oacute;n en los diversos niveles de formaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIDeInves']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Apoyo a procesos de docencia, investigaci&oacute;n y servicios en    funciones delegadas</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIApPrDo']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Direcci&oacute;n de &aacute;reas</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIDiArea']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Dise&ntilde;o de servicios y consultor&iacute;as especializados</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIDiSeCo']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Programaci&oacute;n y control de servicios y consultor&iacute;as    especializados</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIPrCoSe']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Administraci&oacute;n de los centros de servicios especializados</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIAdCeSe']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Prestaci&oacute;n de los servicios y consultor&iacute;as especializados</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIPrSeCo']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Gesti&oacute;n de Proyectos&nbsp; y    convenios</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIGePrCo']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Capacidad de acceder a las TICs</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CICaAcTi']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Fundamentaci&oacute;n y planeaci&oacute;n de materiales did&aacute;cticos y nuevas    tecnolog&iacute;as para la educaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIFuPlMd']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Fundamentaci&oacute;n, planeaci&oacute;n y dise&ntilde;o de materiales did&aacute;cticos y    nuevas tecnolog&iacute;as para la educaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIFuPlDi']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Dise&ntilde;o de materiales did&aacute;cticos</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIDiMaDi']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Dise&ntilde;o de materiales did&aacute;cticos y nuevas tecnolog&iacute;as para la    educaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIDiMaNt']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Desarrollo&nbsp; y aplicaci&oacute;n    de materiales did&aacute;cticos y nuevas tecnolog&iacute;as para la educaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIDiApMd']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Fundamentar&nbsp; los programas    y proyectos que promuevan el &eacute;xito estudiantil</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIFuPrEe']; ?></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Dise&ntilde;o de estrategias que promuevan el &eacute;xito estudiantil</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIDiEsEe']; ?></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Administraci&oacute;n del proceso de &eacute;xito estudiantil</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CIAdPrEe']; ?></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="851" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#FFFFCC">
    <tr>
      <td colspan="4" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p align="center"><strong>COMPETENCIAS  <span class="Estilo37">ACTITUDINALES</span> PARA DESEMPE&Ntilde;AR EL CARGO </strong><br />
      Caracter&iacute;sticas  que debe poseer el funcionario para enfrentar con &eacute;xito el cargo y el entorno social donde  se desempe&ntilde;ar&aacute;</p>
      <p align="center"><strong>&nbsp;ESCOJA LA FRECUENCIA ESPERADA PARA CADA COMPORTAMIENTO </strong><br />
        <strong>SEG&Uacute;N SU CRITERIO TENIENDO EN CUENTA EL CARGO QUE EST&Aacute;  ANALIZANDO</strong></p></td>
    </tr>
    <tr>
      <td colspan="3" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4">&nbsp;</td>
      <td align="center" valign="middle" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4">&nbsp;</td>
    </tr>
    <tr>
      <td width="186" bordercolor="#006600" class="Estilo4"><div align="center">COMPETENCIA</div></td>
      <td width="155" bordercolor="#006600" class="Estilo4"><div align="center">DEFINICI&Oacute;N    OPERACIONAL</div></td>
      <td width="242" bordercolor="#006600" class="Estilo4">CONDUCTAS    IDENTIFICATORIAS</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4">ESCOJA EL NIVEL</td>
    </tr>
    <tr>
      <td width="186" rowspan="10" bordercolor="#006600" class="Estilo4 Estilo39"><div align="center">TRABAJO EN EQUIPO</div></td>
      <td width="155" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    de cooperar arm&oacute;nicamente con los dem&aacute;s para lograr los objetivos del equipo.</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    flexibilidad cuando la situaci&oacute;n as&iacute; lo requiere.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATEMfSi']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Comparte    sus ideas para mejorar la calidad del trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATECoId']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Comparte    sus conocimientos para mejorar la calidad del trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATECoCo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Apoya al    grupo en todo lo que sea necesario para el logro de los objetivos del &aacute;rea.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATEApGr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Apoya las    decisiones grupales.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATEApDe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Da    prioridad a los intereses del equipo por encima de los propios.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATEPrIn']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta la    uni&oacute;n del equipo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATEFoUn']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta la    confianza del equipo en situaciones dif&iacute;ciles.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATEFoCo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Colabora    oportunamente con sus compa&ntilde;eros para brindar un &oacute;ptimo servicio.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATECoOp']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Respeta la    forma de trabajo de los dem&aacute;s.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATEReFt']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="13" bordercolor="#006600" class="Estilo40"><div align="center">COMUNICACI&Oacute;N</div></td>
      <td width="155" rowspan="13" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    para recibir, procesar y compartir informaci&oacute;n de manera clara, oralmente y    por escrito</div></td>
      <td width="242" height="32" bordercolor="#006600" class="Estilo42">Escucha    atentamente a los dem&aacute;s.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOEsAt']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Hace buen    uso del lenguaje.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOBuLe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Transmite    la informaci&oacute;n pertinente a los dem&aacute;s.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOTrIn']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Es    discreto(a) con la informaci&oacute;n confidencial</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACODiIn']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Se expresa    pensando en quienes van a recibir el mensaje.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOExPe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta la    comunicaci&oacute;n para solucionar conflictos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOFoCo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Solicita    la informaci&oacute;n pertinente cuando la requiere</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOSoIn']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Expresa    prudentemente los desacuerdos con las ideas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOExDe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Mantiene    contacto visual con quien se comunica.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOCoVi']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Su    expresi&oacute;n gestual y corporal facilita la comunicaci&oacute;n.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOExGc']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Dedica el    tiempo suficiente para que la comunicaci&oacute;n sea efectiva.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOTiSu']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Tiene en    cuenta el tiempo de los dem&aacute;s al comunicarse con ellos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOTiDe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Expresa    sus ideas abiertamente.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOExAb']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="25" bordercolor="#006600" class="Estilo40"><div align="center">LIDERAZGO</div></td>
      <td width="155" rowspan="25" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    para establecer objetivos y guiar al grupo&nbsp;    hacia su cumplimiento.</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Destaca    los &eacute;xitos del grupo sin apropiarse de ellos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIExGr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Establece    planes para realizar de manera adecuada y efectiva el trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIEsPL']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Establece    objetivos coherentes con los medios t&eacute;cnicos, financieros y humanos    disponibles</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIObCo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Dise&ntilde;a    mecanismos de control y seguimiento del desempe&ntilde;o del equipo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIMeCo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Tiene en    cuenta los acontecimientos laborales y personales importantes de sus    colaboradores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIAcCo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Aclara las    expectativas que tiene con el equipo de trabajo</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIAcEx']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Asume la    responsabilidad por los fracasos del grupo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIAsRe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Atiende    con prontitud a sus colaboradores cuando le necesitan.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIAtPr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Conoce en    profundidad los puestos de trabajo de sus colaboradores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALICoPt']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Corrige a    tiempo las desviaciones de los objetivos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALICoDe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta la    participaci&oacute;n de los miembros del equipo para mejorar los procesos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIFoPa']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Selecciona    colaboradores id&oacute;neos para el equipo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALICoId']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Genera    participaci&oacute;n para la toma de decisiones</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIGePa']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta en    el grupo un esp&iacute;ritu de cooperaci&oacute;n y confianza.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIEsCo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Aporta    efectivamente para la soluci&oacute;n de conflictos en el equipo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIApEf']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Mantiene    una buena relaci&oacute;n interpersonal con sus colaboradores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIBuRe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Es justo    en la evaluaci&oacute;n de sus colaboradores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIJuEv']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Proporciona    retroalimentaci&oacute;n continua a sus colaboradores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIReCo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Alinea el    trabajo con la misi&oacute;n y visi&oacute;n de la Universidad.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALITrMv']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Da    reconocimiento a la gente por el &eacute;xito del &aacute;rea.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIReEx']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Permite a    sus colaboradores tomar decisiones</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIPeTd']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Impulsa    una visi&oacute;n innovadora en el equipo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIViIn']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Asigna    tareas a sus colaboradores para estimular su desarrollo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALITaEs']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Comparte    oportunamente la informaci&oacute;n con sus colaboradores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALICoIn']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Encarga a    sus colaboradores retos acordes con sus capacidades.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CALIReCa']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">SERVICIO</div></td>
      <td width="155" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    de comprender las necesidades del usuario interno y externo y enfocarse en su    satisfacci&oacute;n.</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Se pone en    el lugar del usuario para entender sus necesidades</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CASELuCl']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Atiende    amablemente al usuario.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CASEAtAm']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Asesora al    usuario para encontrar soluci&oacute;n a sus necesidades</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CASEAsUs']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Da    prioridad a las necesidades del usuario antes que a las propias.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CASEPrNe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Procura    una soluci&oacute;n al usuario, incluso si debe asumir riesgos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CASESoUs']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    inter&eacute;s para solucionar posibles problemas de servicio.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CASEInSo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Se    preocupa por la imagen de la universidad ante el usuario.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CASEImUn']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Adapta sus    actividades para dar mejor servicio al usuario.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CASEAdAc']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Apoya los    objetivos que tiene la Universidad sobre servicio al usuario.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CASEApOb']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Se    esfuerza por brindar un servicio de alta calidad.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CASESeAc']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">ADAPTABILIDAD</div></td>
      <td width="155" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    de flexibilizar el comportamiento propio ante el cambio para el logro de    objetivos personales y organizacionales</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Aplica a    su trabajo las nuevas disposiciones establecidas por la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAADApDi']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Implementa    estrategias para manejar la resistencia al cambio.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAADReCa']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Participa    activamente al interior de su grupo de trabajo para que los cambios tengan    &eacute;xito.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAADPaGr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    inter&eacute;s por adquirir conocimientos sobre los cambios que implementa la    Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAADInCo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Ve el    cambio como una oportunidad de crecimiento</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAADCaOp']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Responde    positivamente a los cambios de la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAADRePo']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="8" bordercolor="#006600" class="Estilo40"><div align="center">APRENDIZAJE</div></td>
      <td width="155" rowspan="8" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    para integrar nueva informaci&oacute;n y aplicarla eficazmente</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Genera    espacios para el desarrollo del conocimiento en su &aacute;rea</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAAPDeCo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Aplica en    su trabajo los conocimientos adquiridos</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAAPApCo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Aplica con    inter&eacute;s las nuevas tecnolog&iacute;as</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAAPNuTe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Asiste a    cursos de entrenamiento, capacitaci&oacute;n o formaci&oacute;n dentro y fuera de la    Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAAPAsCu']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Utiliza    herramientas para mejorar su conocimiento en el trabajo (computador,    biblioteca, eventos).</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAAPUtHe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    inter&eacute;s por adquirir conocimientos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAAPInCo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Pone en    pr&aacute;ctica los conocimientos que le transmiten los dem&aacute;s</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAAPCoDe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Actualiza    constantemente su conocimiento de normas y procesos relacionados con su    trabajo</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAAPAcCo']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="11" bordercolor="#006600" class="Estilo40"><div align="center">CONCIENCIA    ORGANIZACIONAL</div></td>
      <td width="155" rowspan="11" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    de enfocar su labor hacia el cumplimiento de la misi&oacute;n, visi&oacute;n, pol&iacute;ticas,    objetivos y estrategias </div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Aplica las    directrices de la Universidad a su trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACODiUn']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Conoce la    estructura organizacional de la universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOCoEo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Contribuye    al logro de la misi&oacute;n de la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOLoMi']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Contribuye    al logro de la visi&oacute;n de la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOLoVi']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Coopera    con las diferentes &aacute;reas de la Universidad para el logro de los objetivos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOCoAr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Protege la    imagen corporativa de la organizaci&oacute;n.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOPrIc']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Reconoce    el impacto que tiene su trabajo en otras &aacute;reas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOReIt']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Identifica    los procesos de su &aacute;rea de trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOIdPr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Cumple con    los procesos de su &aacute;rea de trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOCuPr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Conoce los    objetivos de las &aacute;reas con las que se relaciona.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOCoOb']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Cumple con    el reglamento de trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACOCuRe']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">MANEJO DE CONFLICTOS Y    CAPACIDAD DE NEGOCIACI&Oacute;N</div></td>
      <td width="155" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    para manejar situaciones que puedan afectar el desempe&ntilde;o y el avance    organizacional</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Act&uacute;a    luego de analizar adecuadamente el conflicto o problema.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACNAnAd']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Conserva    el profesionalismo en situaciones de conflicto o problema.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACNCoPr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Reacciona    r&aacute;pidamente para solucionar conflictos o problemas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACNReRa']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Busca    soluciones y no culpables del conflicto o problema.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACNBuSo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Controla    su comportamiento para no generar ni prolongar el conflicto.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACNCoCo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Plantea    estrategias GANA-GANA para resolver conflictos y problemas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACNEsGg']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Entiende    las razones de las partes involucradas en el conflicto</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACNEnRa']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Est&aacute;    abierto/a las propuestas para solucionar el conflicto.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACNAbPr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Establece    soluciones duraderas a los conflictos o problemas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACNEsSd']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Hace    seguimiento a la soluci&oacute;n dada a los conflictos y problemas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACNSeSo']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">CREATIVIDAD E    INNOVACI&Oacute;N</div></td>
      <td width="155" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    de generar y aplicar ideas nuevas y &uacute;tiles para un mayor desarrollo personal    y organizacional.</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Promueve    la generaci&oacute;n de nuevas ideas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACIPrId']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Propone    formas originales de hacer las cosas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACIFoOr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Genera    ideas &uacute;tiles para la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACIIdUt']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    recursividad cuando enfrenta desaf&iacute;os laborales y personales</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACIReDe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Cuestiona    la forma de hacer las cosas para idear nuevas pr&aacute;cticas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACIIdNp']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta    espacios de reflexi&oacute;n&nbsp; para mejorar los    procesos de trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CACIEsRe']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">DISCIPLINA Y    ORGANIZACI&Oacute;N</div></td>
      <td width="155" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    para cumplir las normas de la Universidad y conservar el orden en sus    aspectos personales y profesionales</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Cumple los    horarios establecidos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOCuHo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Aprovecha    productivamente el tiempo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOApTi']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Concluye    los procesos y tareas que inicia.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOCoPr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Refleja la    imagen de la Universidad con su comportamiento y presentaci&oacute;n personal.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOImUn']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Conserva    un orden adecuado de la documentaci&oacute;n a su cargo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOCoOr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Cumple con    los planes que establece.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOCuPl']; ?></td>
    </tr>
    <tr>
      <td width="242" height="31" bordercolor="#006600" class="Estilo42">Realiza su    trabajo ordenadamente.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOTrOr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Mantiene    el orden f&iacute;sico de su &aacute;rea de trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOOrFi']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Evita las    distracciones, concentr&aacute;ndose en la actividad que realiza.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOEvDi']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Cumple    con los procesos inherentes al cargo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOCuPr']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="9" bordercolor="#006600" class="Estilo40"><div align="center">INTEGRIDAD</div></td>
      <td width="155" rowspan="9" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad para actuar    conforme a las normas &eacute;ticas y&nbsp; morales    y velar por su cumplimiento</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Asume la    responsabilidad por sus errores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAINAsRe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    coherencia entre lo que dice y lo que hace.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAINCoDh']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Maneja la    confidencialidad de la informaci&oacute;n pertinente a la Universidad.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAINCoIn']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    lealtad a la Universidad.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAINLeUn']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Pr&aacute;ctica    los valores de la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAINVaUn']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Act&uacute;a    &eacute;ticamente al tomar decisiones</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAINAcEt']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Evita    aceptar beneficios inmerecidos por logros que no le corresponden</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAINEvBe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Evita    incurrir en comportamientos de acoso laboral.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAINCoAc']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Es    respetuoso/a con sus compa&ntilde;eros.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAINReCo']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">MANEJO DEL ESTR&Eacute;S</div></td>
      <td width="155" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad de mantener    la efectividad y la serenidad al trabajar bajo presi&oacute;n</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Balancea    adecuadamente la carga de trabajo con su vida personal.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAMEBaCt']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Maneja    adecuadamente las presiones que otras personas ejercen.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAMEMaPr']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Enfrenta    lo que le genera estr&eacute;s en lugar de evitarlo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAMEEnEs']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta    estrategias para el manejo del estr&eacute;s propio y del grupo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAMEFoEs']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Pr&aacute;ctica    h&aacute;bitos de salud que contribuyen con el manejo de estr&eacute;s (alimentaci&oacute;n,    sue&ntilde;o, ejercicio, esparcimiento).</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAMEHaSa']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Conserva    la calma en momentos de alta tensi&oacute;n.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAMECaMt']; ?></td>
    </tr>
    
    <tr>
      <td width="186" rowspan="8" bordercolor="#006600" class="Estilo40"><div align="center">TOMA DE DECISIONES</div></td>
      <td width="155" rowspan="8" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad de definir de    manera precisa, &aacute;gil y &eacute;tica el curso de acci&oacute;n a tomar en diversas    situaciones</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Tiene en    cuenta el impacto de las decisiones que toma.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATDImDe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Asume las    decisiones con responsabilidad.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATDDeRe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Asume los    riesgos al tomar una decisi&oacute;n.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATDRiDe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Toma    decisiones oportunamente.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATDDeOp']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Toma    decisiones adecuadamente cuando la situaci&oacute;n lo requiere</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATDDeAd']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Eval&uacute;a las    alternativas al tomar decisiones.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATDEvAl']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Se    documenta para tomar decisiones acertadas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATDDoDe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Se    mantiene firme luego de tomar una decisi&oacute;n.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CATDFiDe']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">RELACIONES    INTERPERSONALES</div></td>
      <td width="155" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad de mantener    buenas relaciones con los compa&ntilde;eros&nbsp;    para el logro de los objetivos organizacionales y personales</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Es    agradable en su trato con los dem&aacute;s.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CARIAgDe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Comparte    el buen humor con sus compa&ntilde;eros.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CARIBuHu']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Comprende    las manifestaciones emocionales de los dem&aacute;s.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CARICoMe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Contribuye    al buen clima organizacional.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CARICoCl']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Tiene    buenas relaciones con todas las personas, aunque haya conflictos entre ellas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CARIBuTo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Disculpa    f&aacute;cilmente, sin guardar rencor.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CARIDiFa']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Participa    en las actividades sociales de la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CARIPaAc']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Acepta la    diversidad (Raza, estrato, sexo, religi&oacute;n, regi&oacute;n, profesi&oacute;n, pol&iacute;tica,    etc.).</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CARIAcDi']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Comparte    con agrado el logro de los dem&aacute;s.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CARICoLo']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Adopta una    posici&oacute;n conciliadora en las relaciones dif&iacute;ciles.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CARIPoCo']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">ORIENTACI&Oacute;N AL LOGRO</div></td>
      <td width="155" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad para buscar    el desarrollo personal y profesional haciendo el esfuerzo permanente para    lograrlo</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    iniciativa para lograr objetivos personales y laborales.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAOLInOb']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Trabaja    persistentemente hasta lograr las metas que se propone.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAOLTrPe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Dedica    tiempo a su formaci&oacute;n personal.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAOLFoPe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Busca    mejorar continuamente su calidad de vida.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAOLMcCv']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Ejecuta    los proyectos laborales a los que se compromete.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAOLEjPl']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Cree en    sus capacidades para lograr lo que se propone.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAOLCrCa']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Tiene un    proyecto profesional definido.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAOLPpDe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Supera los    obst&aacute;culos para lograr lo que parece imposible.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAOLSuOb']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Busca    formas de mejorar la eficacia de su trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAOLFoMe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Tiene un    proyecto personal definido.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CAOLPrPe']; ?></td>
    </tr>
    <tr>
      <td width="186" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">DESARROLLO DE OTRAS    PERSONAS</div></td>
      <td width="155" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad de motivar y    orientar el crecimiento personal y profesional de compa&ntilde;eros y colaboradores</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Act&uacute;a como    instructor de quienes est&aacute;n aprendiendo de un tema</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOInAp']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Anima a    los dem&aacute;s a lograr sus objetivos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOAnOt']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Apoya a    otros en su desarrollo personal o profesional.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOApOt']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Genera    actividades de desarrollo en el equipo de trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOAcDe']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Apoya a    otros para lograr mayor flexibilidad al cambio.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOApFl']; ?></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Brinda    apoyo a los dem&aacute;s cuando tienen problemas laborales o personales</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><?php echo $row_ConsPerfil['CADOBrAp']; ?></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td><div align="center">
        <input name="submit" type="submit" onclick="MM_popupMsg('El perfil ha sido enviado correctamente. Ahora ver&aacute; un nuevo perfil en blanco por si requiere diligenciar otro cargo. Si no, simplemente cierre la p&aacute;gina o vaya a otra p&aacute;gina. \r\rMuchas gracias por su colaboraci&oacute;n para construir un mejor equipo\r\rDEPARTAMENTO DE TALENTO HUMANO')" value="Enviar perfil de cargo" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><p align="center"><strong>MUCHAS GRACIAS POR SU COLABORACI&Oacute;N.</strong></p>
        <p align="center"><strong>ESTO CONTRIBUYE AMPLIAMENTE CON LA CALIDAD DE NUESTRA UNIVERSIDAD  </strong></p>
      <p align="center"><strong>DEPARTAMENTO DE TALENTO HUMANO - GAPP</strong></p></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;  </p>
  <p> </p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ConsPerfil);
?>
