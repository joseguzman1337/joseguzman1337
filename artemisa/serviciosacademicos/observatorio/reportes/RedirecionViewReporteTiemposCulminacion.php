<?php

/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/

//var_dump (is_file('../templates/templateObservatorio.php'));
include("../../ReportesAuditoria/templates/mainjson.php");
include("../templates/templateObservatorio.php");
include('../../mgi/datos/class/Utils_datos.php');
$Titulo = 'Tiempos Culminaci&oacute;n';
writeHeader($Titulo,false,"Tiempos de Culminacion",1,'',$db);
$utils = new Utils_datos();

$UrlView='1';
?>
<div align="center">
<?PHP 
include(dirname(__FILE__)."/../../mgi/datos/reportes/reportes/estudiantes/viewReporteTiemposCulminacion.php");
?>
</div>
