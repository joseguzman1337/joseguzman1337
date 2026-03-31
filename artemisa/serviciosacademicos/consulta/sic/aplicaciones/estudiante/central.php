<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
$formulario=new formulariobaseestudiante($sala,"form1","post","","true")
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
<?php
if(!isset($_SESSION["codigofacultad"])||trim($_SESSION["codigofacultad"])==""){

echo "<form name=\"form1\" id=\"form1\" action=\"\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\" align='center'>";
$formulario->dibujar_fila_titulo("HOJA DE VIDA ESTUDIANTE",'labelresaltado',"2","align='center'");
$formulario->dibujar_fila_titulo("<B>Apreciado estudiante</B>:<BR><BR>
Por favor diligencie los formularios correspondientes al listado de opciones que aparecen a continuación. Recuerde que debe diligenciar la totalidad del formulario antes de acceder a servicios en línea. Una vez las casillas de verificación aparezcan en color amarillo puede usted continuar utilizando el servicio.
En caso de que la información solicitada no aplique, haga click en aprobar previsualizar y luego marque en la casilla correspondiente para que pueda continuar con el diligenciamiento.
<BR><BR>
Gracias por contribuir con el proceso de autoevaluación institucional",'tdtituloencuestadescripcion',"2","align='left'","td");

echo "</table></form>";
}

?>
  </body>
</html>