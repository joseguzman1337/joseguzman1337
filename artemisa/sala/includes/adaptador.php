<?php
/**
 * Este archivo contiene las la importacion de las clases configuracion, kint, y
 * factory que son los minimos requeridos para hacer compatibles los archivos 
 * del antiguo sala con las nuevas funcionalidades
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since  Septiembre 28 2018
 * @package includes
 */

require_once(realpath(dirname(__FILE__)."/../config/Configuration.php"));
$Configuration = Configuration::getInstance();
require_once (PATH_ROOT.'/kint/Kint.class.php');

require_once (PATH_SITE.'/lib/Factory.php');

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
    $option = null;
    $variables->option = $option;
}
if(empty($itemId)){
    $variables->itemId = 0;
}

$db = Factory::createDbo();