<?php 
/* 
 * Archivo main
 * 
 * Este archivo es el punto de entrada para todas las acciones que se ejecutan 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque 
 * @package main
 */
set_time_limit(30000);
ini_set('memory_limit', '64M');

/**
 * Se incluye el archivo de configuracion para tener acceso a todos sus parametros 
 * durante el transcurso de la aplicacion
 */
require_once('config/Configuration.php');
$Configuration = Configuration::getInstance();

/**
 * Si la aplicacion se corre en un entorno local o de pruebas se activa la visualizacion 
 * de todos los errores de php
 */
$pos = strpos($Configuration->getEntorno(), "local");
if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"||$pos!==false){
    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    /**
     * Se incluye la libreria Kint para hacer debug controlado de variables y objetos
     */
    require (PATH_ROOT.'/kint/Kint.class.php');
}

/**
 * Se incluye la libreria Factory para tener acceso a todas sus metodos estaticos
 */
require_once (PATH_SITE.'/lib/Factory.php');

/**
 * El metodo Factory::importGeneralLibraries() incluye al sistema todas las librerias de caracter
 * general necesarias para el correcto funcionamiento de la aplicacion
 */
Factory::importGeneralLibraries();

/**
 * Se instancia el objeto estandar $variables, en el cual se setean todas las variables recibidas
 * por el sistema a nivel POST, GET y REQUEST, este Objeto $variables es utilizado en todo el sistema
 * para desligarce de los metodos de acceso estandares
 */
$variables = new stdClass();
$option = "";
$tastk = "";
$action = "";
if(!empty($_REQUEST)){
    $keys_post = array_keys($_REQUEST);
    foreach ($keys_post as $key_post) {
        $variables->$key_post = strip_tags(trim($_REQUEST[$key_post]));
        //d($key_post);
        switch($key_post){
            case 'option':
                @$option = $_REQUEST[$key_post];
                break;
            case 'task':
                @$task = $_REQUEST[$key_post];
                break;
            case 'action':
                @$action = $_REQUEST[$key_post];
                break;
            case 'layout':
                @$layout = $_REQUEST[$key_post];
                break;
                break;
            case 'itemId':
                @$itemId = $_REQUEST[$key_post];
                break;
        }
    }
}
//d($variables);
if(empty($action) && empty($option)){
    $option = "dashBoard";
    $variables->option = $option;
}
if(empty($itemId)){
    $variables->itemId = 0;
}


/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */
Factory::validateSession($variables);

/**
 * Se incluye el controlador gobal ControlEjecucionTareas encargado cargar los componentes/modulos
 * y ejecutar las acciones y tareas solicitadas
 */
require_once (PATH_SITE.'/control/ControlEjecucionTareas.php');

require_once(PATH_SITE."/includes/salaAutoloader.php");
spl_autoload_register('salaAutoloader');

$ControlEjecucionTareas = new ControlEjecucionTareas($variables, $Configuration);

/**
 * Ejecuta las orden del action
 */
$ControlEjecucionTareas->execute($action);

/**
 * Redirige a la seccion indicada en el option (esto es para pintar secciones html) y el task se utiliza 
 * para ir a una subseccion especifica de la opcion
 */
if(empty($layout)){
    $layout = 'default';
}
$ControlEjecucionTareas->go(@$option, @$layout, @$task);
