<?php  
include_once('../../Solicitud/SolicitudEspacio_class.php');  

    $C_SolicitudEspacio = new SolicitudEspacio();
/*
    [FechaIni] => 2014-07-01
    [FechaFin] => 2014-07-31
    [Frecuencia] => 3
    [numIndices] => 0
    [sede] => 4
*/
$FechaIni  = $_REQUEST['FechaIni'];
$FechaFin  = $_REQUEST['FechaFin'];
$sede      = $_REQUEST['sede'];
 
    $C_SolicitudEspacio->NewEvento($FechaIni,$FechaFin,$sede);    


?>