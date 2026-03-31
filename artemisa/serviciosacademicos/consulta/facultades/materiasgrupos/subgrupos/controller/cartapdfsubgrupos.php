<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    $rutaVistas = "../view"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
    require_once(realpath(dirname(__FILE__))."/../../../../../../Mustache/load.php"); /*Ruta a /html/Mustache */
	$template_index = $mustache->loadTemplate('subgrupos'); /*carga la plantilla index*/    
	$template_update = $mustache->loadTemplate('update'); /*carga la plantilla para actualizar*/ 
    $template_listas = $mustache->loadTemplate('listas'); /*carga la plantilla para actualizar*/ 
        
	session_start();
	include_once ('../../../../../EspacioFisico/templates/template.php');
	$db = getBD();	
	$idgrupo = $_REQUEST['idgrupo'];
?>