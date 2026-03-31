<?php
//session_cache_limiter('private');
//session_start();
$rutaado=("../../funciones/adodb/");
//require_once("../../funciones/clases/debug/SADebug.php");
//require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/clases/formulario/clase_formulario.php");
//require_once("../../funciones/validaciones/validaciongenerica.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../funciones/sala_genericas/DatosGenerales.php");
require_once("funciones/FuncionesAportes.php");
$formulario=new formulariobaseestudiante($salad,'form2','post','','true');

?>
<script LANGUAGE="JavaScript">

function quitarFrame()
{
	if (self.parent.frames.length != 0)
	self.parent.location=document.location.href="../../../../aspirantes/aspirantes.php";

}
function regresarGET()
{
	//history.back();
	parent.location.href="<?php echo 'menuinicialaportes.php';?>";
}
//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>
<form name="form1" action="archivoplanoarp.php" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="%100">
	<?php 
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		while (list ($clave, $val) = each ($_POST)) {
					echo"<input type=hidden name='$clave' value='$val'>";;
		}

		$formulario->dibujar_fila_titulo('Ingrese Fecha de Pago','labelresaltado');
		$campo = "campo_fecha"; $parametros ="'text','fechapago','','onKeyUp = \"this.value=formateafecha(this.value);\"'";
		$formulario->dibujar_campo($campo,$parametros,"Fecha de pago","tdtitulogris",'fechapago','requerido');
		$conboton=0;
		$parametrobotonenviar[$conboton]="'submit','Generar','Generar'";
		$boton[$conboton]='boton_tipo';
		//$conboton++;					
		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');

	?>
	  </table>
</form>