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
if(!isset($_SESSION['sissic_iditemsic'])||trim($_SESSION['sissic_iditemsic'])=='')
$_SESSION['sissic_iditemsic']=$_REQUEST['iditemsic'];
else
	if(isset($_REQUEST['iditemsic'])&&$_SESSION['sissic_iditemsic']!=$_REQUEST['iditemsic'])
		$_SESSION['sissic_iditemsic']=$_REQUEST['iditemsic'];

$objetobase=new BaseDeDatosGeneral($sala);
$db=$objetobase->conexion;
require_once( '../../textogeneral/modelo/textogeneral.php');
$itemsic = new textogeneral($_SESSION['sissic_iditemsic']);

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
function enviartipoproduccion()
{
var formulario=document.getElementById("form1");
formulario.action="produccionintelectualcarrera.php?Nuevo_Registro=1&idformulario=<?php echo $_GET["idformulario"]; ?>";
formulario.submit();

}

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
/*echo "_POST<pre>";
print_r($_POST);
echo "</pre>";*/
echo "<form name=\"form1\" id=\"form1\" action=\"\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";





	$usuario=$formulario->datos_usuario();
$_GET["idformulario"]=40;
$condicion=" and codigoestado like '1%'";
	$datosformulario=$objetobase->recuperar_datos_tabla("formulario f","idformulario",$_GET["idformulario"],$condicion,"",0);

$formulario->dibujar_fila_titulo(strtoupper($datosformulario["nombreformulario"]),'labelresaltado',"2","align='center'");

$formulario->dibujar_fila_titulo($datosformulario["descripcionformulario"],'tdtituloencuestadescripcion',"2","align='left'","td");


$muestraformulario=0;
if($_REQUEST["Enviar"]){
$muestraformulario=1;
}


if($_REQUEST["Nuevo_Registro"]){
$muestraformulario=1;
//echo "<h1>ENTRO A ANULAR  idestimulocarrera ID=".$muestraformulario."</h1>";

	if(isset($_GET["idproduccionintelectualcarrera"])&&trim($_GET["idproduccionintelectualcarrera"])!=''){
		unset($_POST);
		unset($_GET["idproduccionintelectualcarrera"]);
	}

$_REQUEST["Nuevo_Registro"]=1;
}

if(isset($_GET["idproduccionintelectualcarrera"])&&trim($_GET["idproduccionintelectualcarrera"])!=''){
$muestraformulario=1;
//echo "<h1>ENTRO A VERIFICAR ID=".$muestraformulario."</h1>";
}
if($datosdedicacionexterna=$objetobase->recuperar_datos_tabla("produccionintelectualcarrera","idproduccionintelectualcarrera",$_GET["idproduccionintelectualcarrera"],"","",0)){
 if($datosdedicacionexterna["codigoestado"]=="200"){
	$muestraformulario=0;
		//echo "<h1>ENTRO 1 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
	}

}
if($_REQUEST["Anulado"]){
$muestraformulario=0;
//echo "<h1>ENTRO 2 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
}


$objdibujaformulario=new DibujaFormulario("produccionintelectualcarrera",$_GET["idproduccionintelectualcarrera"],$sala,$_GET["idformulario"],$formulario);

//if($muestraformulario){

	$arrayquitacolumnas[0]="codigocarrera";
	$arrayquitacolumnas[1]="codigoestado";
	$arrayquitacolumnas[2]="codigotipoproduccionintelectual";






	if(is_array($_POST)&&count($_POST)>0){
		$codigotipoproduccionintelectual=$_POST["codigotipoproduccionintelectual"];
	}
	else{
		$codigotipoproduccionintelectual=$objdibujaformulario->recuperarValorCampo("codigotipoproduccionintelectual");
	}

    //echo "<pre>"; print_r($objdibujaformulario->columnasnombres); echo "</pre>";
    switch($codigotipoproduccionintelectual){
        case "100":
            $mensaje="No hacer nada";
            $objdibujaformulario->columnasnombres[2]="Nombre de la Revista";
            $objdibujaformulario->columnasnombres[3]="Titulo del Artículo";
            $objdibujaformulario->columnasnombres[5]="Revista Indexada";
            $objdibujaformulario->columnasnombres[6]="ISSN";
        break;
        case "101":
            $mensaje="No hacer nada";
            $objdibujaformulario->columnasnombres[2]="Nombre de la Revista";
            $objdibujaformulario->columnasnombres[3]="Titulo del Artículo";
            $objdibujaformulario->columnasnombres[5]="Revista Indexada";
            $objdibujaformulario->columnasnombres[6]="ISSN";
        break;
        case "200":
            $objdibujaformulario->columnasnombres[2]="Nombre del Libro";
            $objdibujaformulario->columnasnombres[6]="ISBN";
            $arrayquitacolumnas[3]="tituloproduccionintelectualcarrera";
            $formulario->boton_tipo("hidden","tituloproduccionintelectualcarrera"," ","");
            $arrayquitacolumnas[4]="esindexadaproduccionintelectualcarrera";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualcarrera","0","");
        break;
        case "201":
            $objdibujaformulario->columnasnombres[2]="Nombre del Libro";
            $objdibujaformulario->columnasnombres[3]="Nombre del Capítulo";
            $objdibujaformulario->columnasnombres[6]="ISBN";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualcarrera";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualcarrera","0","");
        break;
        case "300":
            $objdibujaformulario->columnasnombres[2]="Nombre de la Ponencia";
            $objdibujaformulario->columnasnombres[3]="Medio de Publicación";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualcarrera";
            $arrayquitacolumnas[4]="numeroproduccionintelectualcarrera";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualcarrera","0","");
            $formulario->boton_tipo("hidden","numeroproduccionintelectualcarrera"," ","");
        break;
        case "400":
            $objdibujaformulario->columnasnombres[2]="Nombre del Producto Artístico";
            $objdibujaformulario->columnasnombres[6].=" Artístico";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualcarrera";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualcarrera","0","");
        break;
        case "401":
            $objdibujaformulario->columnasnombres[2]="Nombre del Producto Artístico Musical";
            $objdibujaformulario->columnasnombres[6].=" Artístico Musical";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualcarrera";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualcarrera","0","");
        break;
        case "402":
            $objdibujaformulario->columnasnombres[2]="Nombre de la Rese&ntilde;a";
            $objdibujaformulario->columnasnombres[6]="Número de Identificación de la Rese&ntilde;a";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualcarrera";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualcarrera","0","");
        break;
        case "500":
            $objdibujaformulario->columnasnombres[2]="Nombre del Proyecto";
            $objdibujaformulario->columnasnombres[6]="Número de Identificación del Proyecto";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualcarrera";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualcarrera","0","");
        break;
        case "600":
            $objdibujaformulario->columnasnombres[2]="Nombre del Material";
            $objdibujaformulario->columnasnombres[6]="Número de Identificación de la Revisión";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualcarrera";
            $arrayquitacolumnas[4]="numeroproduccionintelectualcarrera";
            $arrayquitacolumnas[5]="tituloproduccionintelectualcarrera";
            $arrayquitacolumnas[6]="fechapublicacionproduccionintelectualcarrera";
          
            $formulario->boton_tipo("hidden","fechapublicacionproduccionintelectualcarrera","0000-00-00",""); 
            $formulario->boton_tipo("hidden","numeroproduccionintelectualcarrera","0","");
            $formulario->boton_tipo("hidden","tituloproduccionintelectualcarrera","","");
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualcarrera","0","");
        break;
        default:
        $arrayquitacolumnas[3]="esindexadaproduccionintelectualcarrera";
        $formulario->boton_tipo("hidden","esindexadaproduccionintelectualcarrera","0","");

        break;
	}
	//echo "<pre>sdasdasdasdasdasd"; print_r($objdibujaformulario); echo "</pre>";

	$objdibujaformulario->quitarcolumnas($arrayquitacolumnas);
	$formulario->boton_tipo("hidden","codigocarrera",$_SESSION['codigofacultad'],"");
	$formulario->boton_tipo("hidden","codigoestado","100","");



	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipoproduccionintelectual t","codigotipoproduccionintelectual","nombretipoproduccionintelectual"," codigoestado like '1%' and codigotipoproduccionintelectual <> '600'",'',0);

	$formulario->filatmp[""]="Seleccionar";
	$campo='menu_fila'; $parametros="'codigotipoproduccionintelectual','".$codigotipoproduccionintelectual."','onchange=enviartipoproduccion();'";
	$formulario->dibujar_campo($campo,$parametros,"Tipo de Produccion","tdtitulogris",'codigotipoproduccionintelectual','requerido');

	if(isset($codigotipoproduccionintelectual)&&trim($codigotipoproduccionintelectual)!=''){
        //echo "<pre>"; print_r($objdibujaformulario); echo "</pre>";
        //$objdibujaformulario->arraycolumnasnombres['produccionintelectualcarrera']['nombreproduccionintelectualcarrera']="Nombre de la Revista";

        $objdibujaformulario->muestraFormulario();
        $objdibujaformulario->columnas[]="codigocarrera";
        $objdibujaformulario->columnas[]="codigoestado";
        $objdibujaformulario->columnas[]="codigotipoproduccionintelectual";
        switch($codigotipoproduccionintelectual){
            case "200":
            $objdibujaformulario->columnas[]="tituloproduccionintelectualcarrera";
            break;
            case "201":
            $objdibujaformulario->columnas[]="esindexadaproduccionintelectualcarrera";
            break;
            case "300":
            $objdibujaformulario->columnas[]="esindexadaproduccionintelectualcarrera";
            $objdibujaformulario->columnas[]="numeroproduccionintelectualcarrera";
            break;
            case "600":
            $objdibujaformulario->columnas[]="numeroproduccionintelectualcarrera";
            $objdibujaformulario->columnas[]="tituloproduccionintelectualcarrera";
            $objdibujaformulario->columnas[]="fechapublicacionproduccionintelectualcarrera";            break;
            default:
            $objdibujaformulario->columnas[]="esindexadaproduccionintelectualcarrera";
            break;
        }
        $objdibujaformulario->botonesEnvio();
	$conboton=0;
	$parametrobotonenviar[$conboton]="'Listado','listadoproduccionintelectualcarrera.php?iditemsic='".$_GET["iditemsic"].",'',800,600,100,150,'yes','yes','yes','yes','yes'";
	$botones[$conboton]='boton_ventana_emergente';
	$conboton++;
	$formulario->dibujar_campos($botones,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0);
	}
//}
$codigocarrera = $_SESSION['codigofacultad'];

	if($objdibujaformulario->ingresarModificacion()){
	$mensaje = $itemsic->insertarItemsiccarrera();
	
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>
		cambiaestado('".$mensaje."',".$_SESSION['sissic_iditemsic'].");
	</script>";

	}

	if($objdibujaformulario->ingresarNuevo()){

	$mensaje = $itemsic->insertarItemsiccarrera();
	
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>
		cambiaestado('".$mensaje."',".$_SESSION['sissic_iditemsic'].");
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