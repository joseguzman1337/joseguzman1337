<?php 
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    $rutaVistas  = "../view"; /*carpeta donde se guardaran las vistas (html) de la aplicación */ 
    require_once(realpath(dirname(__FILE__))."/../../../Mustache/load.php"); /*Ruta a /html/Mustache */
    $template_index = $mustache->loadTemplate('LogHecaa'); /*carga la plantilla index*/
    //require_once('/../funciones/obtener_datos_hecca.php');
    
    //Conexion de base de datos
    include_once (realpath(dirname(__FILE__)).'/../../EspacioFisico/templates/template.php');
    $db = getBD();    
    
    $sql_reportes= "SELECT log.LogReportesHecaaId, log.Variable, log.Usuario, log.RegistrosReportados, log.CodigoPeriodo, log.FechaReporte FROM LogReportesHecaa log ORDER BY FechaReporte desc";    
    $datos_reportes = $db->GetAll($sql_reportes); 

 
    echo $template_index->render(array(
            'title' => 'LOG DE REPORTES HECAA',
            'reportes' => $datos_reportes
        )
    );
?>