<?php require_once('../../Connections/conexion.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "NuevoFIngresoAEvaluaciones.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}

// Establecer la zona horaria predeterminada a usar. Disponible desde PHP 5.1
date_default_timezone_set('America/Bogota');?>
<?php

//Unserialize 
$array = base64_decode($_GET['turtle']);

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


$colname_CListaEmpleados = "-1";
if (isset($array)) {
  $colname_CListaEmpleados = $array;
}
mysql_select_db($database_conexion, $conexion);
$query_CListaEmpleados = sprintf("SELECT * FROM tlistacol WHERE CCJefeCol = %s ORDER BY NombCol", GetSQLValueString($colname_CListaEmpleados, "text"));
$CListaEmpleados = mysql_query($query_CListaEmpleados, $conexion) or die(mysql_error());
$row_CListaEmpleados = mysql_fetch_assoc($CListaEmpleados);
$totalRows_CListaEmpleados = mysql_num_rows($CListaEmpleados);

$colname_CEvalDesempeno = "-1";
if (isset($array)) {
  $colname_CEvalDesempeno = (get_magic_quotes_gpc()) ? $array : addslashes($array);
}
mysql_select_db($database_conexion, $conexion);
$query_CEvalDesempeno = sprintf("SELECT * FROM nuevo_tevaldes_todo_nivel INNER JOIN tlistacol ON nuevo_tevaldes_todo_nivel.JefCol = tlistacol.JefeCol WHERE tlistacol.CCJefeCol = %s GROUP BY nuevo_tevaldes_todo_nivel.NombCol ORDER BY nuevo_tevaldes_todo_nivel.NombCol", $colname_CEvalDesempeno);
$CEvalDesempeno = mysql_query($query_CEvalDesempeno, $conexion) or die(mysql_error());
$row_CEvalDesempeno = mysql_fetch_assoc($CEvalDesempeno);
$totalRows_CEvalDesempeno = mysql_num_rows($CEvalDesempeno);

$colname_CListaEmpleadosOperativos = "-1";
if (isset($array)) {
  $colname_CListaEmpleadosOperativos = (get_magic_quotes_gpc()) ? $array : addslashes($array);
}
mysql_select_db($database_conexion, $conexion);
$query_CListaEmpleadosOperativos = sprintf("SELECT * FROM tlistacol WHERE CCJefeCol = %s AND RangoCol= 'OPERATIVO' ORDER BY NombCol", $colname_CListaEmpleadosOperativos);
$CListaEmpleadosOperativos = mysql_query($query_CListaEmpleadosOperativos, $conexion) or die(mysql_error());
$row_CListaEmpleadosOperativos = mysql_fetch_assoc($CListaEmpleadosOperativos);
$totalRows_CListaEmpleadosOperativos = mysql_num_rows($CListaEmpleadosOperativos);

$colname_CListaEmpleadosTacticos = "-1";
if (isset($array)) {
  $colname_CListaEmpleadosTacticos = (get_magic_quotes_gpc()) ? $array : addslashes($array);
}
mysql_select_db($database_conexion, $conexion);
$query_CListaEmpleadosTacticos = sprintf("SELECT * FROM tlistacol WHERE CCJefeCol = %s AND RangoCol= 'TACTICO' ORDER BY NombCol", $colname_CListaEmpleadosTacticos);
$CListaEmpleadosTacticos = mysql_query($query_CListaEmpleadosTacticos, $conexion) or die(mysql_error());
$row_CListaEmpleadosTacticos = mysql_fetch_assoc($CListaEmpleadosTacticos);
$totalRows_CListaEmpleadosTacticos = mysql_num_rows($CListaEmpleadosTacticos);

$colname_CListaEmpleadosEstrategicos = "-1";
if (isset($array)) {
  $colname_CListaEmpleadosEstrategicos = $array;
}
mysql_select_db($database_conexion, $conexion);
$query_CListaEmpleadosEstrategicos = sprintf("SELECT * FROM tlistacol WHERE CCJefeCol = %s AND RangoCol= 'ESTRATEGICO' ORDER BY NombCol", GetSQLValueString($colname_CListaEmpleadosEstrategicos, "double"));
$CListaEmpleadosEstrategicos = mysql_query($query_CListaEmpleadosEstrategicos, $conexion) or die(mysql_error());
$row_CListaEmpleadosEstrategicos = mysql_fetch_assoc($CListaEmpleadosEstrategicos);
$totalRows_CListaEmpleadosEstrategicos = mysql_num_rows($CListaEmpleadosEstrategicos);

$colname_CListaEmpleadosEstrategicoTacticos = "-1";
if (isset($array)) {
  $colname_CListaEmpleadosEstrategicoTacticos = (get_magic_quotes_gpc()) ? $array : addslashes($array);
}
mysql_select_db($database_conexion, $conexion);
$query_CListaEmpleadosEstrategicoTacticos = sprintf("SELECT * FROM tlistacol WHERE CCJefeCol = %s AND RangoCol= 'Estrategico-tactico' ORDER BY NombCol", $colname_CListaEmpleadosEstrategicoTacticos);
$CListaEmpleadosEstrategicoTacticos = mysql_query($query_CListaEmpleadosEstrategicoTacticos, $conexion) or die(mysql_error());
$row_CListaEmpleadosEstrategicoTacticos = mysql_fetch_assoc($CListaEmpleadosEstrategicoTacticos);
$totalRows_CListaEmpleadosEstrategicoTacticos = mysql_num_rows($CListaEmpleadosEstrategicoTacticos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lista Colaboradores a evaluar</title>
<link href="../../ESTILSOGC.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<style type="text/css">
<!--
body {
	background-image: url();
	background-repeat: no-repeat;
	background-color: #F9FCF5;
}
.Estilo43 {color: #FFFFFF}
.Estilo44 {font-weight: bold; font-family: Tahoma;}
.Estilo45 {font-weight: bold; font-size: 18px; font-family: Tahoma;}
-->
</style></head>

<body>
<div align="center">
  <table width="838" border="0">
    <tr>
      <td width="155" height="72" bgcolor="#7BC142"><div align="center" class="Estilo22"><img src="../../IMAGENES/BOSQUEDPTOTH2.png" alt="as" width="250" height="97" /></div></td>
      <td width="673" bgcolor="#7BC142"><div align="center" class="Estilo4 Estilo43">EVALUACI&Oacute;N PARA EL DESARROLLO<br />
      COLABORADORES A T&Eacute;RMINO FIJO E INDEFINIDO </div></td>
    </tr>
  </table>
  <table width="838" border="0">
    <tr>
      <td width="832" bgcolor="#8CC63F"><div align="center" class="Estilo4 Estilo43">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
    </tr>
  </table>
  <br />
</div>
<table width="329" border="1" align="center" cellpadding="1" cellspacing="1" class="Estilo39" style="border-collapse:collapse">
  <tr>
    <th height="30" scope="col">Ver colaboradores  evaluados<br />
      <img src="EVALUADOS.jpg" width="49" height="49" onclick="MM_goToURL('parent','NuevoCListadoYAEvaluados.php?turtle=<?php echo $_GET['turtle']; ?>');return document.MM_returnValue" /><br /></th>
  </tr>
</table>
<p align="center">&nbsp;</p>
<p align="center"><span class="Estilo39mediano">Estimado(a) Dr.(a) <?php echo $row_CListaEmpleados['JefeCol']; ?></span></p>
<div align="center">
  <p><span class="Estilo28">LISTADO DE COLABORADORES A SU CARGO</span><br />
    </p>
  <?php if ($totalRows_CListaEmpleadosEstrategicos > 0) { // Show if recordset not empty ?>
    <table border="1" align="center" bordercolor="#003300" style="border-collapse:collapse">
      <tr bgcolor="#FFEAFF" class="Estilo24">
        <td colspan="4" bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo28 Estilo43"><span class="Estilo44">ESTRAT&Eacute;GICOS</span></div></td>
      </tr>
      <tr bgcolor="#FFEAFF" class="Estilo24">
        <td bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43">Nombre Colaborador</div></td>
        <td bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43">Cargo Colaborador </div></td>
        <td bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43">Departamento</div></td>
        <td bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center"><span class="Estilo43"></span></div></td>
      </tr>
      <?php do { ?>
        <tr bgcolor="#FFFFCC" class="Estilo24">
          <td align="left" bgcolor="#FFFFFF"><label>
            <div align="left">
              <input name="IdColab" type="hidden" value="<?php echo $row_CListaEmpleadosEstrategicos['IdColab']; ?>" />
            </div>
            </label>
          <?php echo $row_CListaEmpleadosEstrategicos['NombCol']; ?></td>
          <td align="left" bgcolor="#FFFFFF"><?php echo $row_CListaEmpleadosEstrategicos['CarCol']; ?></td>
          <td align="left" bgcolor="#FFFFFF"><?php echo $row_CListaEmpleadosEstrategicos['DepCol']; ?></td>
          <td align="center" bgcolor="#FFFFFF"><input name="submit2222" type="submit" class="Estilo39" onclick="MM_goToURL('parent','Nuevo_EvalDes_TODO_NIVEL.php?NombCol=<?php echo $row_CListaEmpleadosEstrategicos['NombCol']; ?>&amp;JefCol=<?php echo $row_CListaEmpleadosEstrategicos['JefeCol']; ?>&amp;IdColab=<?php echo $row_CListaEmpleadosEstrategicos['IdColab']; ?>&amp;date=<?php echo date('Y-m-d'); ?>&amp;Periodo=<?php if(date('n') <= 3) { echo date('Y')-1; } else { echo date('Y'); }?>&amp;turtle=<?php echo $_GET['turtle']; ?>&amp;RangoCol=<?php echo $row_CListaEmpleadosEstrategicos['RangoCol']; ?>&amp;CarCol=<?php echo $row_CListaEmpleadosEstrategicos['CarCol']; ?>&amp;CargoJefeCol=<?php echo $row_CListaEmpleadosEstrategicos['CargoJefeCol']; ?>&amp;DepCol=<?php echo $row_CListaEmpleadosEstrategicos['DepCol']; ?>');return document.MM_returnValue" value="Evaluar" /></td>
        </tr>
        <?php } while ($row_CListaEmpleadosEstrategicos = mysql_fetch_assoc($CListaEmpleadosEstrategicos)); ?>
    </table>
    <br />
    <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_CListaEmpleadosEstrategicoTacticos > 0) { // Show if recordset not empty ?>
    <table border="1" align="center" bordercolor="#003300" style="border-collapse:collapse">
      <tr bgcolor="#FFEAFF" class="Estilo24">
        <td colspan="4" bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43"><span class="Estilo45">ESTRAT&Eacute;GICO-T&Aacute;CTICOS</span></div></td>
      </tr>
      <tr bgcolor="#FFEAFF" class="Estilo24">
        <td bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43">Nombre Colaborador </div></td>
        <td bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43">Cargo Colaborador </div></td>
        <td bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43">Departamento</div></td>
        <td bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center"><span class="Estilo43"></span></div></td>
      </tr>
      <?php do { ?>
        <tr bgcolor="#FFFFCC" class="Estilo24">
          <td height="37" align="left" bgcolor="#FFFFFF"><label>
            <input name="IdColab2" type="hidden" value="<?php echo $row_CListaEmpleadosEstrategicoTacticos['IdColab']; ?>" />
          <div align="left"><?php echo $row_CListaEmpleadosEstrategicoTacticos['NombCol']; ?></div></td>
          <td align="left" bgcolor="#FFFFFF"><?php echo $row_CListaEmpleadosEstrategicoTacticos['CarCol']; ?></td>
          <td align="left" bgcolor="#FFFFFF"><?php echo $row_CListaEmpleadosEstrategicoTacticos['DepCol']; ?></td>
          <td align="center" bgcolor="#FFFFFF"><input name="submit" type="submit" class="Estilo39" onclick="MM_goToURL('parent','Nuevo_EvalDes_TODO_NIVEL.php?NombCol=<?php echo $row_CListaEmpleadosEstrategicoTacticos['NombCol']; ?>&amp;JefCol=<?php echo $row_CListaEmpleadosEstrategicoTacticos['JefeCol']; ?>&amp;IdColab=<?php echo $row_CListaEmpleadosEstrategicoTacticos['IdColab']; ?>&amp;date=<?php echo date('Y-m-d'); ?>&amp;Periodo=<?php if(date('n') <= 3) { echo date('Y')-1; } else { echo date('Y'); }?>&amp;turtle=<?php echo $_GET['turtle']; ?>&amp;RangoCol=<?php echo $row_CListaEmpleadosEstrategicoTacticos['RangoCol']; ?>&amp;CarCol=<?php echo $row_CListaEmpleadosEstrategicoTacticos['CarCol']; ?>&amp;CargoJefeCol=<?php echo $row_CListaEmpleadosEstrategicoTacticos['CargoJefeCol']; ?>&amp;DepCol=<?php echo $row_CListaEmpleadosEstrategicoTacticos['DepCol']; ?>');return document.MM_returnValue" value="Evaluar" /></td>
        </tr>
        <?php } while ($row_CListaEmpleadosEstrategicoTacticos = mysql_fetch_assoc($CListaEmpleadosEstrategicoTacticos)); ?>
    </table>
    <?php } // Show if recordset not empty ?>
  <br />
  <?php if ($totalRows_CListaEmpleadosTacticos > 0) { // Show if recordset not empty ?>
    <table border="1" align="center" bordercolor="#003300" style="border-collapse:collapse">
      <tr bgcolor="#FFEAFF" class="Estilo24">
        <td colspan="4" bordercolor="#0000FF" bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43"><span class="Estilo45">T&Aacute;CTICOS</span></div></td>
      </tr>
      <tr bgcolor="#FFEAFF" class="Estilo24">
        <td bordercolor="#0000FF" bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43">Nombre Colaborador </div></td>
        <td bordercolor="#0000FF" bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43">Cargo Colaborador </div></td>
        <td bordercolor="#0000FF" bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43">Departamento</div></td>
        <td bordercolor="#0000FF" bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center"><span class="Estilo43"></span></div></td>
      </tr>
      <?php do { ?>
        <tr bgcolor="#FFFFCC" class="Estilo24">
          <td bordercolor="#0000FF" bgcolor="#FFFFFF"><label>
            <div align="left">
              <input name="IdColab" type="hidden" value="<?php echo $row_CListaEmpleadosTacticos['IdColab']; ?>" />
              <input name="RangoCol" type="hidden" value="<?php echo $row_CListaEmpleadosTacticos['RangoCol']; ?>" />
            <?php echo $row_CListaEmpleadosTacticos['NombCol']; ?></div>
          </label></td>
          <td align="left" bordercolor="#0000FF" bgcolor="#FFFFFF"><?php echo $row_CListaEmpleadosTacticos['CarCol']; ?></td>
          <td align="left" bordercolor="#0000FF" bgcolor="#FFFFFF"><?php echo $row_CListaEmpleadosTacticos['DepCol']; ?></td>
          <td align="center" bordercolor="#0000FF" bgcolor="#FFFFFF"><input name="submit22" type="submit" class="Estilo39" onclick="MM_goToURL('parent','Nuevo_EvalDes_TODO_NIVEL.php?NombCol=<?php echo $row_CListaEmpleadosTacticos['NombCol']; ?>&amp;JefCol=<?php echo $row_CListaEmpleadosTacticos['JefeCol']; ?>&amp;IdColab=<?php echo $row_CListaEmpleadosTacticos['IdColab']; ?>&amp;date=<?php echo date('Y-m-d'); ?>&amp;Periodo=<?php if(date('n') <= 3) { echo date('Y')-1; } else { echo date('Y'); }?>&amp;turtle=<?php echo $_GET['turtle']; ?>&amp;RangoCol=<?php echo $row_CListaEmpleadosTacticos['RangoCol']; ?>&amp;CarCol=<?php echo $row_CListaEmpleadosTacticos['CarCol']; ?>&amp;CargoJefeCol=<?php echo $row_CListaEmpleadosTacticos['CargoJefeCol']; ?>&amp;DepCol=<?php echo $row_CListaEmpleadosTacticos['DepCol']; ?>');return document.MM_returnValue" value="Evaluar" /></td>
        </tr>
        <?php } while ($row_CListaEmpleadosTacticos = mysql_fetch_assoc($CListaEmpleadosTacticos)); ?>
    </table>
    <?php } // Show if recordset not empty ?>
  <br />
  <?php if ($totalRows_CListaEmpleadosOperativos > 0) { // Show if recordset not empty ?>
    <table border="1" align="center" bordercolor="#003300" style="border-collapse:collapse">
      <tr bgcolor="#FFEAFF" class="Estilo24">
        <td colspan="4" bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43"><span class="Estilo28 Estilo43">OPERATIVOS</span></div></td>
      </tr>
      <tr bgcolor="#FFEAFF" class="Estilo24">
        <td bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43">Nombre Colaborador </div></td>
        <td bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43">Cargo Colaborador </div></td>
        <td bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center" class="Estilo43">Departamento</div></td>
        <td bgcolor="#7BC142" class="EtiqYCamposPeq"><div align="center"><span class="Estilo43"></span></div></td>
      </tr>
      <?php do { ?>
        <tr bgcolor="#FFFFCC" class="Estilo24">
          <td bgcolor="#FFFFFF"><label>
            </label>
            <div align="left">
              <div align="right">
                <input name="IdColab3" type="hidden" value="<?php echo $row_CListaEmpleadosOperativos['IdColab']; ?>" />
              </div>
          <?php echo $row_CListaEmpleadosOperativos['NombCol']; ?></div></td>
          <td align="left" bgcolor="#FFFFFF"><?php echo $row_CListaEmpleadosOperativos['CarCol']; ?></td>
          <td align="left" bgcolor="#FFFFFF"><?php echo $row_CListaEmpleadosOperativos['DepCol']; ?></td>
          <td bgcolor="#FFFFFF"><input name="submit2" type="submit" class="Estilo39" onclick="MM_goToURL('parent','Nuevo_EvalDes_TODO_NIVEL.php?NombCol=<?php echo $row_CListaEmpleadosOperativos['NombCol']; ?>&amp;JefCol=<?php echo $row_CListaEmpleadosOperativos['JefeCol']; ?>&amp;IdColab=<?php echo $row_CListaEmpleadosOperativos['IdColab']; ?>&amp;date=<?php echo date('Y-m-d'); ?>&amp;Periodo=<?php if(date('n') <= 3) { echo date('Y')-1; } else { echo date('Y'); }?>&amp;turtle=<?php echo $_GET['turtle']; ?>&amp;RangoCol=<?php echo $row_CListaEmpleadosOperativos['RangoCol']; ?>&amp;CarCol=<?php echo $row_CListaEmpleadosOperativos['CarCol']; ?>&amp;CargoJefeCol=<?php echo $row_CListaEmpleadosOperativos['CargoJefeCol']; ?>&amp;DepCol=<?php echo $row_CListaEmpleadosOperativos['DepCol']; ?>');return document.MM_returnValue" value="Evaluar" /></td>
        </tr>
        <?php } while ($row_CListaEmpleadosOperativos = mysql_fetch_assoc($CListaEmpleadosOperativos)); ?>
    </table>
    <?php } // Show if recordset not empty ?>
</div>
<br />
<p></p>
</body>
</html>
<?php
mysql_free_result($CListaEmpleados);

mysql_free_result($CEvalDesempeno);

mysql_free_result($CListaEmpleadosOperativos);

mysql_free_result($CListaEmpleadosTacticos);

mysql_free_result($CListaEmpleadosEstrategicos);

mysql_free_result($CListaEmpleadosEstrategicoTacticos);
?>
