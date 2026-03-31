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
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/tabla.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/dibujaformulario.php");

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
function enviarpais()
{
var formulario=document.getElementById("form1");
if(document.getElementById("iddepartamentonacimiento")!=null)
document.getElementById("iddepartamentonacimiento").value=216;
if(document.getElementById("idciudadnacimiento")!=null)
document.getElementById("idciudadnacimiento").value=2001;

formulario.action="";
formulario.submit();
}
function enviardepartamento()
{
var formulario=document.getElementById("form1");
if(document.getElementById("idciudadnacimiento")!=null)
document.getElementById("idciudadnacimiento").value=2001;
formulario.action="";
formulario.submit();

}
function enviarciudad()
{
var formulario=document.getElementById("form1");
formulario.action="";
formulario.submit();

}
</script>
</head>
<body>
<?php
echo "<form name=\"form1\" id=\"form1\" action=\"\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";


	$usuario=$formulario->datos_usuario();

$condicion=" and codigoestado like '1%'";
	$datosformulario=$objetobase->recuperar_datos_tabla("formulario f","idformulario",$_GET["idformulario"],$condicion,"",0);
	
$formulario->dibujar_fila_titulo(strtoupper($datosformulario["nombreformulario"]),'labelresaltado',"2","align='center'");	

$formulario->dibujar_fila_titulo($datosformulario["descripcionformulario"],'tdtituloencuestadescripcion',"2","align='left'","td");
	echo "<tr><td colspan=4> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

	$condicion=" and d.codigoestado like '1%'
			and d.codigotipoasociacionestudiante=t.codigotipoasociacionestudiante
			order by fechaterminacionasociacionestudiante desc";

	$resultado=$objetobase->recuperar_resultado_tabla("asociacionestudiante d,tipoasociacionestudiante t","d.idestudiantegeneral",$_SESSION['sissic_idestudiantegeneral'],$condicion,"",0);
		$fila["Codigo"]="";
		$fila["Asociaci&oacute;n"]="";
		$fila["Tipo de asociacion"]="";
		$fila["Fecha de inicio en asociaci&oacute;n"]="";
		$fila["Fecha terminación en asociaci&oacute;n"]="";

		

		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
		
	while($row=$resultado->fetchRow()){
		unset($fila);
		$enlacedetalle="<a href='asociacionestudiante.php?idasociacionestudiante=".$row["idasociacionestudiante"]."&idformulario=".$_GET["idformulario"]."'>".$row["idasociacionestudiante"]."</a>";
		$fila[]=$enlacedetalle;
		$fila[]=$row["nombreasociacionestudiante"];
		$fila[]=$row["nombretipoasociacionestudiante"];
		$fila[]=$row["fechaingresoasociacionestudiante"];
		$fila[]=$row["fechaterminacionasociacionestudiante"];

		$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
		$tieneformacion=1;		
	}	
	
	echo "<tr><td align='center' colspan='20'><input type='submit' name='Nuevo_Registro' id='Nuevo_Registro' value='Nuevo Registro'/> </td></tr>";
	if($tieneformacion)
	{
		$mensaje="No registra mas informacion de Paticipacion En Asociaciones Estudiantiles";
	}
	else
	{
		$mensaje="No ha tenido Participacion en Paticipacion En Asociaciones Estudiantiles";
	}
	echo "<tr><td align='center' colspan='20'><input type='submit' name='No_Aplica' id='No_Aplica' value='".$mensaje."'/> </td></tr>";
	echo "</table></td><tr>";	


$muestraformulario=0;
if($_REQUEST["Enviar"]){
$muestraformulario=1;
}


if($_REQUEST["Nuevo_Registro"]){
$muestraformulario=1;
//echo "<h1>ENTRO A ANULAR  idestimulodocente ID=".$muestraformulario."</h1>";

	if(isset($_GET["idasociacionestudiante"])&&trim($_GET["idasociacionestudiante"])!=''){
		unset($_POST);
		unset($_GET["idasociacionestudiante"]);
	}

$_REQUEST["Anulado"]=0;
$_REQUEST["Nuevo_Registro"]=1;
}

if(isset($_GET["idasociacionestudiante"])&&trim($_GET["idasociacionestudiante"])!=''){
$muestraformulario=1;
//echo "<h1>ENTRO A VERIFICAR ID=".$muestraformulario."</h1>";
}
if($datosdedicacionexterna=$objetobase->recuperar_datos_tabla("asociacionestudiante","idasociacionestudiante",$_GET["idasociacionestudiante"],"","",0)){
 if($datosdedicacionexterna["codigoestado"]=="200"){
	$muestraformulario=0;
		//echo "<h1>ENTRO 1 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
	}

}
if($_REQUEST["Anulado"]){
$muestraformulario=0;
//echo "<h1>ENTRO 2 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
}


$objdibujaformulario=new DibujaFormulario("asociacionestudiante",$_GET["idasociacionestudiante"],$sala,$_GET["idformulario"],$formulario);

if($muestraformulario){

	$arrayquitacolumnas[0]="idestudiantegeneral";
	$arrayquitacolumnas[1]="codigoestado";
	$objdibujaformulario->quitarcolumnas($arrayquitacolumnas);	
	$formulario->boton_tipo("hidden","idestudiantegeneral",$_SESSION['sissic_idestudiantegeneral'],"");	
	$formulario->boton_tipo("hidden","codigoestado","100","");
	$objdibujaformulario->muestraFormulario();
	$objdibujaformulario->columnas[]="idestudiantegeneral";
	$objdibujaformulario->columnas[]="codigoestado";
	$objdibujaformulario->botonesEnvio();
}

	if(isset($_REQUEST["No_Aplica"])){
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>	
		window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
	</script>";

	}

	if($objdibujaformulario->ingresarModificacion()){
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>	
		window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
	</script>";

	}

	if($objdibujaformulario->ingresarNuevo()){
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>	
		window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
	</script>";
	}

	if($objdibujaformulario->ingresarAnulacion()){
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."&Anulado=1'>";
	}

echo "</table>"; 
echo "</form>"; 
?>
</body>
</html>