<?php
//session_start();
require_once( realpath( dirname(__FILE__)."/../../sala/config/Configuration.php" ) );
 
$Configuration = Configuration::getInstance();

if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"){
    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
}
require_once(PATH_ROOT.'/kint/Kint.class.php');
require_once(PATH_SITE.'/lib/Factory.php');
require_once(PATH_ROOT.'/assets/lib/View.php');
require_once(PATH_SITE.'/interfaces/Model.php');
require_once(PATH_SITE.'/entidad/Periodo.php');

$db = Factory::createDbo();

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

Factory::validateSession($variables);

$codigoperiodosesion = Factory::getSessionVar('codigoperiodosesion');
if(empty($codigoperiodosesion)){
    $_SESSION["1"] = 1;
    $PeriodoVigente = Periodo::getList(" codigoestadoperiodo=1 ");
    if(count($PeriodoVigente)===1){
        $PeriodoVigente = $PeriodoVigente[0];
    }else{
        $PeriodoVigente = new Periodo();
        $PeriodoVigente->setCodigoperiodo("20181");
        $PeriodoVigente->setDb();
        $PeriodoVigente->getById();
    }
    $codigoperiodosesion = $PeriodoVigente->getCodigoperiodo();
    Factory::setSessionVar("codigoperiodosesion", $codigoperiodosesion);
    Factory::setSessionVar('PeriodoSession', $PeriodoVigente);
}
//d($variables);
if(empty($action) && empty($option)){
    $option = "dashBoard";
    $variables->option = $option;
}
//d($variables);
$path = PATH_ROOT."/serviciosacademicos/PlanTrabajoDocenteV2";
$layout = $option;

if(!is_dir($path."/templates")){
    mkdir($path."/templates");
}

$modeloClass = ucfirst($option);
if(!is_file($path.'/modelo/'.$modeloClass.'.php')){
    $modeloClass = "Defecto";
}
require_once ($path.'/modelo/'.$modeloClass.'.php');

$Modelo = new $modeloClass($db);

/**
 * @modified Andres Ariza <arizaandres@unbosque.edu.do>
 * Se agrega la siguiente validacion para verificar que los clases Modelo implementen la interface Model
 * @since mayo 5, 2018
 */
if (!($Modelo instanceof Model)) {
    throw new Exception('El modelo '.$modeloClass.' no implementa la interface Model');
}

$array = array(); 
$array['variables'] = $variables;

$variablesModelo = $Modelo->getVariables($variables);

if(!empty($action)){
    $Modelo->$action($variables);
}

$array = array_merge($array,$variablesModelo); 

//d($array);

$view = new View($layout, $path, true); 
foreach($array as $k => $v){
    $view->assign($k, $v);
}
$return = $view->getResult();
echo $return;
