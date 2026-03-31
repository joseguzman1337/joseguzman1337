<?php 
/* 
 * @author Andres Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque 
 */

/*/
@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
/**/

/**
 * @modified Andres Aroza <arizaandres@unbosque.edu.do>
 * Se agrega el archivo de configuracion  y conexion a bases de datos utilizados en /sala para unificar conexiones
 * y trabajar con bases de datos persistentes
 * @since Septiembre 10, 2018
 */

require_once(realpath ( dirname(__FILE__)."/../../sala/config/Configuration.php" ));
$Configuration = Configuration::getInstance();
require_once (PATH_SITE."/lib/Factory.php");
$db = Factory::createDbo();

require_once (PATH_ROOT.'/kint/Kint.class.php');

require (PATH_ROOT.'/assets/lib/CurlRestFul.php');

require(PATH_ROOT.'/serviciosacademicos/Connections/sala2.php');


$variables = new stdClass();
$option = "";
$tastk = "";
$action = "";
if(!empty($_POST)){
    $keys_post = array_keys($_POST);
    foreach ($keys_post as $key_post) {
        $variables->$key_post = strip_tags(trim($_POST[$key_post]));
        switch($key_post){
            case 'registro':
                $variables->$key_post = str_replace(" ", "", strtoupper($variables->$key_post));
                break;
            case 'option':
                $option = $_POST[$key_post];
                break;
            case 'task':
                $tastk = $_POST[$key_post];
                break;
            case 'action':
                $action = $_POST[$key_post];
                break;
        }
    }
}
	
if(!empty($_GET)){
    $keys_get = array_keys($_GET); 
    foreach ($keys_get as $key_get){ 
        $variables->$key_get = strip_tags(trim($_GET[$key_get]));
        switch($key_get){
            case 'registro':
                $variables->$key_get = str_replace(" ", "", strtoupper($variables->$key_get));
                break;
            case 'option':
                $option = $_GET[$key_get];
                break;
            case 'task':
                $tastk = $_GET[$key_get];
                break;
            case 'action':
                $action = $_GET[$key_get];
                break;
        }
    } 
}

switch ($action){
    case 'consultarPIR':
        $respuesta = new stdClass(); 
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/control/ControlConsultarPIR.php');
        $ControlConsultarPIR = new ControlConsultarPIR($variables->tipoDocumento, $variables->numeroDocumento, $variables->registro, $variables->idEstudianteGeneral);
        //d($variables);
        $at = $ControlConsultarPIR->getAccessToken();
        //d($at);
        if(!empty($at->status) || is_string($at) ){
            $respuesta->s = false;
            $respuesta->msj = "No es posible establecer conexion con el Ministerio de Educación para consultar datos del ICFES";
        }else{
            $ControlConsultarPIR->consultarResultadosPIR();
            $respuestaPIR = $ControlConsultarPIR->getResultadosPIR();
            //ddd($ControlConsultarPIR);
            if(!empty($respuestaPIR->status)){
                $respuesta->s = false;
                $respuesta->msj = "Puede que los datos que esta enviando no concuerden en la base de datos del Ministerio de Educación, por favor valide que esten correctos.";
            }else{
                $respuesta = $ControlConsultarPIR->actualizarResultadosSALA($db);
                //ddd($respuesta);
                if($respuesta->s){
                    $ControlConsultarPIR->storeDocumentoAc($db);
                }
                
            }
        }
        echo json_encode($respuesta);
        break;/**/ 
    case 'consultarEstructuraPIR':
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/control/ControlConsultarPIR.php');
        //ddd($variables);
        $periodo = ControlConsultarPIR::abstraerPeriodo($variables->registro);
        //d($periodo);
        $estructura = ControlConsultarPIR::getEstructuraExamen($db, $periodo);
        $respuesta = new stdClass();
        if(!empty($estructura)){
            $respuesta->s = true;
            $respuesta->estructura = $estructura;
            $respuesta->msj = "Este periodo tiene relacionada la estructura ".$estructura." en la base respuestas del PIR";
        }else{
            $respuesta->s = false;
        }
        echo json_encode($respuesta);
        break;
    case "validarIdestudiantegeneralAC":
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/DocumentoPresentacionPruebaEstado.php');
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/entidad/ResultadoPruebaEstado.php');
        
        $ResultadoPruebaEstado = new ResultadoPruebaEstado($db);
        $ResultadoPruebaEstado->setIdestudiantegeneral($variables->idestudiante);
        $ResultadoPruebaEstado->setNumeroregistroresultadopruebaestado($variables->registro);
        $ResultadoPruebaEstado->getResultadoEsutiante();
        //d($ResultadoPruebaEstado);
        $DocumentoPresentacionPruebaEstado = new DocumentoPresentacionPruebaEstado($db, $variables->idestudiante, $variables->tipoDocumento, $variables->numeroDocumento);
        $idEstudianteBD = $DocumentoPresentacionPruebaEstado->consultarIdEsutianteGeneral();
        
        $respuesta = new stdClass();
        $respuesta->s = false;
        $respuesta->msj = "El documento ".$variables->tipoDocumento." numero ".$variables->numeroDocumento." esta asignado a otro estudiante y no puede ser utilizado";
        //d($idEstudianteBD);
        //d($variables);
        if(empty($idEstudianteBD) || ($idEstudianteBD==$variables->idestudiante)){
            $respuesta->s = true;
            $respuesta->msj = "El documento puede ser utilizado";
        } 
        echo json_encode($respuesta);
        break;
    case "actualizacionMasiva":
        require_once (PATH_ROOT.'/serviciosacademicos/PIR/control/ControlConsultarPIR.php');
        $status = ControlConsultarPIR::ejecutarActualizacionMasiva($db); 
        break;
}