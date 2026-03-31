<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_EvalDes = "SELECT * FROM tevaldes GROUP BY NombCol  ORDER BY NombCol ASC";
$EvalDes = mysql_query($query_EvalDes, $conexion) or die(mysql_error());
$row_EvalDes = mysql_fetch_assoc($EvalDes);
$totalRows_EvalDes = mysql_num_rows($EvalDes);
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
</head>

<body>
<table width="838" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">FORMULARIO DE B&Uacute;SQUEDA DE EVALUACI&Oacute;N DESEMPE&Ntilde;O </div></td>
  </tr>
</table>
<table width="841" border="0">
  <tr>
    <td bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<form id="form1" name="form1" method="get" action="EvalDesImprimir.php?IdEvalDes=<?php echo $row_EvalDes['IdEvalDes']; ?>">
  <table width="840" border="1">
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="right">Buscar evaluaci&oacute;n </div></td>
      <td bgcolor="#FFFFCC" class="Estilo4"><label>
        <select name="IdEvalDes" id="IdEvalDes">
          <option value="value">Seleccione el colaborador</option>
          <?php
do {  
?>
          <option value="<?php echo $row_EvalDes['IdEvalDes']?>"><?php echo $row_EvalDes['NombCol']?></option>
          <?php
} while ($row_EvalDes = mysql_fetch_assoc($EvalDes));
  $rows = mysql_num_rows($EvalDes);
  if($rows > 0) {
      mysql_data_seek($EvalDes, 0);
	  $row_EvalDes = mysql_fetch_assoc($EvalDes);
  }
?>
        </select>
      </label></td>
    </tr>
    
    <tr>
      <td colspan="2" bgcolor="#FFFFCC" class="Estilo4"><label>
        <div align="center">
          <input type="submit" name="Submit" value="Enviar" />
          </div>
      </label></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($EvalDes);
?>
