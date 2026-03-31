<?PHP 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include("../../templates/template.php");
    $db = writeHeader("Ver Detalle Actualización Indicador",TRUE,$proyectoMonitoreo,"../../../","dialog");
    $_GET["show"]=true;
           $api = new API_Monitoreo();
	$utils = new Utils_monitoreo();
        
	include('../../monitoreo/monitoreo/wdCalendar/detalleSeguimiento.php');
	include('../../monitoreo/monitoreo/wdCalendar/detalleRevision.php');
?>