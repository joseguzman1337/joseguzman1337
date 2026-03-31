<?php 
session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">

<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
	document.location.href="<?php echo '../matriculas/menu.php';?>";

}
function regresarGET()
{
	document.location.href="<?php echo '../matriculas/menu.php';?>";
}
function enviarmenu()
{
form1.action="";
form1.submit();
}
function enviartarget(){
form1.target='_parent';
}

</script>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/sala_genericas/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../funciones/clases/formulario/globo.js"></script>

<?php
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/motorv2/motor.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
//require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');

echo "<form name=\"form1\" action=\"listadotablagraduadosacuerdo.php\" method=\"post\"  target='_parent' >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

 	$formulario->dibujar_fila_titulo('BUSQUEDA DE LISTADOS DE GRADUANDOS','labelresaltado',"2","align='center'");

	$campo="boton_tipo"; $parametros="'text','nombreacuerdo','".$nombreacuerdo."',''";
	$formulario->dibujar_campo($campo,$parametros,"Nombre Listado","tdtitulogris",'nombreacuerdo','requerido');

	$campo="campo_fecha"; $parametros="'text','fechainicial','".$fechainicial."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
    $formulario->dibujar_campo($campo,$parametros,"Fecha Inicial","tdtitulogris",'fechainicial','requerido');

	$campo="campo_fecha"; $parametros="'text','fechafinal','".$fechafinal."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
    $formulario->dibujar_campo($campo,$parametros,"Fecha Final","tdtitulogris",'fechafinal','requerido');


	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar','onclick=\'enviartarget();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
/* 	
	$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++; 
*/	
 	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');	
?>