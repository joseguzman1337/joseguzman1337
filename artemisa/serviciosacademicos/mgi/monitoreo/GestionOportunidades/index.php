<?php
set_time_limit(30000);
ini_set('memory_limit', '64M');

/**
 * Se incluye el archivo de configuracion para tener acceso a todos sus parametros 
 * durante el transcurso de la aplicacion
 */

require_once(realpath ( dirname(__FILE__)."/../../../../sala/config/Configuration.php" ));
//require_once('config/Configuration.php');
$Configuration = Configuration::getInstance();

/**
 * Si la aplicacion se corre en un entorno local o de pruebas se activa la visualizacion 
 * de todos los errores de php
 */
if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"){
    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    /**
     * Se incluye la libreria Kint para hacer debug controlado de variables y objetos
     */
    require (PATH_ROOT.'/kint/Kint.class.php');
}
define("PATH_GESTION", PATH_ROOT.'/serviciosacademicos/mgi/monitoreo/GestionOportunidades');
define("HTTP_GESTION", HTTP_ROOT.'/serviciosacademicos/mgi/monitoreo/GestionOportunidades');
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
$variables->tmpl = "template";
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
/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */
Factory::validateSession($variables);

if(empty($action) && empty($option)){
    $option = "default";
    $variables->option = $option;
}

require_once (PATH_GESTION.'/control/ControlEjecucionGestionOportunidades.php');
$ControlEjecucionGestionOportunidades = new ControlEjecucionGestionOportunidades($variables, $Configuration);

/**
 * ejecuta las orden del action
 */
$ControlEjecucionGestionOportunidades->ejecutar($action);

/**
 * Redirige a la seccion indicada en el option (esto es para pintar secciones 
 * html) y el task se utiliza para ira  una subseccion especifica de la opcion
 */
$ControlEjecucionGestionOportunidades->ir(@$option, @$layout, @$task);/**/