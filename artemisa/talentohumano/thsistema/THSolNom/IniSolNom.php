<?php require_once('../Connections/conexion.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tsolinom (UnidSoli, FechaSol, Apellido, Nombres, CCSolic, Cargo, Categor, CentroCo, FechaIni, FechaFin, ClaseDesc, ClaseDedi, PrepaDesc, PrepaDedi, EvalDesc, EvalDedi, ExitoDesc, ExitoDedi, LaboDesc, LaboDedi, InveForDesc, InveForDedi, TICDesc, TICDedi, InveBasDesc, InveBasDesc, PracticaDesc, PracticaDedi, ConsultoriaDesc, ConsultoriaDedi, EduContDesc, EduContDedi, GestAcadDesc, GestAcadDedi, DedicTot, PuntCoor, Direccio, Observac) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['UnidSoli'], "text"),
                       GetSQLValueString($_POST['FechaSol'], "date"),
                       GetSQLValueString($_POST['Apellido'], "text"),
                       GetSQLValueString($_POST['Nombres'], "text"),
                       GetSQLValueString($_POST['CCSolic'], "int"),
                       GetSQLValueString($_POST['Cargo'], "text"),
                       GetSQLValueString($_POST['Categor'], "text"),
                       GetSQLValueString($_POST['CentroCo'], "text"),
                       GetSQLValueString($_POST['FechaIni'], "date"),
                       GetSQLValueString($_POST['FechaFin'], "date"),
                       GetSQLValueString($_POST['ClaseDesc'], "text"),
                       GetSQLValueString($_POST['ClaseDedi'], "text"),
                       GetSQLValueString($_POST['PrepaDesc'], "text"),
                       GetSQLValueString($_POST['PrepaDedi'], "text"),
                       GetSQLValueString($_POST['EvalDesc'], "text"),
                       GetSQLValueString($_POST['EvalDedi'], "text"),
                       GetSQLValueString($_POST['ExitoDesc'], "text"),
                       GetSQLValueString($_POST['ExitoDedi'], "text"),
                       GetSQLValueString($_POST['LaboDesc'], "text"),
                       GetSQLValueString($_POST['LaboDedi'], "text"),
                       GetSQLValueString($_POST['InveForDesc'], "text"),
                       GetSQLValueString($_POST['InveForDedi'], "text"),
                       GetSQLValueString($_POST['TICDesc'], "text"),
                       GetSQLValueString($_POST['TICDedi'], "text"),
                       GetSQLValueString($_POST['InveBasDesc'], "text"),
                       GetSQLValueString($_POST['InveBasDesc'], "text"),
                       GetSQLValueString($_POST['PracticaDesc'], "text"),
                       GetSQLValueString($_POST['PracticaDedi'], "text"),
                       GetSQLValueString($_POST['ConsultoriaDesc'], "text"),
                       GetSQLValueString($_POST['ConsultoriaDedi'], "text"),
                       GetSQLValueString($_POST['EduContDesc'], "text"),
                       GetSQLValueString($_POST['EduContDedi'], "text"),
                       GetSQLValueString($_POST['GestAcadDesc'], "text"),
                       GetSQLValueString($_POST['GestAcadDedi'], "text"),
                       GetSQLValueString($_POST['DedicTot'], "int"),
                       GetSQLValueString($_POST['PuntCoor'], "text"),
                       GetSQLValueString($_POST['Direccio'], "text"),
                       GetSQLValueString($_POST['Observac'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}
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
.Estilo7 {	font-family: Tahoma;
	font-size: 12px;
	font-weight: bold;
}
.Estilo1 {font-size: 16px;
	font-weight: bold;
	color: #FFFFFF;
	font-family: Tahoma;
}
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
<table width="850" border="1">
  <tr>
    <td width="152" bgcolor="#98BD0D"><div align="center"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="A" width="141" height="61" /></div></td>
    <td width="682" bgcolor="#98BD0D"><p align="center" class="Estilo1">SOLICITUD DE NOMBRAMIENTO DOCENTE </p></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#FFB112" class="Estilo4"><div align="center" class="Estilo2">DEPARTAMENTO DE TALENTO HUMANO - CONFORMANDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="850" border="0" bgcolor="#FFFFCC">
    <tr>
      <td width="250" class="Estilo4"><div align="right" class="Estilo10"><span class="Estilo2"><strong>Fecha</strong></span></div></td>
      <td width="590"><input type="text" name="FechaSol" value=<?php echo date('Y-m-d') ?> size="32" /></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10"><span class="Estilo2"><strong>Unidad&nbsp;  Solicitante</strong></span></div></td>
      <td><input name="UnidSoli" type="text" id="UnidSoli" value="" size="80" /></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10"><span class="Estilo2"><strong>Apellidos   completos </strong></span></div></td>
      <td><input type="text" name="Apellido" value="" size="80" /></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10"><span class="Estilo2"><strong>Nombres</strong> completos</span> </div></td>
      <td><input type="text" name="Nombres" value="" size="80" /></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10"><span class="Estilo2"><strong>Documento  de identidad</strong></span></div></td>
      <td><input type="text" name="CCSolic" value="" size="80" /></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10"><span class="Estilo2"><strong>Cargo</strong></span></div></td>
      <td><input type="text" name="Cargo" value="" size="80" /></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10"><span class="Estilo2"><strong>Categor&iacute;a</strong></span></div></td>
      <td><input type="text" name="Categor" value="" size="80" /></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10"><span class="Estilo2"><strong>Centro de  costo</strong></span></div></td>
      <td><input type="text" name="CentroCo" value="" size="80" /></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10"><span class="Estilo2"><strong>Fecha  inicial</strong></span></div></td>
      <td><input type="text" name="FechaIni" value="" size="32" /> 
      <span class="Estilo4">(aaaa-mm-dd - Ej. 2014-01-07) </span></td>
    </tr>
    <tr>
      <td class="Estilo4"><div align="right" class="Estilo10"><span class="Estilo2"><strong>Fecha  final</strong></span></div></td>
      <td><input type="text" name="FechaFin" value="" size="32" />
      <span class="Estilo4">(aaaa-mm-dd - Ej. 2014-12-20) </span></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="850" border="0" bgcolor="#FFFFCC">
    <tr>
      <th colspan="3" scope="col"><div align="left"><strong class="Estilo5">Carga Acad&eacute;mica  </strong></div></th>
    </tr>
    
    <tr>
      <th width="267" scope="col"><div align="left" class="Estilo5">Docencia<span class="Estilo6"></span></div></th>
      <th width="388" class="Estilo4" scope="col"><span class="Estilo2">Descripci&oacute;n</span></th>
      <th width="181" class="Estilo4" scope="col"><span class="Estilo2">Dedicaci&oacute;n</span></th>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo7">Clase</div></th>
      <td><textarea name="ClaseDesc" cols="60"></textarea></td>
      <td><textarea name="ClaseDedi" cols="25"></textarea></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo7">Preparaci&oacute;n</div></th>
      <td><textarea name="PrepaDesc" cols="60"></textarea></td>
      <td><textarea name="PrepaDedi" cols="25"></textarea></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo7">Evaluaci&oacute;n</div></th>
      <td><textarea name="EvalDesc" cols="60"></textarea></td>
      <td><textarea name="EvalDedi" cols="25"></textarea></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo7">&Euml;xito</div></th>
      <td><textarea name="ExitoDesc" cols="60"></textarea></td>
      <td><textarea name="ExitoDedi" cols="25"></textarea></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo7">Laboratorio</div></th>
      <td><textarea name="LaboDesc" cols="60"></textarea></td>
      <td><textarea name="LaboDedi" cols="25"></textarea></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo7">TIC</div></th>
      <td><textarea name="TICDesc" cols="60"></textarea></td>
      <td><textarea name="TICDedi" cols="25"></textarea></td>
    </tr>
    
    <tr>
      <th class="Estilo4" scope="row"><div align="left" class="Estilo5">Investigaci&oacute;n</div></th>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo7"> Formativa </div></th>
      <td><textarea name="InveForDesc" cols="60"></textarea></td>
      <td><textarea name="InveForDedi" cols="25"></textarea></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo7">Investigaci&oacute;n </div></th>
      <td><textarea name="InveBasDesc" cols="60"></textarea></td>
      <td><textarea name="InveBasDesc" cols="25"></textarea></td>
    </tr>
    <tr>
      <th class="Estilo5" scope="row"><div align="left">Extensi&oacute;n</div></th>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo7">Pr&aacute;cticas</div></th>
      <td><textarea name="PracticaDesc" cols="60"></textarea></td>
      <td><textarea name="PracticaDedi" cols="25"></textarea></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo7">Consultor&iacute;a</div></th>
      <td><textarea name="ConsultoriaDesc" cols="60"></textarea></td>
      <td><textarea name="ConsultoriaDedi" cols="25"></textarea></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo7">Educaci&oacute;n Continuada </div></th>
      <td><textarea name="EduContDesc" cols="60"></textarea></td>
      <td><textarea name="EduContDedi" cols="25"></textarea></td>
    </tr>
    <tr>
      <th class="Estilo4" scope="row"><div align="right" class="Estilo7">Gesti&oacute;n Acad&eacute;mica </div></th>
      <td><textarea name="GestAcadDesc" cols="60"></textarea></td>
      <td><textarea name="GestAcadDedi" cols="25"></textarea></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="850" border="0">
    <tr>
      <th colspan="3" class="Estilo12" scope="col">DEDICACI&Oacute;N</th>
    </tr>
    <tr>
      <th width="253" class="Estilo12" scope="col"><div align="right" class="Estilo11">Puntos por Direcci&oacute;n </div></th>
      <th colspan="2" scope="col"><div align="left">
        <input type="text" name="Direccio" value="" size="80" />
      </div></th>
    </tr>
    <tr>
      <th class="Estilo12" scope="row"><div align="right" class="Estilo11">Puntos  por Coordinaci&oacute;n </div></th>
      <td colspan="2"><input name="PuntCoor" type="text" id="PuntCoor" value="" size="80" /></td>
    </tr>
    <tr>
      <th class="Estilo12" scope="row"><div align="right">Observaciones</div></th>
      <td colspan="2"><textarea name="Observac" cols="77" rows="5"></textarea></td>
    </tr>
    <tr>
      <th colspan="2" class="Estilo12" scope="row">&nbsp;</th>
      <th width="438" class="Estilo12" scope="row">&nbsp;</th>
    </tr>
    <tr>
      <th colspan="2" class="Estilo12" scope="row">&nbsp;</th>
      <th class="Estilo12" scope="row">&nbsp;</th>
    </tr>
    <tr>
      <th colspan="2" class="Estilo12" scope="row">&nbsp;</th>
      <th class="Estilo12" scope="row">&nbsp;</th>
    </tr>
    <tr>
      <th colspan="2" class="Estilo12" scope="row"><strong>Firma del Solicitante <br />
Cargo</strong></th>
      <th class="Estilo12" scope="row"><strong>Vo. Bo. Vicerrector Acad&eacute;mico</strong></th>
    </tr>
    <tr>
      <th colspan="3" class="Estilo12" scope="row"><input name="submit" type="submit" onclick="MM_popupMsg('Estimado usuario\r\rSu solicitud ha sido enviada correctamente y ser&aacute; revisada y atendida por Talento Humano lo m&aacute;s pronto posible.\r\rEn seguida ver&aacute; un formato en blanco por si requiere hacer otra solicitud. De lo contrario, cierre internet o vaya a otra p&aacute;gina.\r\rCordialmente\rDepartamento de Talento HUmano')" value="Enviar solicitud" /></th>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1">
</p>
</form>
<p>&nbsp;</p>
</body>
</html>
