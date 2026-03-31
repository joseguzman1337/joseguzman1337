<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
session_set_cookie_params(86400);
@session_start();
require('../../../../../../Connections/sala2.php');
$rutaado = "../../../../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../../../../Connections/salaado.php');

$codigocarrera = $_SESSION['codigofacultad'];
$iditemsiccarrera = $_REQUEST['iditemsiccarrera'];
$iditemsic = $_REQUEST['iditemsic'];

$rutaPHP = '../../../../librerias/php/';
require_once($rutaPHP.'funcionessic.php');

$rutaJS = '../../../../librerias/js/';
$rutaEstilos = '../../../../estilos/';
$rutaImagenes = '../../../../imagenes/';

$rutaModelo = '../../modelo/adjunto.php';
$rutaVista = '../../vista/adjunto.php';
require_once($rutaModelo);

if(isset($_REQUEST['eliminar']))
{
    $itemsiccarreraadjunto = $_REQUEST['eliminar'];
}
$adjunto = new adjunto($itemsiccarreraadjunto);
//$db->debug = true;

if(isset($_REQUEST['eliminar']))
{
    if($adjunto->eliminarArchivo())
    {
        echo "eliminado";
        exit();
    }
    else
    {
        echo "ERROR: El archivo no pudo ser eliminado";
        exit();
    }
}

$nopuedeadjuntar = false;
if(!$adjunto->puedeAdjuntar($iditemsic, $iditemsiccarrera))
{
    $nopuedeadjuntar = true;
}
//print_r($adjunto);
//exit();
if(isset($_REQUEST['enviar']))
{
    //$db->debug = true;
    $adjunto->adjuntarArchivo(&$iditemsiccarrera);
}


require_once($rutaVista);
?>
