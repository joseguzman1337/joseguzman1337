<?php
session_start();
include_once('../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript">
window.top.location = "../../consulta/facultades/consultafacultadesv2.htm";
</script>
</head>
<body>
</body>
</html>
<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Servicios Académicos</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
</head>
<frameset id="principal" framespacing="1" border="0" frameborder="no" cols="*" rows="100,*" name="principal" onunload="cerrar();">
<frame id="topFrame" scrolling="no" noresize="" src="../../consulta/facultades/encabezadoalt.htm" name="topFrame">
<frameset id="frameMovible" border="0" frameborder="no" scrolling="no" framespacing="0" cols="240,*" rows="*" mane="frameMovible">
<frame id="leftFrame" scrolling="auto" border="0" src="../../consulta/facultades/facultadeslv2.php" name="leftFrame">
<frame id="contenidocentral" scrolling="auto" border="0" frameborder="no" framespacing="0" src="../../consulta/facultades/central.php" name="contenidocentral">
</frameset>
</frameset>
<noframes><body> </body></noframes>
</html>-->