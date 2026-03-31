<?php
    session_start();
    include_once('../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
	$rutaVistas = "../View"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
    require_once("../../../../../../../Mustache/load.php"); /*Ruta a /html/Mustache */
	$template_index = $mustache->loadTemplate('CargueRotaciones'); /*carga la plantilla index*/ 
    
    
?>