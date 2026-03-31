<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<style type="text/css">
<!--
.Estilo1 {
	font-family: tahoma;
	font-weight: bold;
}
.Estilo2 {
	font-family: tahoma;
	font-size: x-small;
}
-->
</style>
<form name="form1" method="post" action="download.php">
  <div align="center">
    <p class="Estilo1">DESCARGA ARCHIVO CARNETIZACI&Oacute;N </p>
    <p>&nbsp;</p>
    <p class="Estilo2">&nbsp;</p>
    <p class="Estilo2">
    <input type="submit" name="Submit" value="Descargar"></p>
    
  </div>
</form>
