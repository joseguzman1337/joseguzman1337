<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<form id="form1" name="form1" method="get" action="../datosVotacion.php" target="mainvotacion">
<table width="100%" border="1">
  <tr>
    <td colspan="5"><label>Enviar
        <input type="submit" name="Submit" value="Enviar" />
    </label></td>
    </tr>
  <tr>
    <td width="21%">
      <label>codigoestudiante
        <input type="text" name="codigoestudiante"  value="<?php echo $_SESSION['datosvotante']['codigoestudiante'] ;?>"/>
        </label>    </td>
    <td width="21%"><label>numerodocumento
        <input type="text" name="numerodocumento" value="<?php echo $_SESSION['datosvotante']['numerodocumento'] ;?>"/>
    </label></td>
    <td width="20%"><label>codigocarrera
        <input type="text" name="codigocarrera" value="<?php echo $_SESSION['datosvotante']['codigocarrera'] ;?>" />
    </label></td>
    <td width="19%"><label>tipovotante
        <input type="text" name="tipovotante" value="<?php echo $_SESSION['datosvotante']['tipovotante'] ;?>"/>
    </label></td>
    <td width="19%"><label>idvotacion
        <input type="text" name="idvotacion" value="<?php echo $_SESSION['datosvotante']['idvotacion'] ;?>"/>
    </label></td>
  </tr>
</table>
</form>
</body>
</html>
