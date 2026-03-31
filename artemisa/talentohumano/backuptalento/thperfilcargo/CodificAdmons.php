<?php require_once('Connections/conexion.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO tautentadmon (IdAdmin, Nombre) VALUES (%s, %s)",
                       GetSQLValueString($_POST['IdAdmin'], "int"),
                       GetSQLValueString($_POST['Nombre'], "text"));

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
.Estilo24 {font-size: 9px}
-->
</style>
</head>

<body>
<table width="838" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">FORMULARIO DE INGRESO DE ADMINISTRADORES DEL SISTEMA </div></td>
  </tr>
</table>
<table width="841" border="0">
  <tr>
    <td bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="840" border="0">
  <tr>
    <td><div align="center">
      <p class="Estilo4">Estimado usuario, por favor ingrese la c&eacute;dula y el nombre del nuevo usuario.</p>
      <p class="Estilo4"> Gracias. </p>
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
          <td width="416" bgcolor="#FFFFCC"><div align="right" class="Estilo4">C&eacute;dula (sin puntos ni espacios):</div></td>
          <td width="414" bgcolor="#FFFFCC">            <span class="Estilo4">
          <input type="text" name="IdAdmin" value="" size="32" />          
          </span></td>
    </tr>
        <tr>
          <td bgcolor="#FFFFCC"><div align="right" class="Estilo4">Nombres y apellidos:</div></td>
          <td bgcolor="#FFFFCC">            <span class="Estilo4">
          <input type="text" name="Nombre" value="" size="32" />          
          </span></td>
    </tr>
        <tr>
          <td colspan="2" bgcolor="#FFFFCC"><div align="center">
            <span class="Estilo4">
            <input name="submit" type="submit" value="Enviar" />
            </span></div></td>
    </tr>
      </table>
  <p>&nbsp;</p>
      <p>
        <input type="hidden" name="MM_insert" value="form1">
  </p>
</form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</body>
</html>
