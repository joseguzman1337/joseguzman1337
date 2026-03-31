<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);


$rutaado=("../../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/informaciongeneral.php");
require_once(realpath(dirname(__FILE__))."/nucleofamiliar.php");
require_once(realpath(dirname(__FILE__))."/nivelacademico.php");
require_once(realpath(dirname(__FILE__))."/dedicacionexterna.php");
require_once(realpath(dirname(__FILE__))."/contrato.php");
require_once(realpath(dirname(__FILE__))."/estimulo.php");
require_once(realpath(dirname(__FILE__))."/reconocimiento.php");
require_once(realpath(dirname(__FILE__))."/idioma.php");
require_once(realpath(dirname(__FILE__))."/asociacion.php");
require_once(realpath(dirname(__FILE__))."/produccionintelectual.php");
require_once(realpath(dirname(__FILE__))."/escalafon.php");
require_once(realpath(dirname(__FILE__))."/profesion.php");
require_once(realpath(dirname(__FILE__))."/lineainvestigacion.php");
require_once(realpath(dirname(__FILE__))."/capacitacion.php");
require_once(realpath(dirname(__FILE__))."/experiencialaboral.php");
require_once(realpath(dirname(__FILE__))."/actividadlaboral.php");
require_once("participacionuniversitaria.php");
//require_once("dibujaformulario.php");

$formulario=new formulariobaseestudiante($sala,"form1","post","","true");
//,'Los campos marcados con *, no han sido correctamente diligenciados:\n\n',"",false,"../../../../../funciones/sala_genericas/",0

//&$conexion,$nombre,$metodo,$accion="",$validar=false,$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n\n',$archivo_formulario="",$debug=false,$rutaraiz="../../../../",$scriptglobo=1
$formulario->rutaraiz="../../../../../funciones/sala_genericas/";


$objetobase=new BaseDeDatosGeneral($sala);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>

<link rel="stylesheet" type="text/css" href="../../../../../estilos/sala.css">
	<link rel="stylesheet" href="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/css/ajax-tooltip.css" media="screen" type="text/css">
	<link rel="stylesheet" href="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/css/ajax-tooltip-demo.css" media="screen" type="text/css">

<script type="text/javascript" src="../../../../../funciones/sala_genericas/funciones_javascript.js"></script>
	<style type="text/css">
	
	#ajax_tooltipObj .ajax_tooltip_arrow{	/* Left div for the small arrow */
		background-image:url('../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/images/arrow.gif');
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

	<script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax-dynamic-content.js"></script>
	<script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax.js"></script>
	<script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax-tooltip.js"></script>

<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../../funciones/clases/formulario/globo.js"></script>
<title>Servicios Academicos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script LANGUAGE="JavaScript">
	function selaprueba(obj,iditem){
		if(obj.checked==true)
			window.parent.frames[1].cambiaEstadoAprobarImagen(true,iditem);
		else		
			window.parent.frames[1].cambiaEstadoAprobarImagen(false,iditem);
	}	

	function selapruebadocente(obj,iditem){
		if(obj.checked==true)
			window.parent.frames[1].cambiaEstadoRevisaImagen(true,iditem);
		else		
			window.parent.frames[1].cambiaEstadoRevisaImagen(false,iditem);
	}	

</script>

</head>
<body>
<?php
if(!isset($_SESSION["codigofacultad"])||trim($_SESSION["codigofacultad"])==''){
$_SESSION["codigofacultad"]="1";
}
echo "<form name=\"form1\" id=\"form1\" action=\"\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"100%\">";
	
		$usuario=$formulario->datos_usuario();
			$condicion=" and d.codigoestado like '1%'
					and t.tipodocumento=d.tipodocumento
					and g.codigogenero=d.codigogenero
					and e.idestadocivil=d.idestadocivil
					and c1.idciudad=d.idciudadresidencia
					";
			$tablas="documento t,genero g,estadocivil e,ciudad c1,docente d
				left join usuario u on u.numerodocumento=d.numerodocumento and codigotipousuario like '5%'";	
			$resultado=$objetobase->recuperar_resultado_tabla($tablas,"d.iddocente",$_SESSION['sissic_iddocente'],$condicion,",c1.nombreciudad nombreciudadresidencia",0);
			$rowinforgeneral=$resultado->fetchRow();
	
	$condicion=" and d.codigoestado like '1%'";
		echo "<tr><td colspan=4> ";
			muestrainformaciongeneral($objetobase,$formulario);
		echo "</td></tr>";
		echo "<tr><td colspan=4> ";
			nucleofamiliar($objetobase,$formulario);
		echo "</td></tr>";
		echo "<tr><td colspan=4> ";
			contrato($objetobase,$formulario);
		echo "</td></tr>";
		echo "<tr><td colspan=4> ";
			participacionuniversitaria($objetobase,$formulario);
		echo "</td></tr>";
		
		echo "<tr><td colspan=4> ";
			actividadlaboral($objetobase,$formulario);
		echo "</td></tr>";
		echo "<tr><td colspan=4> ";
			lineainvestigacion($objetobase,$formulario);
		echo "</td></tr>";
		echo "<tr><td colspan=4> ";
			nivelacademico($objetobase,$formulario);
		echo "</td></tr>";
		echo "<tr><td colspan=4> ";
			idioma($objetobase,$formulario);
		echo "</td></tr>";
		echo "<tr><td colspan=4> ";
			experiencialaboral($objetobase,$formulario);
		echo "</td></tr>";
		echo "<tr><td colspan=4> ";
			produccionintelectual($objetobase,$formulario);
		echo "</td></tr>";
		echo "<tr><td colspan=4> ";
			estimulo($objetobase,$formulario);
		echo "</td></tr>";
		echo "<tr><td colspan=4> ";
			reconocimiento($objetobase,$formulario);
		echo "</td></tr>";
		echo "<tr><td colspan=4> ";
			asociacion($objetobase,$formulario);
		echo "</td></tr>";

		echo "<tr><td colspan=4> ";

echo " <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

$fila["Firma"]="";
$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
unset($fila);
$fila[]="<center><p onclick='print();'><br><br><br>_______________________________________<br>
".strtoupper($rowinforgeneral["apellidodocente"])." ".strtoupper($rowinforgeneral["nombredocente"])."<br>
".$rowinforgeneral["nombrecortodocumento"].". ".$rowinforgeneral["numerodocumento"]."
<p></center>";
$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
unset($fila);
echo "</table>";
		echo "</td></tr>";
	echo "</table>"; 
echo "</form>"; 
if($_SESSION["codigofacultad"]=="1"){
unset($_SESSION["codigofacultad"]);
}
?>
</body>
</html>
