<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<frameset rows="280,9%" cols="*" framespacing="0" frameborder="NO" border="0">
  <frame src="resevan1.php" name="topFrame" scrolling="NO" noresize >
  <frame src="resultado14.php" name="mainFrame">
</frameset>
<noframes><body>

</body></noframes>
</html>
