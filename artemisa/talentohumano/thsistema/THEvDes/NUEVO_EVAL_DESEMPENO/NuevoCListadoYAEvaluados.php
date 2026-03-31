<?php require_once('../../Connections/conexion.php'); ?>
<?php //Unserialize 
$array = base64_decode($_GET['turtle']);
//echo $array?>
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
$turtle_CEvaluadosEstrategicos = "-1";
if (isset($array)) {
  $turtle_CEvaluadosEstrategicos = $array;
}
mysql_select_db($database_conexion, $conexion);
$query_CEvaluadosEstrategicos = sprintf("SELECT *, IF(MONTH(FechEval)>10,  YEAR(FechEval), IF(MONTH(FechEval)<4, YEAR(FechEval)-1,YEAR(FechEval))) AS Periodo_evaluacion FROM nuevo_tevaldes_todo_nivel WHERE CCJefeCol=%s  AND RangoCol='Estrategico' ORDER BY NombCol,FechEval", GetSQLValueString($turtle_CEvaluadosEstrategicos, "int"));
$CEvaluadosEstrategicos = mysql_query($query_CEvaluadosEstrategicos, $conexion) or die(mysql_error());
$row_CEvaluadosEstrategicos = mysql_fetch_assoc($CEvaluadosEstrategicos);
$totalRows_CEvaluadosEstrategicos = mysql_num_rows($CEvaluadosEstrategicos);

$turtle_CEvaluadosEstrategicoTacticos = "-1";
if (isset($array)) {
  $turtle_CEvaluadosEstrategicoTacticos = $array;
}
mysql_select_db($database_conexion, $conexion);
$query_CEvaluadosEstrategicoTacticos = sprintf("SELECT *, IF(MONTH(FechEval)>10,  YEAR(FechEval), IF(MONTH(FechEval)<4, YEAR(FechEval)-1,YEAR(FechEval))) AS Periodo_evaluacion FROM nuevo_tevaldes_todo_nivel WHERE CCJefeCol=%s  AND RangoCol='Estrategico-tactico' ORDER BY NombCol,FechEval", GetSQLValueString($turtle_CEvaluadosEstrategicoTacticos, "int"));
$CEvaluadosEstrategicoTacticos = mysql_query($query_CEvaluadosEstrategicoTacticos, $conexion) or die(mysql_error());
$row_CEvaluadosEstrategicoTacticos = mysql_fetch_assoc($CEvaluadosEstrategicoTacticos);
$totalRows_CEvaluadosEstrategicoTacticos = mysql_num_rows($CEvaluadosEstrategicoTacticos);

$turtle_CEvaluadosTacticos = "-1";
if (isset($array)) {
  $turtle_CEvaluadosTacticos = $array;
}
mysql_select_db($database_conexion, $conexion);
$query_CEvaluadosTacticos = sprintf("SELECT *, IF(MONTH(FechEval)>10,  YEAR(FechEval), IF(MONTH(FechEval)<4, YEAR(FechEval)-1,YEAR(FechEval))) AS Periodo_evaluacion FROM nuevo_tevaldes_todo_nivel WHERE CCJefeCol=%s  AND RangoCol='Tactico' ORDER BY NombCol,FechEval", GetSQLValueString($turtle_CEvaluadosTacticos, "int"));
$CEvaluadosTacticos = mysql_query($query_CEvaluadosTacticos, $conexion) or die(mysql_error());
$row_CEvaluadosTacticos = mysql_fetch_assoc($CEvaluadosTacticos);
$totalRows_CEvaluadosTacticos = mysql_num_rows($CEvaluadosTacticos);

$turtle_CEvaluadosOperativos = "-1";
if (isset($array)) {
  $turtle_CEvaluadosOperativos = $array;
}
mysql_select_db($database_conexion, $conexion);
$query_CEvaluadosOperativos = sprintf("SELECT *, IF(MONTH(FechEval)>10,  YEAR(FechEval), IF(MONTH(FechEval)<4, YEAR(FechEval)-1,YEAR(FechEval))) AS Periodo_evaluacion FROM nuevo_tevaldes_todo_nivel WHERE CCJefeCol=%s  AND RangoCol='Operativo' ORDER BY NombCol,FechEval", GetSQLValueString($turtle_CEvaluadosOperativos, "int"));
$CEvaluadosOperativos = mysql_query($query_CEvaluadosOperativos, $conexion) or die(mysql_error());
$row_CEvaluadosOperativos = mysql_fetch_assoc($CEvaluadosOperativos);
$totalRows_CEvaluadosOperativos = mysql_num_rows($CEvaluadosOperativos);

$colname_CListaEmpleados = "-1";
if (isset($array)) {
  $colname_CListaEmpleados = $array;
}
mysql_select_db($database_conexion, $conexion);
$query_CListaEmpleados = sprintf("SELECT * FROM tlistacol WHERE CCJefeCol = %s ORDER BY NombCol", $colname_CListaEmpleados);
$CListaEmpleados = mysql_query($query_CListaEmpleados, $conexion) or die(mysql_error());
$row_CListaEmpleados = mysql_fetch_assoc($CListaEmpleados);
$totalRows_CListaEmpleados = mysql_num_rows($CListaEmpleados);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
<link href="../../ESTILSOGC.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.Estilo43 {color: #FFFFFF}
</style>
<script type="text/javascript">
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>
</head>

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
</div>
<p align="center" class="Estilo28">Estimado(a) Dr.(a) <?php echo $row_CListaEmpleados['JefeCol']; ?></p>
<p align="center" class="Estilo39mediano">LISTADO DE EVALUACIONES YA REALIZADAS</p>
<div align="center"></div>
<table width="329" border="1" align="center" cellpadding="1" cellspacing="1" class="Estilo39" style="border-collapse:collapse">
  <tr>
    <th height="30" scope="col">Evaluar a otro colaborador<br />
      <img src="TRABAJADOR.jpg" width="49" height="49" onclick="MM_goToURL('parent','NuevoCListadoEvaluados.php?turtle=<?php echo $_GET['turtle']; ?>');return document.MM_returnValue" /><br /></th>
  </tr>
</table>
<p align="center" class="Estilo33">&nbsp;</p>
<?php if ($totalRows_CEvaluadosEstrategicos > 0) { // Show if recordset not empty ?>
  <table border="1" align="center">
    <tr>
      <td colspan="4" bgcolor="#7BC142" class="Estilo22"><div align="center">ESTRAT&Eacute;GICOS</div></td>
    </tr>
    <tr bgcolor="#7BC142" class="Estilo22">
      <td bgcolor="#7BC142" class="Estilo22"><div align="center">Colaborador</div></td>
      <td bgcolor="#7BC142"><div align="center">Periodo de evaluaci&oacute;n</div></td>
      <td bgcolor="#7BC142"><div align="center">FechEval</div></td>
      <td bgcolor="#7BC142"><div align="center"></div></td>
    </tr>
    <?php do { ?>
      <tr bgcolor="#FFFFFF" class="Estilo24">
        <td bgcolor="#FFFFFF"><?php echo $row_CEvaluadosEstrategicos['NombCol']; ?></td>
        <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_CEvaluadosEstrategicos['Periodo_evaluacion']; ?></div></td>
        <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_CEvaluadosEstrategicos['FechEval']; ?></div></td>
        <td bgcolor="#FFFFFF"><input name="button" type="submit" class="Estilo39" id="button" onclick="MM_goToURL('parent','Nuevo_EvalDes_VerActualizar_TODO_NIVEL.php?IdColab=<?php echo $row_CEvaluadosEstrategicos['IdColab']; ?>&amp; IdEvalDes=<?php echo $row_CEvaluadosEstrategicos['IdEvalDes']; ?>&amp;turtle=<?php echo $_GET['turtle']; ?>');return document.MM_returnValue" value="Ver/Actualizar" /></td>
      </tr>
      <?php } while ($row_CEvaluadosEstrategicos = mysql_fetch_assoc($CEvaluadosEstrategicos)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
<?php if ($totalRows_CEvaluadosEstrategicoTacticos > 0) { // Show if recordset not empty ?>
  <table border="1" align="center">
    <tr>
      <td colspan="4" bgcolor="#7BC142" class="Estilo22"><div align="center">ESTRAT&Eacute;GICO_T&Aacute;CTICOS</div></td>
    </tr>
    <tr bgcolor="#7BC142" class="Estilo22">
      <td bgcolor="#7BC142" class="Estilo22"><div align="center">Colaborador</div></td>
      <td bgcolor="#7BC142"><div align="center">Periodo de evaluaci&oacute;n</div></td>
      <td bgcolor="#7BC142"><div align="center">FechEval
        
      </div></td>
      <td bgcolor="#7BC142"><div align="center">zsss</div></td>
    </tr>
    <?php do { ?>
      <tr bgcolor="#FFFFFF" class="Estilo24">
        <td bgcolor="#FFFFFF"><?php echo $row_CEvaluadosEstrategicoTacticos['NombCol']; ?></td>
        <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_CEvaluadosEstrategicoTacticos['Periodo_evaluacion']; ?></div></td>
        <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_CEvaluadosEstrategicoTacticos['FechEval']; ?></div></td>
        <td bgcolor="#FFFFFF"><input name="button2" type="submit" class="Estilo39" id="button2" onclick="MM_goToURL('parent','Nuevo_EvalDes_VerActualizar_TODO_NIVEL.php?IdColab=<?php echo $row_CEvaluadosEstrategicoTacticos['IdColab']; ?>&amp; IdEvalDes=<?php echo $row_CEvaluadosEstrategicoTacticos['IdEvalDes']; ?>&amp;turtle=<?php echo $_GET['turtle']; ?>');return document.MM_returnValue" value="Ver/Actualizar" /></td>
      </tr>
      <?php } while ($row_CEvaluadosEstrategicoTacticos = mysql_fetch_assoc($CEvaluadosEstrategicoTacticos)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
<?php if ($totalRows_CEvaluadosTacticos > 0) { // Show if recordset not empty ?>
  <table border="1" align="center">
    <tr>
      <td colspan="4" bgcolor="#7BC142" class="Estilo22"><div align="center">T&Aacute;CTICOS</div></td>
    </tr>
    <tr bgcolor="#7BC142" class="Estilo22">
      <td bgcolor="#7BC142" class="Estilo22"><div align="center">Colaborador</div></td>
      <td bgcolor="#7BC142"><div align="center">Periodo de evaluaci&oacute;n</div></td>
      <td bgcolor="#7BC142"><div align="center">FechEval</div></td>
      <td bgcolor="#7BC142"><div align="center"></div></td>
    </tr>
    <?php do { ?>
      <tr bgcolor="#FFFFFF" class="Estilo24">
        <td bgcolor="#FFFFFF"><?php echo $row_CEvaluadosTacticos['NombCol']; ?></td>
        <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_CEvaluadosTacticos['Periodo_evaluacion']; ?></div></td>
        <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_CEvaluadosTacticos['FechEval']; ?></div></td>
        <td bgcolor="#FFFFFF"><input name="button3" type="submit" class="Estilo39" id="button3" onclick="MM_goToURL('parent','Nuevo_EvalDes_VerActualizar_TODO_NIVEL.php?IdColab=<?php echo $row_CEvaluadosTacticos['IdColab']; ?>&amp; IdEvalDes=<?php echo $row_CEvaluadosTacticos['IdEvalDes']; ?>&amp;turtle=<?php echo $_GET['turtle']; ?>');return document.MM_returnValue" value="Ver/Actualizar" /></td>
      </tr>
      <?php } while ($row_CEvaluadosTacticos = mysql_fetch_assoc($CEvaluadosTacticos)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
<?php if ($totalRows_CEvaluadosOperativos > 0) { // Show if recordset not empty ?>
  <table border="1" align="center">
      <tr>
        <td colspan="4" bgcolor="#7BC142" class="Estilo22"><div align="center">OPERATIVOS</div></td>
      </tr>
      <tr bgcolor="#7BC142" class="Estilo22">
        <td bgcolor="#7BC142" class="Estilo22"><div align="center">Colaborador</div></td>
        <td bgcolor="#7BC142"><div align="center">Periodo de evaluaci&oacute;n</div></td>
        <td bgcolor="#7BC142"><div align="center">FechEval</div></td>
        <td bgcolor="#7BC142"><div align="center"></div></td>
      </tr>
      <?php do { ?>
      <tr bgcolor="#FFFFFF" class="Estilo24">
        <td bgcolor="#FFFFFF"><?php echo $row_CEvaluadosOperativos['NombCol']; ?></td>
        <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_CEvaluadosOperativos['Periodo_evaluacion']; ?></div></td>
        <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_CEvaluadosOperativos['FechEval']; ?></div></td>
        <td bgcolor="#FFFFFF"><input name="button4" type="submit" class="Estilo39" id="button4" onclick="MM_goToURL('parent','Nuevo_EvalDes_VerActualizar_TODO_NIVEL.php?IdColab=<?php echo $row_CEvaluadosOperativos['IdColab']; ?>&amp; IdEvalDes=<?php echo $row_CEvaluadosOperativos['IdEvalDes']; ?>&amp;turtle=<?php echo $_GET['turtle']; ?>');return document.MM_returnValue" value="Ver/Actualizar" /></td>
      </tr>
      <?php } while ($row_CEvaluadosOperativos = mysql_fetch_assoc($CEvaluadosOperativos)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($CEvaluadosEstrategicos);

mysql_free_result($CEvaluadosEstrategicoTacticos);

mysql_free_result($CEvaluadosTacticos);

mysql_free_result($CEvaluadosOperativos);

mysql_free_result($CListaEmpleados);
?>
