<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
if(!isset($_SESSION['MM_Username'])){
	echo "<h1>Usted no está autorizado para abrir esta pagina</h1>";
	exit();
}

ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once("../matriculas/funciones/obtener_datos.php");
require_once("funciones/obtenerDatos.php");
require_once('../../../funciones/clases/motorv2/motor.php');
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
$descriptor=$_GET['descriptor'];
$estadisticasSeguimiento = new estadisticasSeguimiento($_SESSION['codigoperiodo_reporte'],$_SESSION['codigomodalidadacademica'],$_GET['codigocarrera'],$descriptor,&$sala);
$estadisticasMatriculas = new obtener_datos_matriculas($sala,$_GET['codigocarrera']);
$motor = new matriz($estadisticasSeguimiento->retornaDatosBasicos(),"Detalle Informe de Seguimientos",'detalle.php','si','si',$_GET['link_origen'],'',false,"si","../../../",false);
$motor->jsVarios();
$motor->mostrarTitulo=true;
$motor->botonRecargar=false;
switch ($descriptor){
	case 'interesados_total':
		$motor->agregarllave_drilldown('nombre','detalle.php','../../prematricula/interesados/preinscripcion_seguimiento.php','seguimiento','idpreinscripcion','','','','','Click aquí para efectuar seguimiento');
		$motor->agregarllave_drilldown('emailestudiante','detalle.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','emailestudiante');
		break;
	case 'interesados_con_seg':
		$motor->agregarllave_drilldown('nombre','detalle.php','../../prematricula/interesados/preinscripcion_seguimiento.php','seguimiento','idpreinscripcion','','','','','Click aquí para efectuar seguimiento');
		$motor->agregarllave_drilldown('emailestudiante','detalle.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','emailestudiante');
		break;
	case 'interesados_sin_seg':
		$motor->agregarllave_drilldown('nombre','detalle.php','../../prematricula/interesados/preinscripcion_seguimiento.php','seguimiento','idpreinscripcion','','','','','Click aquí para efectuar seguimiento');
		$motor->agregarllave_drilldown('emailestudiante','detalle.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','emailestudiante');
		break;
	case 'aspirantes_total':
		$motor->agregarllave_drilldown('nombre','../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../../../aspirantes/enlineacentral.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'numerodocumento','documentoingreso');
		$motor->agregarllave_drilldown('email','tabla_estadisticas_matriculas.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','email');
		$motor->agregarllave_drilldown('email2','tabla_estadisticas_matriculas.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','email2');
		break;
	case 'aspirantes_con_seg':
		$motor->agregarllave_drilldown('nombre','../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../../../aspirantes/enlineacentral.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'numerodocumento','documentoingreso');
		$motor->agregarllave_drilldown('email','tabla_estadisticas_matriculas.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','email');
		$motor->agregarllave_drilldown('email2','tabla_estadisticas_matriculas.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','email2');
		break;
	case 'aspirantes_sin_seg':
		$motor->agregarllave_drilldown('nombre','../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../../../aspirantes/enlineacentral.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'numerodocumento','documentoingreso');
		$motor->agregarllave_drilldown('email','tabla_estadisticas_matriculas.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','email');
		$motor->agregarllave_drilldown('email2','tabla_estadisticas_matriculas.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','email2');

		break;
}
$motor->mostrar();
?>