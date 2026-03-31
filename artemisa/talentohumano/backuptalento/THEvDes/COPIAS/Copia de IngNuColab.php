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
  $insertSQL = sprintf("INSERT INTO tlistacol (IdColab, NombCol, CarCol, FeInCol, FeReCol, CodCol, ContCol, DepCol, TodCampos) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['IdColab'], "int"),
                       GetSQLValueString($_POST['NombCol'], "text"),
                       GetSQLValueString($_POST['CarCol'], "text"),
                       GetSQLValueString($_POST['FeInCol'], "date"),
                       GetSQLValueString($_POST['FeReCol'], "date"),
                       GetSQLValueString($_POST['CodCol'], "int"),
                       GetSQLValueString($_POST['ContCol'], "text"),
                       GetSQLValueString($_POST['DepCol'], "text"),
                       GetSQLValueString($_POST['TodCampos'], "text"));

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
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">INGRESO DE NUEVOS COLABORADORES <br />
      CONTRATADOS A T&Eacute;RMINO FIJO E INDEFINIDO </div></td>
  </tr>
</table>
<table width="838" border="0">
  <tr>
    <td width="832" bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p align="center" class="Estilo4">Por favor ingrese los datos del nuevo colaborador </p>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table>
    <tr valign="baseline">
      <td width="390" align="right" nowrap bgcolor="#FFFFCC" class="Estilo5"><p>Cedula</p>
      </td>
      <td width="435" bgcolor="#FFFFCC" class="Estilo5"><input type="text" name="IdColab" value="" size="32">
        <br />
      Escriba sin puntos ni espacios </td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#FFFFCC" class="Estilo5">Apellidos y Nombres:</td>
      <td width="435" bgcolor="#FFFFCC" class="Estilo4"><input name="NombCol" type="text" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#FFFFCC" class="Estilo5">Cargo Colaborador :</td>
      <td width="435" bgcolor="#FFFFCC" class="Estilo4"><input name="CarCol" type="text" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#FFFFCC" class="Estilo5">Fecha inicio contrato :</td>
      <td width="435" bgcolor="#FFFFCC" class="Estilo5"><input type="text" name="FeInCol" value="" size="32">
        <br />
      Ingrese a&ntilde;o-mes-dia Ejemplo: 2010-11-24 NO olvide los guiones </td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#FFFFCC" class="Estilo5">Fecha fin contrato :</td>
      <td width="435" bgcolor="#FFFFCC" class="Estilo5"><input type="text" name="FeReCol" value="" size="32"> 
        <br />
      D&eacute;jelo vac&iacute;o si es indefinido o ingrese a&ntilde;o-mes-dia si es a t&eacute;rmino fijo </td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#FFFFCC" class="Estilo5">C&oacute;digo del colaborador :</td>
      <td width="435" bgcolor="#FFFFCC" class="Estilo4"><input name="CodCol" type="text" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#FFFFCC" class="Estilo5">Tipo de contrato :</td>
      <td width="435" bgcolor="#FFFFCC" class="Estilo4"><input name="ContCol" type="text" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#FFFFCC" class="Estilo5">Departamento al que pertenece :</td>
      <td width="435" bgcolor="#FFFFCC" class="Estilo4"><input name="DepCol" type="text" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" bgcolor="#FFFFCC" class="Estilo5">Llene este campo seg&uacute;n las instrucciones que encuentra abajo :</td>
      <td width="435" bgcolor="#FFFFCC" class="Estilo5"><p>
        <textarea name="TodCampos" cols="60" rows="7">APELLIDOS Y NOMBRES ---- ( cargo: SEC.CATEG II / Fecha Ingreso: 1996-05-02/ Fecha Termina: indefinido / Codigo Colaborador: 270 / Tipo contrato: INDEFINIDO / Departamento: Administracion Formacion Musical</textarea>
      </p>
        <p>INSTRUCCIONES:</p>
        <p>Por favor siga el ejemplo abajo se&ntilde;alado para reemplazar la informaci&oacute;n con los datos del colaborador que est&aacute; ingresando. LO QUE DEBE CAMBIAR ES LO QUE EST&Aacute; EN ROJO. Puede usar copiar y pegar. </p>
        <p>Si el contrato es indefinido, no cambie el texto de &quot;Fecha termina&quot; </p>
        <p>EJEMPLO:<br />
          <br />
        <span class="Estilo6">APELLIDOS Y NOMBRES</span>  ----  ( cargo: <span class="Estilo6">SEC.CATEG II</span> / Fecha Ingreso: <span class="Estilo6">1996-05-02</span>/ Fecha Termina: <span class="Estilo6">indefinido</span>  / Codigo Colaborador: <span class="Estilo6">270</span> / Tipo contrato:<span class="Estilo6"> INDEFINIDO</span> / Departamento: <span class="Estilo6">Administracion  Formacion Musical</span></p>
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap bgcolor="#FFFFCC">&nbsp;</td>
      <td width="435" bgcolor="#FFFFCC"><input type="submit" value="Insertar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
