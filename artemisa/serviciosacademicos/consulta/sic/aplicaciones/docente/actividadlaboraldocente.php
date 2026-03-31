<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
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
require_once(realpath(dirname(__FILE__))."/tabla.php");
require_once(realpath(dirname(__FILE__))."/dibujaformulario.php");
require_once(realpath(dirname(__FILE__))."/lineainvestigaciondocente.php");
require_once(realpath(dirname(__FILE__))."/menuinvestigaciondocente.php");

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
function enviaractividadlaboral()
{
var formulario=document.getElementById("form1");
formulario.action="actividadlaboraldocente.php?Nuevo_Registro=1&idformulario=<?php echo $_GET["idformulario"]; ?>";
formulario.submit();

}
function enviarfacultad(idformulario,nombreid,id,nuevo)
{
var formulario=document.getElementById("form1");
if(document.getElementById("idgrupoinvestigacion")!=null)
document.getElementById("idgrupoinvestigacion").value='';
if(document.getElementById("idlineainvestigacion")!=null)
document.getElementById("idlineainvestigacion").value='';

formulario.action="actividadlaboraldocente.php?codigotipoactividadlaboral=200&Nuevo_Registro="+nuevo+"&idformulario="+idformulario+"&"+nombreid+"="+id;
formulario.submit();
}
function enviargrupo(idformulario,nombreid,id,nuevo)
{
var formulario=document.getElementById("form1");
if(document.getElementById("idlineainvestigacion")!=null)
document.getElementById("idlineainvestigacion").value='';
formulario.action="actividadlaboraldocente.php?codigotipoactividadlaboral=200&Nuevo_Registro="+nuevo+"&idformulario="+idformulario+"&"+nombreid+"="+id;
formulario.submit();

}
function enviarlinea(idformulario,nombreid,id,nuevo)
{
var formulario=document.getElementById("form1");
formulario.action="actividadlaboraldocente.php?codigotipoactividadlaboral=200&Nuevo_Registro="+nuevo+"&idformulario="+idformulario+"&"+nombreid+"="+id;
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

	/*$condicion=" and d.codigoestado like '1%'
		and r.codigoestado like '1%'
		and r.iddocente=d.iddocente		
		and c.idciudad=r.idciudadreconocimientodocente";
	//and tr.codigotiporeconocimientodocente=r.codigotiporeconocimientodocente
	$resultado=$objetobase->recuperar_resultado_tabla("reconocimientodocente r,docente d,ciudad c","d.iddocente",$_SESSION['sissic_iddocente'],$condicion,"",0);
		$fila["Codigo"]="";
		$fila["Reconocimiento_Otorgado"]="";
		$fila["Tipo_Reconocimiento"]="";
		$fila["Ciudad"]="";
		$fila["Fecha_Reconocimiento"]="";
		

		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
		
	while($row=$resultado->fetchRow()){
		unset($fila);
		$enlacedetalle="<a href='reconocimientodocente.php?idreconocimientodocente=".$row["idreconocimientodocente"]."&idformulario=".$_GET["idformulario"]."'>".$row["idreconocimientodocente"]."</a>";
		$fila[$enlacedetalle]="";
		$fila[$row["otorgareconocimientodocente"]]="";
		$fila[$row["tiporeconocimientodocente"]]="";
		$fila[$row["nombreciudad"]]="";
		$fila[$row["fechareconocimientodocente"]]="";

		$formulario->dibujar_filas_texto($fila,'','',"colspan=4","colspan=4");
		
	}*/	
	
	//echo "<tr><td align='center' colspan='16'><input type='submit' name='Nuevo_Registro' id='Nuevo_Registro' value='Nuevo Registro'/> </td></tr>";

	echo "</table></td><tr>";	


$muestraformulario=0;
if($_REQUEST["Enviar"]){
$muestraformulario=1;
}




if($_REQUEST["Nuevo_Registro"]){
$muestraformulario=1;
//echo "<h1>ENTRO A ANULAR  idestimulodocente ID=".$muestraformulario."</h1>";
	if(isset($_GET["idactividadlaboraldocente"])&&trim($_GET["idactividadlaboraldocente"])!=''){
		unset($_POST);
		unset($_GET["idactividadlaboraldocente"]);
	}

$_REQUEST["Nuevo_Registro"]=1;

}
if(isset($_GET["idactividadlaboraldocente"])&&trim($_GET["idactividadlaboraldocente"])!=''){
$muestraformulario=1;
//echo "<h1>ENTRO A VERIFICAR ID=".$muestraformulario."</h1>";
}
if($datosdedicacionexterna=$objetobase->recuperar_datos_tabla("actividadlaboraldocente","idactividadlaboraldocente",$_GET["idactividadlaboraldocente"],"","",0)){
 if($datosdedicacionexterna["codigoestado"]=="200"){
	$muestraformulario=0;
		//echo "<h1>ENTRO 1 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
	}

}
if($_REQUEST["Anulado"]){
$muestraformulario=0;
//echo "<h1>ENTRO 2 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
}

$nombreidtabla="idactividadlaboraldocente";
$idtablaget=$_GET["idactividadlaboraldocente"];
$idformulario=$_GET["idformulario"];

/*echo "<pre>";
print_r($_GET);
echo "</pre>";
echo "_POST<pre>";
print_r($_POST);
echo "</pre>";*/
	if(isset($_SESSION['codigofacultad'])&&trim($_SESSION['codigofacultad'])!=''){
		$codigocarrera=$_SESSION['codigofacultad'];
	}
	else{
		if(isset($_SESSION['sissic_iddocente'])&&trim($_SESSION['sissic_iddocente'])!='')
			$codigocarrera="1";
	}
	if(isset($_REQUEST["codigotipoactividadlaboral"])&&count($_REQUEST["codigotipoactividadlaboral"])>0){
		$codigotipoactividadlaboral=$_REQUEST["codigotipoactividadlaboral"];
		if($datosactividadlaboraldocente=$objetobase->recuperar_datos_tabla("actividadlaboraldocente t","codigotipoactividadlaboral",$codigotipoactividadlaboral," and iddocente=".$_SESSION['sissic_iddocente']."",'',0)){
			$_GET["idactividadlaboraldocente"]=$datosactividadlaboraldocente["idactividadlaboraldocente"];
		}
		else{
			unset($_POST["numerohorasactividadlaboraldocente"]);
			$tabla="actividadlaboraldocente";
			$fila["iddocente"]=$_SESSION['sissic_iddocente'];
			$fila["codigotipoactividadlaboral"]=$_REQUEST["codigotipoactividadlaboral"];
			$fila["numerohorasactividadlaboraldocente"]="0";
			$fila["codigocarrera"]=$codigocarrera;
			$fila["codigoestado"]="100";
			
			$objetobase->insertar_fila_bd($tabla,$fila,$imprimir,$condicionactualiza);
		}

	}

$muestraformulario=1;

$objdibujaformulario=new DibujaFormulario("actividadlaboraldocente",$_GET["idactividadlaboraldocente"],$sala,$_GET["idformulario"],$formulario);

if($muestraformulario){

	if(isset($_REQUEST["codigotipoactividadlaboral"])&&count($_REQUEST["codigotipoactividadlaboral"])>0){
		$codigotipoactividadlaboral=$_REQUEST["codigotipoactividadlaboral"];
	}
	else{
		$codigotipoactividadlaboral=$objdibujaformulario->recuperarValorCampo("codigotipoactividadlaboral");
	}


	$arrayquitacolumnas[0]="iddocente";
	$arrayquitacolumnas[1]="codigoestado";
	$arrayquitacolumnas[2]="codigotipoactividadlaboral";
	$arrayquitacolumnas[3]="codigocarrera";

	$objdibujaformulario->quitarcolumnas($arrayquitacolumnas);	
	$formulario->boton_tipo("hidden","iddocente",$_SESSION['sissic_iddocente'],"");	
	$formulario->boton_tipo("hidden","codigoestado","100","");
	$formulario->boton_tipo("hidden","codigocarrera",$codigocarrera,"");

	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipoactividadlaboral t","codigotipoactividadlaboral","nombretipoactividadlaboral"," codigoestado like '1%'",'',0);

	$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'codigotipoactividadlaboral','".$codigotipoactividadlaboral."','onchange=enviaractividadlaboral();'";
	$formulario->dibujar_campo($campo,$parametros,"Tipo de Actividad","tdtitulogris",'codigotipoactividadlaboral','requerido');

	if(isset($codigotipoactividadlaboral)&&trim($codigotipoactividadlaboral)!=''){

		$objdibujaformulario->muestraFormulario();
		$objdibujaformulario->columnas[]="iddocente";
		$objdibujaformulario->columnas[]="codigoestado";
		$objdibujaformulario->columnas[]="codigotipoactividadlaboral";
		$objdibujaformulario->columnas[]="codigocarrera";
		if($codigotipoactividadlaboral!="200"){
		$objdibujaformulario->botonesEnvio();
		}
	
		if($codigotipoactividadlaboral=="200"){
			lineainvestigaciondocente($objetobase,$sala);
		}
	
	}
}
/*echo "ingresarModificacion<pre>";
print_r($_POST);
echo "</pre>";*/
if($codigotipoactividadlaboral=="200"){
	if($objdibujaformulario->ingresarModificacion(0,"Enviar")){


	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>	
		window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
	</script>";

	}
}
else{

	if($objdibujaformulario->ingresarNuevo()){


	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>	
		window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
	</script>";

	}

}

	if($objdibujaformulario->ingresarModificacion()){
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>	
		window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
	</script>";

	}


	/*if($objdibujaformulario->ingresarAnulacion()){
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."&Anulado=1'>";
	}*/

echo "</table>"; 
echo "</form>"; 


?>
</body>
</html>