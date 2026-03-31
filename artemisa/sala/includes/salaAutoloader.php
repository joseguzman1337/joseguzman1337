<?php
function salaAutoloader($nombreClase){
    /**
     * Se instancia el objeto estandar $variables, en el cual se setean todas las variables recibidas
     * por el sistema a nivel POST, GET y REQUEST, este Objeto $variables es utilizado en todo el sistema
     * para desligarce de los metodos de acceso estandares
     */
    $variables = new \stdClass();
    $option = "";
    if(!empty($_REQUEST)){
        $keys_post = array_keys($_REQUEST);
        foreach ($keys_post as $key_post) {
            $variables->$key_post = strip_tags(trim($_REQUEST[$key_post]));
            //d($key_post);
            switch($key_post){
                case 'option':
                    @$option = $_REQUEST[$key_post];
                    break;
            }
        }
    }
    //d($variables);
    if(empty($action) && empty($option)){
        $option = "dashBoard";
        $variables->option = $option;
    }
    
    $controlClass = "Sala\\components\\".$option."\\control\\Control".ucfirst($option);
    $modeloClass = "Sala\\components\\".$option."\\modelo\\".ucfirst($option);
    
    $controlClassFile = "Control".ucfirst($option);
    $modeloClassFile = ucfirst($option);
    switch ($nombreClase){
        case ($nombreClase == $controlClass):
            $file = (PATH_SITE.'/components/'.$option.'/control/'.$controlClassFile.'.php');            //
            break;
        case ($nombreClase == $modeloClass):
            $file = (PATH_SITE.'/components/'.$option.'/modelo/'.$modeloClassFile.'.php');
            break;
        case "Sala\modelo\Defecto":
            $file = (PATH_SITE.'/modelo/Defecto.php');
            break;
        case "Sala\control\ControlRender":
            $file = (PATH_SITE.'/control/ControlRender.php');
            break;
        case "Configuration":
            $file = (PATH_SITE.'/config/Configuration.php');
            break;
        default:
            $file = PATH_ROOT. "/" . str_replace('\\', '/', lcfirst($nombreClase)) . '.php'; 
            if (!file_exists($file)) {
                $file = PATH_ROOT. "/sala/entidad/" . str_replace('\\', '/', ucfirst($nombreClase)) . '.php';
            }
            break;
    }
    //d($file);
    if (file_exists($file)) {
        require_once $file;
    }
    //echo $nombreClase."<BR>";
    //var_dump($_REQUEST);
    //exit;
}

require_once(PATH_SITE."/interfaces/Entidad.php");
require_once(PATH_SITE."/interfaces/Model.php");
require_once(PATH_SITE."/entidad/Carrera.php");
require_once(PATH_SITE."/entidad/Usuario.php");
require_once(PATH_SITE."/entidad/Periodo.php");
require_once(PATH_SITE."/entidad/PeriodoVirtualCarrera.php");
use \Sala\interfaces\Model;
use \Sala\interfaces\Entidad;
use \Sala\entidad\Carrera;
use \Sala\entidad\Usuario;
use \Sala\entidad\Periodo;
use \Sala\entidad\PeriodoVirtualCarrera;

