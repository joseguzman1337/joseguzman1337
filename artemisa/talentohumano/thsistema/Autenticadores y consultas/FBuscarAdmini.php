<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_FBuscarAdmini = "SELECT * FROM tautentadmon ORDER BY Nombre ASC";
$FBuscarAdmini = mysql_query($query_FBuscarAdmini, $conexion) or die(mysql_error());
$row_FBuscarAdmini = mysql_fetch_assoc($FBuscarAdmini);
$totalRows_FBuscarAdmini = mysql_num_rows($FBuscarAdmini);
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
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">FORMULARIO DE B&Uacute;SQUEDA DE ADMINISTRADOR </div></td>
  </tr>
</table>
<table width="841" border="0">
  <tr>
    <td bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p class="Estilo4">&nbsp;</p>
<form id="form1" name="form1" method="get" action="FCaInfAdm.php">
  <table width="840" border="1" bgcolor="#FFFFCC">
    <tr>
      <td><label>
        <div align="center">
          <p class="Estilo4">Estimado usuario, por favor busque el administrador que desea modificar<br />
            y luego presione el bot&oacute;n buscar </p>
        </div>
        <div align="center">
          <select name="CCBuscar" id="CCBuscar">
            <option value="value">Escoja el nombre del jefe</option>
            <?php
do {  
?>
            <option value="<?php echo $row_FBuscarAdmini['Nombre']?>"><?php echo $row_FBuscarAdmini['Nombre']?></option><?php
} while ($row_FBuscarAdmini = mysql_fetch_assoc($FBuscarAdmini));
  $rows = mysql_num_rows($FBuscarAdmini);
  if($rows > 0) {
      mysql_data_seek($FBuscarAdmini, 0);
	  $row_FBuscarAdmini = mysql_fetch_assoc($FBuscarAdmini);
  }
?>
          </select>
        </div>
      </label></td>
    </tr>
    <tr>
      <td><label>
        <div align="center">
          <input name="Submit" type="submit" id="Submit" value="Buscar" />
        </div>
      </label></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($FBuscarAdmini);
?>
