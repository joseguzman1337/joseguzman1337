<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
     
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<p>&nbsp;</p>
<p align="center"><font color="#CC0000" size="7" face="tahoma"> NO APLICA </font></p>
<p>&nbsp; </p>
</body>
</html>
