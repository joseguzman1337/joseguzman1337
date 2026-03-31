<?php require_once('../Connections/conexion.php'); 

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
  $colname_CListaEmpleados = (get_magic_quotes_gpc()) ? $array : addslashes($array);
}
mysql_select_db($database_conexion, $conexion);
$query_CListaEmpleados = sprintf("SELECT * FROM tlistacol WHERE CCJefeCol = %s ORDER BY NombCol", $colname_CListaEmpleados);
$CListaEmpleados = mysql_query($query_CListaEmpleados, $conexion) or die(mysql_error());
$row_CListaEmpleados = mysql_fetch_assoc($CListaEmpleados);
$totalRows_CListaEmpleados = mysql_num_rows($CListaEmpleados);

$colname_CEvalDesempeno = "-1";
if (isset($array)) {
  $colname_CEvalDesempeno = (get_magic_quotes_gpc()) ? $array : addslashes($array);
}
mysql_select_db($database_conexion, $conexion);
$query_CEvalDesempeno = sprintf("SELECT * FROM tevaldes INNER JOIN tlistacol ON tevaldes.JefCol = tlistacol.JefeCol WHERE tlistacol.CCJefeCol = %s GROUP BY tevaldes.NombCol ORDER BY tevaldes.NombCol", $colname_CEvalDesempeno);
$CEvalDesempeno = mysql_query($query_CEvalDesempeno, $conexion) or die(mysql_error());
$row_CEvalDesempeno = mysql_fetch_assoc($CEvalDesempeno);
$totalRows_CEvalDesempeno = mysql_num_rows($CEvalDesempeno);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lista Colaboradores a evaluar</title>
<link href="../ESTILSOGC.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body>
<div align="center">
  <table width="838" border="0">
    <tr>
      <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
      <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">EVALUACI&Oacute;N DE DESEMPE&Ntilde;O <br />
        COLABORADORES A T&Eacute;RMINO FIJO E INDEFINIDO </div></td>
    </tr>
  </table>
  <table width="838" border="0">
    <tr>
      <td width="832" bgcolor="#FFB112"><div align="center" class="Estilo4">DIRECCI&Oacute;N  DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
    </tr>
  </table>
</div>
<p>&nbsp;</p>
<table border="1" align="center">
  <tr bgcolor="#FFEAFF" class="Estilo24">
    <td class="EtiqYCamposPeq"><div align="center">Nombre Colaborador </div></td>
    <td class="EtiqYCamposPeq"><div align="center">Cargo Colaborador </div></td>
    <td class="EtiqYCamposPeq"><div align="center">Departamento</div></td>
    <td class="EtiqYCamposPeq"><div align="center"></div></td>
  </tr>
  <?php do { ?>
  <tr bgcolor="#FFFFCC" class="Estilo24">
    <td><label>
      <input name="IdColab" type="hidden" value="<?php echo $row_CListaEmpleados['IdColab']; ?>" />
    </label>
      <?php echo $row_CListaEmpleados['NombCol']; ?></td>
    <td><?php echo $row_CListaEmpleados['CarCol']; ?></td>
    <td><?php echo $row_CListaEmpleados['DepCol']; ?></td>
    <td><input name="submit" type="submit" onclick="MM_goToURL('parent','EvalDes.php?NombCol=<?php echo $row_CListaEmpleados['NombCol']; ?>&amp;JefCol=<?php echo $row_CListaEmpleados['JefeCol']; ?>&amp;IdColab=<?php echo $row_CListaEmpleados['IdColab']; ?>&amp;date=<?php echo date('Y-m-d'); ?>&turtle=<?php echo $_GET['turtle']; ?>');return document.MM_returnValue" value="Evaluar" /></td>
  </tr>
  <?php } while ($row_CListaEmpleados = mysql_fetch_assoc($CListaEmpleados)); ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($CListaEmpleados);

mysql_free_result($CEvalDesempeno);
?>
