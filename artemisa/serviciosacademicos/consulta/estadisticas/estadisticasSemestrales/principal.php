<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
// echo "<pre>";print_r($_SESSION);
// echo "<pre>";print_r($_GET);
// echo "<pre>";var_dump($_GET['codigocarrerainf']);
ini_set('track_errors','Off');
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
error_reporting(0);


?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once('../matriculasnew/funciones/obtener_datos.php');
require_once('funciones/matriculadosSemestre.php');
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
/*echo "_GET<pre>";
print_r($_GET);
echo "</pre>";*/



if($_SESSION['codigocarrerainforme']<>$_GET['codigocarrerainf'] and !empty($_GET['codigocarrerainf'])){
	$_SESSION['codigocarrerainforme']=$_GET['codigocarrerainf'];
}
if($_SESSION['codigomodalidadacademicainforme']<>$_GET['codigomodalidadacademica'] and !empty($_GET['codigomodalidadacademica'])){
	$_SESSION['codigomodalidadacademicainforme']=$_GET['codigomodalidadacademica'];
}

if($_SESSION['codigoperiodoinforme']<>$_GET['codigoperiodo'] and !empty($_GET['codigoperiodo'])){
	$_SESSION['codigoperiodoinforme']=$_GET['codigoperiodo'];
}

$codigoperiodo=$_SESSION['codigoperiodoinforme'];
$codigocarrera=$_SESSION['codigocarrerainforme'];
$codigomodalidadacademica=$_SESSION['codigomodalidadacademicainforme'];
switch($_GET['criteriosituacion']){
    case 'Prematriculados':
        $opcion="prematricula";
        $titulo="Informe de Prematriculados Por Semestre";
        break;
    case 'No_prematriculados':
        $opcion="noprematricula";
        $titulo="Informe de No Prematriculados Por Semestre";
        break;
    default:
        $opcion="cabecera";
        $titulo="Informe de Matriculados Por Semestre";
        break;
}
$estadisticas = new matriculadosSemestre($codigoperiodo,$codigocarrera,$codigomodalidadacademica,$opcion,$sala);
// echo"<pre>";print_r($estadisticas);
/*$est=$estadisticas->creaArrayInformeCabecera();
$motor = new matriz($est);
$motor->DibujarTablaNormal($est);
*/
$_SESSION['link_origen']='principal.php?codigomodalidadacademica='.$codigomodalidadacademica.'&codigocarrerainf='.$codigocarrera.'&codigoperiodo='.$codigoperiodo;

$est2=$estadisticas->creaArrayInformeCabecera2();

$motor = new matriz($est2,$titulo,"principal.php",'si','no','../matriculasnew/menu.php','',false,'si','../../../',false);
$motor->jsVarios();
$motor->mostrarTitulo=true;
$motor->botonRecargar=false;
if($opcion=="cabecera")
for ($i=1; $i<=12; $i++){
	$motor->agregarllave_drilldown('semestre'.$i,'principal.php','detalle.php',$i,'codigocarrera',"codigoperiodo=$codigoperiodo",'','','','Click aquí para abrir detalle','');
}
$motor->mostrar();

?>