<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<div style="width:100%"><div style="width:518px; float:left"><img src="../../../../imagenes/confirmaimpresion.gif" width="518" height="500">
  <br>
  <input name="Aceptar" type="submit" id="Aceptar" value="Certifico" onClick="window.open('factura.php<?php echo "?numeroordenpago=".$_GET['numeroordenpago']."&codigoestudiante=".$_GET['codigoestudiante']."&codigoperiodo=".$_GET['codigoperiodo']."&documentoingreso=".$row_seldocumento['numerodocumento']."";?>','factura','width=800,height=800,left=10,top=10,sizeable=yes,scrollbars=no');window.close()" style="color:#FF0033 ">
  <input name="Cancelar" type="submit" id="Cancelar" value="No certifico" onClick="window.close()" style="color:#FF0033">
</div>
<div style="float:left; padding-left: 10px;"><img src="../../../../imagenes/popup_landing-fundraising.jpg"></div>
</div>
</body>
</html>
