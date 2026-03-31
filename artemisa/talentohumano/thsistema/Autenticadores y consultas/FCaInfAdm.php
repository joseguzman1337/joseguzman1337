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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tautentadmon SET IdAdmin=%s, Nombre=%s WHERE IdRegAdmon=%s",
                       GetSQLValueString($_POST['IdAdmin'], "int"),
                       GetSQLValueString($_POST['Nombre'], "text"),
                       GetSQLValueString($_POST['IdRegAdmon'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
}

$colname_CaInAdmini = "-1";
if (isset($_GET['CCBuscar'])) {
  $colname_CaInAdmini = (get_magic_quotes_gpc()) ? $_GET['CCBuscar'] : addslashes($_GET['CCBuscar']);
}
mysql_select_db($database_conexion, $conexion);
$query_CaInAdmini = sprintf("SELECT * FROM tautentadmon WHERE Nombre = '%s' ORDER BY Nombre ASC", $colname_CaInAdmini);
$CaInAdmini = mysql_query($query_CaInAdmini, $conexion) or die(mysql_error());
$row_CaInAdmini = mysql_fetch_assoc($CaInAdmini);
$totalRows_CaInAdmini = mysql_num_rows($CaInAdmini);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo4 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
.Estilo22 {color: #FFFFFF; font-weight: bold; }
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
<table width="838" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">FORMULARIO DE CAMBIO INFORMACION ADMINISTRADORES </div></td>
  </tr>
</table>
<table width="841" border="0">
  <tr>
    <td bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="840" border="1">
    <tr>
      <td colspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <p>Estimado usuario, por favor haga los cambios requeridos y presione el bot&oacute;n &quot;Actualizar&quot;.</p>
        <p>&nbsp;</p>
      </div></td>
    </tr>
    <tr>
      <td width="412" bgcolor="#FFFFCC" class="Estilo4"><div align="right">C&eacute;dula </div></td>
      <td width="412" bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="IdAdmin" value="<?php echo $row_CaInAdmini['IdAdmin']; ?>" size="32" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="right">Nombres y apellidos </div></td>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Nombre" value="<?php echo $row_CaInAdmini['Nombre']; ?>" size="32" /></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
        <p>
          <input name="submit" type="submit" onclick="MM_popupMsg('Estimado administrador: la informaci&oacute;n ha sido cambiada correctamente. \r\rPresione \&quot;IR A PAGINA DE ADMINISTRADORES\&quot; para volver a consultas.')" value="Actualizar registro" />
        </p>
        <p><a href="PagAdmini.php">IR A PAGINA DE ADMINISTRADORES</a></p>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>
    <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="IdRegAdmon" value="<?php echo $row_CaInAdmini['IdRegAdmon']; ?>">
</p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($CaInAdmini);
?>
