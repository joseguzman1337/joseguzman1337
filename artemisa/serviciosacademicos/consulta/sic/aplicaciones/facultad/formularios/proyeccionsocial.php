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
$rutaPHP="../../../librerias/php/";
$objetobase=new BaseDeDatosGeneral($sala);
$db=$objetobase->conexion;
require_once( '../../textogeneral/modelo/textogeneral.php');
//require_once('../../textogeneral/vista/textogeneral.php');
$itemsic = new textogeneral($_REQUEST['iditemsic']);

$formulario=new formulariobaseestudiante($sala,"form1","post","","true");
//,'Los campos marcados con *, no han sido correctamente diligenciados:\n\n',"",false,"../../../../../funciones/sala_genericas/",0

//&$conexion,$nombre,$metodo,$accion="",$validar=false,$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n\n',$archivo_formulario="",$debug=false,$rutaraiz="../../../../",$scriptglobo=1
$formulario->rutaraiz="../../../../../funciones/sala_genericas/";




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
function cambiaestado(mensaje,iditemsic){

var imagen = window.parent.document.getElementById("img" + iditemsic);

    if(mensaje == 'insertado')
    {
        alert("El valor fue insertado satisfactoriamente");
        //if(imagen.src == "imagenes/noiniciado.gif")
            imagen.src="imagenes/poraprobar.gif";
    }
    else if(mensaje == 'actualizado')
    {
        alert("El valor fue actualizado satisfactoriamente");
        if(imagen.src == "imagenes/aprobado.gif")
            alert("ADVERTENCIA: El item ha quedado por aprobar debido a la modificación hecha");
       imagen.src= "imagenes/poraprobar.gif";
    }
    else if(mensaje != '')
    {
        alert("ERROR:" + mensaje);
    }

}
</script>
</head>
<body>
<?php
echo "<form name=\"form1\" id=\"form1\" action=\"\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

$_GET["idformulario"]="39";

	$usuario=$formulario->datos_usuario();

$condicion=" and codigoestado like '1%'";
	$datosformulario=$objetobase->recuperar_datos_tabla("formulario f","idformulario",$_GET["idformulario"],$condicion,"",0);

$formulario->dibujar_fila_titulo(strtoupper($datosformulario["nombreformulario"]),'labelresaltado',"2","align='center'");

$formulario->dibujar_fila_titulo($datosformulario["descripcionformulario"],'tdtituloencuestadescripcion',"2","align='left'","td");

echo "<tr><td colspan=4> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

	$condicion=" and p.codigoestado like '1%'
			and t.codigotipoproyeccionsocialcarrera=p.codigotipoproyeccionsocialcarrera";
	//and tr.codigotiporeconocimientodocente=r.codigotiporeconocimientodocente
	$resultado=$objetobase->recuperar_resultado_tabla("proyeccionsocialcarrera p , tipoproyeccionsocialcarrera t","p.codigocarrera",$_SESSION['codigofacultad'],$condicion,"",0);

		$fila["Codigo"]="";
		$fila["Nombre de la Experiencia"]="";
		$fila["Año"]="";
		$fila["Producto"]="";
		$fila["Agentes Involucrados"]="";
		$fila["Responsabilidad Social"]="";


		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

	while($row=$resultado->fetchRow()){
		unset($fila);
		$enlacedetalle="<a href='proyeccionsocial.php?idproyeccionsocialcarrera=".$row["idproyeccionsocialcarrera"]."&idformulario=".$_GET["idformulario"]."&iditemsic=".$_GET["iditemsic"]."'>".$row["idproyeccionsocialcarrera"]."</a>";
		$fila[]=$enlacedetalle;
		$fila[]=$row["nombreproyeccionsocialcarrera"];
		$fila[]=substr($row["fechaproyeccionsocialcarrera"],0,4);
		$fila[]=$row["productoproyeccionsocialcarrera"];
		$fila[]=$row["agentesproyeccionsocialcarrera"];
		$fila[]=$row["nombretipoproyeccionsocialcarrera"];

		$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");

	}

	echo "<tr><td align='center' colspan='16'><input type='submit' name='Nuevo_Registro' id='Nuevo_Registro' value='Nuevo Registro'/> </td></tr>";

	echo "</table></td><tr>";


$muestraformulario=0;
if($_REQUEST["Enviar"]){
$muestraformulario=1;
}


if($_REQUEST["Nuevo_Registro"]){
$muestraformulario=1;
//echo "<h1>ENTRO A ANULAR  idestimulodocente ID=".$muestraformulario."</h1>";

	if(isset($_GET["idproyeccionsocialcarrera"])&&trim($_GET["idproyeccionsocialcarrera"])!=''){
		unset($_POST);
		unset($_GET["idproyeccionsocialcarrera"]);
	}

$_REQUEST["Anulado"]=0;
$_REQUEST["Nuevo_Registro"]=1;
}

if(isset($_GET["idproyeccionsocialcarrera"])&&trim($_GET["idproyeccionsocialcarrera"])!=''){
$muestraformulario=1;
//echo "<h1>ENTRO A VERIFICAR ID=".$muestraformulario."</h1>";
}
if($datosdedicacionexterna=$objetobase->recuperar_datos_tabla("proyeccionsocialcarrera","idproyeccionsocialcarrera",$_GET["idproyeccionsocialcarrera"],"","",0)){
 if($datosdedicacionexterna["codigoestado"]=="200"){
	$muestraformulario=0;
		//echo "<h1>ENTRO 1 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
	}

}
if($_REQUEST["Anulado"]){
$muestraformulario=0;
//echo "<h1>ENTRO 2 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
}

$nombreidtabla="idproyeccionsocialcarrera";
$idtablaget=$_GET["idproyeccionsocialcarrera"];
$idformulario=$_GET["idformulario"];
/*
echo "<pre>";
print_r($_GET);
echo "</pre>";
echo "_POST<pre>";
print_r($_POST);
echo "</pre>";*/
$objdibujaformulario=new DibujaFormulario("proyeccionsocialcarrera",$_GET["idproyeccionsocialcarrera"],$sala,$_GET["idformulario"],$formulario);

if($muestraformulario){

	$arrayquitacolumnas[0]="codigocarrera";
	$arrayquitacolumnas[1]="codigoestado";
	$objdibujaformulario->quitarcolumnas($arrayquitacolumnas);
	$formulario->boton_tipo("hidden","codigocarrera",$_SESSION['codigofacultad'],"");
	$formulario->boton_tipo("hidden","codigoestado","100","");
	$objdibujaformulario->muestraFormulario();
	$objdibujaformulario->columnas[]="codigocarrera";
	$objdibujaformulario->columnas[]="codigoestado";






	$objdibujaformulario->botonesEnvio();
}

$codigocarrera = $_SESSION['codigofacultad'];
	if($objdibujaformulario->ingresarModificacion()){
		$mensaje = $itemsic->insertarItemsiccarrera();
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>
		cambiaestado('".$mensaje."',".$_REQUEST['iditemsic'].");
	</script>";

	}

	if($objdibujaformulario->ingresarNuevo()){
		$mensaje = $itemsic->insertarItemsiccarrera();

	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>
		cambiaestado('".$mensaje."',".$_REQUEST['iditemsic'].");
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