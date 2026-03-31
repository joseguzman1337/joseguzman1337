<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/phpmailer/class.phpmailer.php");
require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once("../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('../../../funciones/sala/nota/nota.php');
require_once('../matriculasnew/funciones/obtener_datos.php');
require_once("indicadoresautoinstitucional.php");
require_once("cacheindicadores.php");
require_once("administraindicadores.php");
require_once("vistatablaestadistica.php");
require_once("titulosindicadores.php");
ini_set('max_execution_time','6000');
$objetobase=new BaseDeDatosGeneral($sala);
$objindicadores=new IndicadoresInstitucional($_SESSION["codigoperiodosesion"],$objetobase);
$objcacheindicadores=new CacheIndicadores($_SESSION["codigoperiodosesion"],$objetobase);
$db=$objetobase->conexion;
//border='1' cellpadding='0' cellspacing='0' bordercolor='#E9E9E9'
/*echo "SESSION1<pre>";
print_r($_SESSION);
echo "</pre>";*/
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
	document.location.href="<?php echo "menuindicadores.php?opciontipoindicador=".$_SESSION["indicadores_opciontipoindicador"];?>";
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
function mostrargrafica(indicefila){
  NewWindow=window.open('graficas/indicadorgraficamuestra.php?indicefila='+indicefila+'','newWin','width=600,height=400,left=0,top=0,toolbar=No,location=No,scrollbars=No,status=No,resizable=Yes,fullscreen=No');
  NewWindow.focus();

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
/*echo "SESSION1<pre>";
print_r($_SESSION);
echo "</pre>";*/
if(isset($_SESSION["codigofacultad"])&&trim($_SESSION["codigofacultad"])!=''){
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
$codigomodalidadacademicasic="";
$codigocarrera=$_SESSION["codigofacultad"];
$codigofacultad2="";
$codigoareadisciplinar="";

/*echo "<b>SESSION1.1</b><pre>";
print_r($_SESSION);
echo "</pre>";*/

$objcacheindicadores->setCarreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad2,$codigoareadisciplinar);

$objindicadores->carreraOpciones($codigomodalidadacademicasic,$codigocarrera,$codigofacultad2,$codigoareadisciplinar);


$objadminindicadores=new AdministracionIndicadores($objindicadores,$objcacheindicadores,$objetobase);
$objadminindicadores->setRangoPeriodo("20062",$_SESSION["codigoperiodosesion"]);

//$objadminindicadores->imprimirTitulosVertical($titulo);
/*
echo "<pre>";
print_r($_POST["indicadores"]);
echo "</pre>";
*/
/*echo "SESSION2<pre>";
print_r($_SESSION);
echo "</pre>";*/
$anchotabla=$objadminindicadores->getAnchoTablaPrincipal();
echo "<table cellpadding='0'cellspacing='0' >";
echo "<tr>";
echo "<td align='right' valign='bottom' width='363' class='estilotitulo'>";
//TITULOS HORIZONTALES DE TITULOS VERTICALES
        echo '<form method="post" action="" name="f2" id="f2">
	<input type="button" value="Regresar" name="regresar" onclick="regresarGet()"/>
            <input type="submit" value="Exportar a Excel" name="formato" onclick="enviaExportar()"/>	
        </form>';
	//echo "<h1>T1=".$titulo."</h1>";
	$objadminindicadores->imprimirHorizontalVertical($titulo);
echo "</td>";
echo "<td align='left' valign='bottom'>";
//TITULOS HORIZONTALES
echo "<div id='titulohorizontal' class='scrolltitulo'>";
	echo "<div id='tablahorizontal' >";
	echo "<table width='".($anchotabla+50)."px' cellpadding='0'cellspacing='0'>";
	echo "<tr>";
	echo "<td align='left' valign='bottom'>";
		$objadminindicadores->imprimirAreaHorizontal();
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
	echo "<table height='10000px' width='1000' cellpadding='0'cellspacing='0'>";
	echo "<tr>";
	echo "<td align='left' valign='top'>";
	//echo "<h1>T2=".$titulo."</h1>";
		$objadminindicadores->imprimirTitulosVertical($titulo,$_POST["indicadores"]);
	echo "</td>";
	echo "</tr>";

	echo "</table>";
	echo "</div>";	
echo "</td>";
echo "<td valign='top'>";
//AREA PRINCIPAL

echo "<div id='areaprincipal' class='scroll'>";
	echo "<div id='tablaprincipal'>";
	echo "<table width='".($anchotabla+25)."px' cellpadding='0'cellspacing='0'>";
	echo "<tr>";
	echo "<td align='left' valign='bottom'>";
		$objadminindicadores->imprimirAreaPrincipal();
	echo "</td>";
	echo "</tr>";

	echo "</table>";
	echo "</div>";	

echo "</div>";
echo "</td>";

echo "</tr>";

echo "</table>";

/*echo "SESSION3<pre>";
print_r($_SESSION);
echo "</pre>";*/

    $horafinal=mktime(date("H"),date("i"),date("s"));
    //   echo date("H:i:s")."<br>";
    echo "<font color='White'><br>Diferencia Impresion Total=".($horafinal-$horainicial)."<br></font>";
echo "<script type='text/javascript'>
    ocultarEspera();
</script>";


}
else{

echo "<script type='text/javascript'>
   alert('Es necesario seleccionar carrera y tener sesion activa');
	regresarGet();
</script>";

}



?>

</body>
</html>