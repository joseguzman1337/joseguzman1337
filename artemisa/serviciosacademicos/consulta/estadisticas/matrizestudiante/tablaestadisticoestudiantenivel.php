<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once("../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('../../../funciones/sala/nota/nota.php');
require_once("EstadisticoEstudiante.php");
require_once("EstadisticoDocente.php");
require_once("clasearreglotablaestadistica.php");
require_once("vistatablaestadistica.php");

ini_set('max_execution_time','6000');
ini_set('memory_limit', '128M');
$horainicial=mktime(date("H"),date("i"),date("s"));
$formulario=new formulariobaseestudiante($sala,"form1","post","","true");
$objetobase=new BaseDeDatosGeneral($sala);


if($_REQUEST["Enviar"]){
	if(!is_array($_REQUEST["campos"])){
		alerta_javascript("Es necesario escoger una o mas opciones de Campo del Formulario *");
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=menutablaestadisticoestudiante.php'>";
		exit();
	}
}
/*echo "arreglovertical<pre>";
print_r($arreglovertical);
echo "</pre>";*/


//
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Documento sin t&iacute;tulo</title>

<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<link rel="stylesheet" href="estilotabla.css" type="text/css">
<script type="text/javascript" src="../../../funciones/sala_genericas/ajax/prototype.js"></script>
<script type="text/javascript" src="eventosscroll.js"></script>
<script LANGUAGE="JavaScript">

var eventsToBeTested = ['scroll','mousewheel','DOMMouseScroll'];

function regresarGet()
{
	//history.back();
	document.location.href="<?php echo 'menutablaestadisticoestudiante.php';?>";
}
function ocultarEspera() {
      document.getElementById('carguediv').style.visibility = 'hidden';
}
function mostrarEspera() {
      document.getElementById('carguediv').style.visibility = 'visible';
}
function enviaExportar()
{
	var formulario=document.getElementById('f2');
	formulario.action="exportar.php";
	formulario.submit();
}
</script>
</head>

<body  topmargin="0" leftmargin="0">

<!-- -->
        <div id='carguediv' style='position:absolute; left:300px; top:350px; width:209px; height:34px; z-index:1; visibility: hidden;  background-color: #FFFFFF; layer-background-color: #E9E9E9;'>
            <table width='300' border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
                <tr>
                    <td><img  src="../../facultades/imagesAlt2/cargando.gif" name="cargando"></td>
                </tr>
                <tr>
                    <td>Por favor espere, este proceso puede durar varios segundos...</td>
                </tr>
            </table>
        </div>
<?php

echo "<script type='text/javascript'>
    mostrarEspera();
</script>";
ob_flush();
flush();

if(isset($_GET['codigoperiodo'])&&trim($_GET['codigoperiodo'])!='')
	$codigoperiodo = $_GET['codigoperiodo'];
else
	$codigoperiodo = $_SESSION['codigoperiodosesion'];


$db=$objetobase->conexion;
$objestadisitico=new EstadisticoEstudiante($codigoperiodo,$objetobase);
//border='1' cellpadding='0' cellspacing='0' bordercolor='#E9E9E9'
$objvistaestadistico=new VistaTablaEstadistico("95","50","class='estilocelda' ","","cellpadding='0' cellspacing='0' ");
	$objvistaestadistico->setColorGeneral("#FFEE53");
	$objvistaestadistico->setColorArea("#7EBAFF");
	$objvistaestadistico->setColorNivel("#00D0F0");
	$objvistaestadistico->setColorFacultad("#97D9FF");
	$objvistaestadistico->setColorCarrera("#FFFFFF");

if(is_array($_REQUEST["campos"]))
if(in_array("todos",$_REQUEST["campos"])){
	$arraycampos[]="rangoEstrato";
	$arraycampos[]="rangoEdad";
	$arraycampos[]="rangoGenero";
	$arraycampos[]="rangoNivelEducacion";
	$arraycampos[]="rangoPuestoIcfes";
	$arraycampos[]="rangoNacionalidad";
	$arraycampos[]="rangoParticipacionAcademica";
	$arraycampos[]="rangoLineaInvestigacion";
	$arraycampos[]="rangoProyeccionSocial";
	$arraycampos[]="rangoParticipacionBienestar";
	$arraycampos[]="rangoParticipacionGobierno";
	$arraycampos[]="rangoAsociacion";
	$arraycampos[]="rangoParticipacionGestion";
	$arraycampos[]="rangoReconocimiento";
	$arraycampos[]="rangoTipoFinanciacion";
	$arraycampos[]="rangoEstadoEstudiante";
	$arraycampos[]="historicoEstudiante";
}
else {
$arraycampos=$_REQUEST["campos"];
}

$arraysintotalmodalidad[]="historicoEstudiante";


$objarreglotabla=new ArregloTablaEstadistico($objestadisitico,"estudiante",$arraycampos);

$codigomodalidadacademicasic=$_REQUEST["codigomodalidadacademicasic"];
$codigocarrera=$_REQUEST["codigocarrera"];
$codigofacultad= $_REQUEST["codigofacultad"];
$codigoareadisciplinar=$_REQUEST["codigoareadisciplinar"];

$objarreglotabla->setArrayOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad,$codigoareadisciplinar);

$objarreglotabla->setArraySinTotales($arraysintotalmodalidad);
$arreglovertical=$objarreglotabla->titulosVerticalArea();

//echo "<H1>PRUEBA 1</H1>";

$arreglohorizontal=$objarreglotabla->horizontalArea();
//echo "<H1>PRUEBA 2</H1>";
$arreglohorizontaltitulo=$objarreglotabla->horizontalTituloArea();
$arregloareaprincipal=$objarreglotabla->areaPrincipal();
//ob_end_clean();
//ob_start();
echo "<pre>";
print_r($arreglovertical);
echo "</pre>";

echo "<table cellpadding='0'cellspacing='0' >";
echo "<tr>";
echo "<td align='right' valign='bottom' width='480' class='estilotitulo'>";
//TITULOS HORIZONTALES DE TITULOS VERTICALES
        echo '<form method="post" action="" name="f2" id="f2">
	<input type="button" value="Regresar" name="regresar" onclick="regresarGet()"/>
            <input type="submit" value="Exportar a Excel" name="formato" onclick="enviaExportar()"/>	
        </form>';
	$objvistaestadistico->setArrayHorizontal($arreglohorizontaltitulo);
	$_SESSION["estudianteestadisticosesion"]["titulohorizontalvertical"]=$objvistaestadistico->tablaHorizontalEx("",1);
	echo $_SESSION["estudianteestadisticosesion"]["titulohorizontalvertical"];

echo "</td>";
echo "<td align='left' valign='bottom'>";
//TITULOS HORIZONTALES
echo "<div id='titulohorizontal' class='scrolltitulo'>";
	echo "<div id='tablahorizontal' >";
	echo "<table width='10000px' cellpadding='0'cellspacing='0'>";
	echo "<tr>";
	echo "<td align='left' valign='bottom'>";
		$objvistaestadistico->setArrayHorizontal($arreglohorizontal);
		$_SESSION["estudianteestadisticosesion"]["titulohorizontal"]=$objvistaestadistico->tablaHorizontalEx("width='10000px'",2);
		echo $_SESSION["estudianteestadisticosesion"]["titulohorizontal"];
	echo "</td>";
	echo "</tr>";

	echo "</table>";
	echo "</div>";	
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td valign='top' align='right'>";
//TITULOS VERTICALES

echo "<div id='titulovertical' class='scrolltitulov'>";
	echo "<div id='tablavertical'>";
	echo "<table height='10000' width='1000' cellpadding='0'cellspacing='0'>";
	echo "<tr>";
	echo "<td align='left' valign='top'>";
		$objvistaestadistico->setArrayVertical($arreglovertical);
		echo $_SESSION["estudianteestadisticosesion"]["titulovertical"]=$objvistaestadistico->tablaVerticalEx();
		echo $_SESSION["estudianteestadisticosesion"]["titulovertical"];
	echo "</td>";
	echo "</tr>";

	echo "</table>";
	echo "</div>";	
echo "</td>";
echo "<td valign='top'>";
//AREA PRINCIPAL

echo "<div id='areaprincipal' class='scroll'>";
	echo "<div id='tablaprincipal'>";
	echo "<table width='10000px' cellpadding='0'cellspacing='0'>";
	echo "<tr>";
	echo "<td align='left' valign='bottom'>";
	
	
	$objvistaestadistico->setArrayAreaPrincipal($arregloareaprincipal);
 	$_SESSION["estudianteestadisticosesion"]["areaprincipal"]=$objvistaestadistico->tablaAreaPrincipalEx(1);
 	$areaprincipal=$objvistaestadistico->tablaAreaPrincipalEx();
	
	echo $areaprincipal;
	echo "</td>";
	echo "</tr>";

	echo "</table>";
	echo "</div>";	

echo "</div>";
echo "</td>";

echo "</tr>";

echo "</table>";

    $horafinal=mktime(date("H"),date("i"),date("s"));
    //   echo date("H:i:s")."<br>";
    echo "<font color='White'><br>Diferencia Impresion Total=".($horafinal-$horainicial)."<br></font>";
echo "<script type='text/javascript'>
    ocultarEspera();
</script>";
?>

</body>
</html>