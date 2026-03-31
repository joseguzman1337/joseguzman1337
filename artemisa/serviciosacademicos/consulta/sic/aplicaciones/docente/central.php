<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
	<script type="text/javascript">
	function selaprueba(obj,iditem){
		if(obj.checked==true)
			window.parent.frames[1].cambiaEstadoImagen(true,iditem);
		else		
			window.parent.frames[1].cambiaEstadoImagen(false,iditem);
	}	
	</script>
  </head>
  <body>
<h2>Respetado profesor, solicitamos su valiosa colaboraci&oacute;n para actualizar la informaci&oacute;n docente que hace parte del proceso de calidad institucional, esta informaci&oacute;n se solicitar&aacute; una vez cada semestre; para ello debe ingresar a cada opci&oacute;n y actualizarla &oacute; confirmarla. Las opciones marcadas con rojo significan que a&uacute;n no se han verificado o ingresado, el color amarillo indica que la informaci&oacute; ya se revis&oacute;.
<br><br>
Gracias por su colaboraci&oacute;n.</h2>
<?php
?>
  </body>
</html>
