<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once("../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
$formulario=new formulariobaseestudiante($sala,"form1","post","","true");
//,'Los campos marcados con *, no han sido correctamente diligenciados:\n\n',"",false,"../../../../../funciones/sala_genericas/",0

//&$conexion,$nombre,$metodo,$accion="",$validar=false,$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n\n',$archivo_formulario="",$debug=false,$rutaraiz="../../../../",$scriptglobo=1
$formulario->rutaraiz="../../../funciones/sala_genericas/";

$objetobase=new BaseDeDatosGeneral($sala);
//$formulario->rutaraiz="../../../funciones/sala_genericas/";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>

<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
	<link rel="stylesheet" href="../../../funciones/sala_genericas/ajax/ajaxtoolltip/css/ajax-tooltip.css" media="screen" type="text/css">
	<link rel="stylesheet" href="../../../funciones/sala_genericas/ajax/ajaxtoolltip/css/ajax-tooltip-demo.css" media="screen" type="text/css">

<script type="text/javascript" src="../../../funciones/sala_genericas/funciones_javascript.js"></script>
	<style type="text/css">

	#ajax_tooltipObj .ajax_tooltip_arrow{	/* Left div for the small arrow */
		background-image:url('../../../funciones/sala_genericas/ajax/ajaxtoolltip/images/arrow.gif');
		width:20px;
		position:absolute;
		left:0px;
		top:0px;
		background-repeat:no-repeat;
		background-position:left;
		z-index:1000005;
		height:60px;
	}
	</style>

	<script type="text/javascript" src="../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax-dynamic-content.js"></script>
	<script type="text/javascript" src="../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax.js"></script>
	<script type="text/javascript" src="../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax-tooltip.js"></script>

<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>

<script LANGUAGE="JavaScript">

function enviarmenu()
{
form1.action="";
form1.submit();
}

</script>
</head>

<body  topmargin="0" leftmargin="0">
<?php
echo "<form name=\"form1\" action=\"tablaestadisticoestudiantenivel.php\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

 	$formulario->dibujar_fila_titulo('ESTADISTICO ESTUDIANTE POR FACULTAD','labelresaltado',"2","align='center'");
	
	
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademicasic f","codigomodalidadacademicasic","nombremodalidadacademicasic","");
	$formulario->filatmp[""]="*Todos*";
	//$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'codigomodalidadacademicasic','".$_POST['codigomodalidadacademicasic']."','onchange=enviarmenu();'";
	$formulario->dibujar_campo($campo,$parametros,"Nivel Academico","tdtitulogris",'codigomodalidadacademicasic','');


	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("areadisciplinar f","codigoareadisciplinar","nombreareadisciplinar","");
	$formulario->filatmp[""]="*Todos*";
	//$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'codigoareadisciplinar','".$_POST['codigoareadisciplinar']."','onchange=enviarmenu();'";
	$formulario->dibujar_campo($campo,$parametros,"	Area Disciplinar","tdtitulogris",'codigoareadisciplinar','');



	//$codigofacultad="05";
	$condicion="c.codigomodalidadacademicasic='".$_POST['codigomodalidadacademicasic']."'
		and c.codigofacultad=f.codigofacultad
		and f.codigoareadisciplinar='".$_POST['codigoareadisciplinar']."'
				and c.codigocarrera <> 13
				and now() between fechainiciocarrera and fechavencimientocarrera
				order by c.nombrecarrera";
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c,facultad f","c.codigocarrera","c.nombrecarrera",$condicion,'',0);
	$formulario->filatmp[""]="*Todos*";
	//$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'codigocarrera','".$_POST['codigocarrera']."','onchange=enviarmenu();'";

	$comentario="";

	$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','',0,"",$comentario);




	$formulario->filatmp["rangoEstrato"]="Estrato";
	$formulario->filatmp["rangoEdad"]="Edad";
	$formulario->filatmp["rangoGenero"]="Genero";
	$formulario->filatmp["rangoNivelEducacion"]="Nivel Educacion";
	$formulario->filatmp["rangoPuestoIcfes"]="Puesto Icfes";
	$formulario->filatmp["rangoNacionalidad"]="Nacionalidad";
	$formulario->filatmp["rangoParticipacionAcademica"]="Participacion Academica";
	$formulario->filatmp["rangoLineaInvestigacion"]="Linea Investigacion";
	$formulario->filatmp["rangoProyeccionSocial"]="Proyeccion Social";
	$formulario->filatmp["rangoParticipacionBienestar"]="Participacion Bienestar";
	$formulario->filatmp["rangoParticipacionGobierno"]="Participacion Gobierno";
	$formulario->filatmp["rangoAsociacion"]="Asociacion";
	$formulario->filatmp["rangoParticipacionGestion"]="Participacion Gestion";
	$formulario->filatmp["rangoReconocimiento"]="Reconocimiento";
	$formulario->filatmp["rangoTipoFinanciacion"]="Tipo Financiacion";
	$formulario->filatmp["rangoEstadoEstudiante"]="Estado Estudiante";
	$formulario->filatmp["historicoEstudiante"]="Historico Estudiante";
	$formulario->filatmp["todos"]="Todos";
	//$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila_multi'; $parametros="'campos','','10'";
	$comentario="Seleccione los campos del formulario que desea visualizar si quiere mas de uno use control y haga la seleccionsi quiere todos de clic en Todos los datos despues de hacer la  seleccion de clic en el boton enviar";

	$formulario->dibujar_campo($campo,$parametros,"Campo del Formulario: ","tdtitulogris",'campos','requerido',0,"",$comentario);


	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar',' onclick=\'enviartarget();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
/* 	$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
 */	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');

echo "</table>";
echo "</form>";


?>

</body>
</html>