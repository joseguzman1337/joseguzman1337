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
  $insertSQL = sprintf("INSERT INTO tjefdep (CCJefDep, JefDepen) VALUES (%s, %s)",
                       GetSQLValueString($_POST['CCJefDep'], "int"),
                       GetSQLValueString($_POST['JefDepen'], "text"));

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
.Estilo22 {color: #FFFFFF; font-weight: bold; }
.Estilo4 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
.Estilo5 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 12px; }
.Estilo6 {color: #FF0000}
-->
</style>
</head>

<body>
<table width="838" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">INGRESO DE NUEVOS DIRECTIVOS<br />
      PARA EL SISTEMA DE EVALUACI&Oacute;N DE DESEMPE&Ntilde;O
      <br />
    </div></td>
  </tr>
</table>
<table width="838" border="0">
  <tr>
    <td width="832" bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap><div align="center"><span class="Estilo4">Por favor ingrese los datos del nuevo directivo</span></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr valign="baseline">
      <td width="236" align="right" nowrap bgcolor="#FFFFCC">C&eacute;dula:</td>
      <td width="590" bgcolor="#FFFFCC"><p>
          <input type="text" name="CCJefDep" value="" size="40">
      Escriba el n&uacute;mero sin puntos ni espacios</p>      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#FFFFCC">Directivo:</td>
      <td bgcolor="#FFFFCC"><input type="text" name="JefDepen" value="" size="40"> 
      Nombres y Apellidos completos </td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap bgcolor="#FFFFCC"><div align="center">
        <input type="submit" value="Enviar">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
<p align="center" class="Estilo4">&nbsp;</p>
</body>
</html>
