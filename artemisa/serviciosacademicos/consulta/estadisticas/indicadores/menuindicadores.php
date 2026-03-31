<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once("../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("titulosindicadores.php");
$formulario=new formulariobaseestudiante($sala,"form1","post","","true");
//,'Los campos marcados con *, no han sido correctamente diligenciados:\n\n',"",false,"../../../../../funciones/sala_genericas/",0

//&$conexion,$nombre,$metodo,$accion="",$validar=false,$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n\n',$archivo_formulario="",$debug=false,$rutaraiz="../../../../",$scriptglobo=1
$formulario->rutaraiz="../../../funciones/sala_genericas/";

$objetobase=new BaseDeDatosGeneral($sala);
$objetotitulos=new TitulosIndicadores($sala);
//$formulario->rutaraiz="../../../funciones/sala_genericas/";
/*echo "SESSION4<pre>";
print_r($_SESSION);
echo "</pre>";*/
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

function regresarGet()
{
	//history.back();
	//alert("Entro?");
	document.location.href="<?php echo 'index.html';?>";
}

</script>
</head>

<body  topmargin="0" leftmargin="0">
<?php
/*echo "_POST<pre>";
print_r($_POST);
echo "</pre>";*/
echo "<form name=\"form1\" action=\"consultaindicador.php?opciontipoindicador=".$_GET["opciontipoindicador"]."\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\" align='center'>";

switch($_GET["opciontipoindicador"]){
	case "cliente":
		$titulo="perspectivaCliente";
	break;
	case "procesos":
		$titulo="perspectivaProcesos";
	break;
	case "capital":
		$titulo="perspectivaCapital";
	break;
}
if(isset($_GET["opciontipoindicador"])&&trim($_GET["opciontipoindicador"])!='')
	$_SESSION["indicadores_opciontipoindicador"]=$_GET["opciontipoindicador"];

//$titulo="perspectivaCliente";
$arrayindicadores=$objetotitulos->$titulo();

 	$formulario->dibujar_fila_titulo('INDICADORES DE '.$arrayindicadores["titulo"],'labelresaltado',"2","align='center'");
$i=0;
foreach($arrayindicadores["titulovertical"] as $llave => $valor){
	foreach($valor as $llave2 => $valor){
	
	$parametros="'checkbox','indicadores[]','".$llave2."'";
	$campo="boton_tipo";
	$arraytamanoayuda["width"]="160px";

	$i++;
	$arraytamanoayuda["height"]="100px";
	$formulario->dibujar_campo($campo,$parametros,$llave2,"tdtitulogris",'Enviar',"",0,"",$valor["ayuda"],$arraytamanoayuda);
	}
	//$tipo,$parametros,$titulo,$estilo_titulo,$idtitulo,$tipo_titulo="",$imprimir=0,$tdcomentario="",$ayuda=""
}

	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Continuar','Continuar',' onclick=\'enviartarget();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;	$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=regresarGet()'";
	$boton[$conboton]='boton_tipo';
	$conboton++;
 	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');

echo "</table>";
echo "</form>";


?>

</body>
</html>