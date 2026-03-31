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
//require_once("gobiernouniversitario.php");

$formulario=new formulariobaseestudiante($sala,"form1","post","","true");
//,'Los campos marcados con *, no han sido correctamente diligenciados:\n\n',"",false,"../../../../../funciones/sala_genericas/",0

//&$conexion,$nombre,$metodo,$accion="",$validar=false,$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n\n',$archivo_formulario="",$debug=false,$rutaraiz="../../../../",$scriptglobo=1
$formulario->rutaraiz="../../../../../funciones/sala_genericas/";


$objetobase=new BaseDeDatosGeneral($sala);
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/

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
<script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/requestxml.js"></script>

<title>Servicios Academicos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script LANGUAGE="JavaScript">
function enviarparticipacionuniversitaria()
{
var formulario=document.getElementById("form1");
formulario.action="participaciongobiernoestudiante.php?Nuevo_Registro=1&idformulario=<?php echo $_GET["idformulario"]; ?>";
formulario.submit();

}
function cambiaEstadoParticipacion(){
window.parent.frames[1].cambiaEstadoImagen(true,"<?php  echo $_GET["idformulario"] ?>");
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
/*if($_REQUEST["codigotipoparticipaciongobiernoestudiante"]=="400")
$formulario->dibujar_fila_titulo("INDICACION: Seleccione de la lista a las que pertenece",'tdtituloencuestadescripcion',"2","align='left'","td");*/

	echo "<tr><td colspan=4> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

	$condicion=" and d.codigoestado like '1%'
			and d.codigotipoparticipaciongobiernoestudiante=tp.codigotipoparticipaciongobiernoestudiante";

	$resultado=$objetobase->recuperar_resultado_tabla("participaciongobiernoestudiante d,tipoparticipaciongobiernoestudiante tp ","d.idestudiantegeneral",$_SESSION['sissic_idestudiantegeneral'],$condicion,"",0);
		$fila["Codigo"]="";
		$fila["Tipo de Participación"]="";
		$fila["Fecha de inicio Participación"]="";
		//$fila["Fecha terminaci&oacute;n en escalafon"]="";

		

		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
		unset($fila);
	while($row=$resultado->fetchRow()){
		unset($fila);
		$enlacedetalle="<a href='participaciongobiernoestudiante.php?idparticipaciongobiernoestudiante=".$row["idparticipaciongobiernoestudiante"]."&idformulario=".$_GET["idformulario"]."'>".$row["idparticipaciongobiernoestudiante"]."</a>";
		$fila[]=$enlacedetalle;
		$fila[]=$row["nombretipoparticipaciongobiernoestudiante"];				$fila[]=$row["fechainicioparticipaciongobiernoestudiante"];
		//$fila[]=$row["fechafinalizacionescalafondocente"];

		$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
		
	}	
	unset($fila);
	echo "<tr><td align='center' colspan='16'><input type='submit' name='Nuevo_Registro' id='Nuevo_Registro' value='Nuevo Registro'/> </td></tr>";

	echo "</table></td><tr>";	


$muestraformulario=0;
if($_REQUEST["Enviar"]){
$muestraformulario=1;
}


if($_REQUEST["Nuevo_Registro"]){
$muestraformulario=1;
//echo "<h1>ENTRO A ANULAR  idestimulodocente ID=".$muestraformulario."</h1>";

	if(isset($_GET["idparticipaciongobiernoestudiante"])&&trim($_GET["idparticipaciongobiernoestudiante"])!=''){
		unset($_POST);
		unset($_GET["idparticipaciongobiernoestudiante"]);
	}

$_REQUEST["Anulado"]=0;
$_REQUEST["Nuevo_Registro"]=1;
}

if(isset($_GET["idparticipaciongobiernoestudiante"])&&trim($_GET["idparticipaciongobiernoestudiante"])!=''){
$muestraformulario=1;
//echo "<h1>ENTRO A VERIFICAR ID=".$muestraformulario."</h1>";
}
if($datosdedicacionexterna=$objetobase->recuperar_datos_tabla("participaciongobiernoestudiante","idparticipaciongobiernoestudiante",$_GET["idparticipaciongobiernoestudiante"],"","",0)){
 if($datosdedicacionexterna["codigoestado"]=="200"){
	$muestraformulario=0;
		//echo "<h1>ENTRO 1 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
	}

}
if($_REQUEST["Anulado"]){
$muestraformulario=0;
//echo "<h1>ENTRO 2 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
}

	/*if(isset($_REQUEST["codigotipoparticipaciongobiernoestudiante"])&&count($_REQUEST["codigotipoparticipaciongobiernoestudiante"])>0){
		$codigotipoparticipaciongobiernoestudiante=$_REQUEST["codigotipoparticipaciongobiernoestudiante"];
		if($datosparticipacion=$objetobase->recuperar_datos_tabla("participaciongobiernoestudiante t","codigotipoparticipaciongobiernoestudiante",$codigotipoparticipaciongobiernoestudiante," and idestudiantegeneral=".$_SESSION['sissic_idestudiantegeneral']."",'',0)){
			$_GET["idparticipaciongobiernoestudiante"]=$datosparticipacion["idparticipaciongobiernoestudiante"];
		}
		else{
			if(trim($_REQUEST["codigotipoparticipaciongobiernoestudiante"])!=''){
				unset($_POST["nombreparticipaciongobiernoestudiante"]);
				$tabla="participaciongobiernoestudiante";
				$fila["idestudiantegeneral"]=$_SESSION['sissic_idestudiantegeneral'];
				//$fila["codigotipoconsejouniversidad"]="400";
				$fila["codigotipoparticipaciongobiernoestudiante"]=$_REQUEST["codigotipoparticipaciongobiernoestudiante"];
				$fila["nombreparticipaciongobiernoestudiante"]="";
				$fila["codigoestado"]="100";
				
				$objetobase->insertar_fila_bd($tabla,$fila,$imprimir,$condicionactualiza);
				
				$datosparticipacion=$objetobase->recuperar_datos_tabla("participaciongobiernoestudiante t","codigotipoparticipaciongobiernoestudiante",$codigotipoparticipaciongobiernoestudiante," and idestudiantegeneral=".$_SESSION['sissic_idestudiantegeneral']."",'',0);
				$_GET["idparticipaciongobiernoestudiante"]=$datosparticipacion["idparticipaciongobiernoestudiante"];
			}
		}

	}*/
//$muestraformulario=1;
$objdibujaformulario=new DibujaFormulario("participaciongobiernoestudiante",$_GET["idparticipaciongobiernoestudiante"],$sala,$_GET["idformulario"],$formulario);

if($muestraformulario){

	if(isset($_REQUEST["codigotipoparticipaciongobiernoestudiante"])&&count($_REQUEST["codigotipoparticipaciongobiernoestudiante"])>0){
		$codigotipoparticipaciongobiernoestudiante=$_REQUEST["codigotipoparticipaciongobiernoestudiante"];
	}
	else{
		$codigotipoparticipaciongobiernoestudiante=$objdibujaformulario->recuperarValorCampo("codigotipoparticipaciongobiernoestudiante");
	}


	$arrayquitacolumnas[0]="idestudiantegeneral";
	$arrayquitacolumnas[1]="codigoestado";
	//$arrayquitacolumnas[2]="codigotipoconsejouniversidad";
	$arrayquitacolumnas[3]="codigotipoparticipaciongobiernoestudiante";

	$objdibujaformulario->quitarcolumnas($arrayquitacolumnas);	
	$formulario->boton_tipo("hidden","idestudiantegeneral",$_SESSION['sissic_idestudiantegeneral'],"");	
	$formulario->boton_tipo("hidden","codigoestado","100","");
	//$formulario->boton_tipo("hidden","codigotipoconsejouniversidad","400","");

	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipoparticipaciongobiernoestudiante t","codigotipoparticipaciongobiernoestudiante","nombretipoparticipaciongobiernoestudiante"," codigoestado like '1%'",'',0);

	$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'codigotipoparticipaciongobiernoestudiante','".$codigotipoparticipaciongobiernoestudiante."','onchange=enviarparticipacionuniversitaria();'";
	$formulario->dibujar_campo($campo,$parametros,"Tipo de Participacion","tdtitulogris",'codigotipoparticipaciongobiernoestudiante','requerido');
	if(isset($codigotipoparticipaciongobiernoestudiante)&&trim($codigotipoparticipaciongobiernoestudiante)!=''){

		//if($codigotipoparticipaciongobiernoestudiante<>"400"){
		$objdibujaformulario->muestraFormulario();
		$objdibujaformulario->columnas[]="idestudiantegeneral";
		//$objdibujaformulario->columnas[]="codigotipoconsejouniversidad";
		$objdibujaformulario->columnas[]="codigoestado";
		$objdibujaformulario->columnas[]="codigotipoparticipaciongobiernoestudiante";
		$objdibujaformulario->botonesEnvio();
		//}
		/*else
		{
		//	gobiernouniversitario($objetobase,$formulario);
		}*/
	}
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