<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../Connections/sala2.php' );
$fechahoy=date("Y-m-d H:i:s");
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');

$query_actualizar = "UPDATE trabajodegrado SET codigoestado = 200 where idtrabajodegrado = '{$_REQUEST['idtrabajodegrado']}'";
                $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());

?>