<?php 

include_once('../../Solicitud/SolicitudEspacio_class.php');  

$C_SolicitudEspacio = new SolicitudEspacio();

$id  = $_GET['id'];

$C_SolicitudEspacio->EditarEvento($id);
?>