<?php require_once('../Connections/conexion.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

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
  $updateSQL = sprintf("UPDATE tjefdep SET CCJefDep=%s, JefDepen=%s WHERE IdRegJefe=%s",
                       GetSQLValueString($_POST['CCJefDep'], "int"),
                       GetSQLValueString($_POST['JefDepen'], "text"),
                       GetSQLValueString($_POST['IdRegJefe'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
}

$maxRows_Recordset1 = 1;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_GET['CCBuscar'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['CCBuscar'] : addslashes($_GET['CCBuscar']);
}
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = sprintf("SELECT * FROM tjefdep WHERE JefDepen = '%s'", $colname_Recordset1);
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
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
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">FORMULARIO DE AUTENTICACION DE USUARIO </div></td>
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
      <td width="412" bgcolor="#FFFFCC" class="Estilo4"><div align="right">C&eacute;dula jefe </div></td>
      <td width="412" bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="CCJefDep" value="<?php echo $row_Recordset1['CCJefDep']; ?>" size="50" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="right">Nombres y apellidos jefe </div></td>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="JefDepen" value="<?php echo $row_Recordset1['JefDepen']; ?>" size="50" /></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
        <input name="submit" type="submit" onclick="MM_popupMsg('Estimado usuario, el cambio solicitado se realiz&oacute; con &eacute;xito. El sistema le devolver&aacute; a la pantalla de busqueda de jefes por si desea hacer otro cambio. De lo contrario, pase a otra p&aacute;gina o salga de internet.')" value="Actualizar" />
      </div></td>
    </tr>
  </table>
  <p align="left" class="Estilo4">N&uacute;mero de registro en sistema: <?php echo $row_Recordset1['IdRegJefe']; ?></p>
  <p>
    <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="IdRegJefe" value="<?php echo $row_Recordset1['IdRegJefe']; ?>">
      </p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
