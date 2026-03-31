<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<?php if(!isset($_SESSION['codigo'])){ ?>
<a href="<?php echo $_GET['link_origen']?>" id="aparencialinknaranja">inicio</a><br><br>
<?php } ?>
<?php
//error_reporting(2047);
setlocale(LC_ALL, 'esm');
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../Connections/sala2.php'); 
	  	
require('funciones/validaciones.php');
require('funciones/generar_cartas.php');
	
//$codigoestudiante=9398;
//$codigoestudiante=9344;

if(isset($_GET['codigoestudiante']))
{
	$codigoestudiante=$_GET['codigoestudiante'];
}
else
{
	echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
	exit();
	//$codigoestudiante=8628;
}
if($_GET['depurar']=='si')
{
	$debug=true;
}
else
{
	$debug=false;
       
}
/*
 * Ivan quintero cooridnadorsisinfo@unbosque.edu.co
 * 20 de diciembre
 *  Ajustes de adicion de periodo en inscirpcion o activo cuando uno de los dos no se encuentre en el proceso existente.
 */

$query_periodo_activo="SELECT 	p.codigoperiodo FROM periodo p WHERE p.codigoestadoperiodo in (1, 4)";
/*END*/
$operacion_periodo_activo=$sala->query($query_periodo_activo);
$row_periodo_activo=$operacion_periodo_activo->fetchRow();

$codigoperiodo=$row_periodo_activo['codigoperiodo'];
if($codigoperiodo=="")
{
	"<h1>Error:codigoperiodo nulo</h1>";
	exit();
}

$carrera = "SELECT codigocarrera FROM estudiante WHERE codigoestudiante = ".$codigoestudiante."";

$query_carrera=$sala->query($carrera);
$row_carrera=$query_carrera->fetchRow();

$validaciones=new validaciones_requeridas($sala,$codigoestudiante,$codigoperiodo,$debug);
$valido=$validaciones->verifica_validaciones();
$array_validaciones=$validaciones->retorna_array_validaciones();
$array_documentos_pendientes=$validaciones->retorna_array_documentos_pendientes();
$array_materias_pendientes=$validaciones->retorna_array_materias_pendientes();
$array_materias_actuales=$validaciones->retorna_array_materias_actuales();
$array_pazysalvos_pendientes=$validaciones->retorna_array_pazysalvos_pendientes();
$valor_pago_derechos_grado=$validaciones->retorna_valor_pago_derechos_grado();
$array_deudas_sap=$validaciones->retorna_array_deudas_sap();
$plandepagos=$validaciones->retorna_plandepagos();
$cartas=new GenerarCartas($array_validaciones,$codigoestudiante,$sala);
$cartas->carga_datos_bloques($array_documentos_pendientes,$array_materias_pendientes,$array_materias_actuales,$valor_pago_derechos_grado,$array_pazysalvos_pendientes,$array_deudas_sap,$plandepagos);
$cartas->carta();
?>
