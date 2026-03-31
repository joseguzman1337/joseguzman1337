<?php
require_once(realpath(dirname(__FILE__)."/../../includes/adaptador.php"));

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
    require_once (PATH_ROOT.'/kint/Kint.class.php');
}

/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */
Factory::validateSession($variables);

require_once(PATH_SITE."/utiles/SincronizarInscripcionEstudiante/Fachada.php");
use Sala\utiles\SincronizarInscripcionEstudiante\Fachada;

class localFachada extends Fachada{
    function __construct() {
        
    } 
}

switch($variables->accion){
    case "sincronizar":
        $localFachada = new localFachada();
        $constructor = $localFachada->construir($variables->idinscripcion, $variables->codigoestudiante);
        $tieneSintomas = $localFachada->validarSintomas($constructor->getEstudiante(), $constructor->getinscripcion());

        $arrayResuesta = array();
        $arrayResuesta['s'] = true;
        $arrayResuesta['msj'] = "";

        if($tieneSintomas){
            $rs = $localFachada->sincronizar($variables->periodo, $constructor->getInscripcion()->getCodigosituacioncarreraestudiante(), $constructor->getEstudiante()->getCodigoestudiante(),  $constructor->getInscripcion()->getIdinscripcion());
            if($rs){
                $arrayResuesta['msj'] = "Sincronización exitosa";
            }else{
                $arrayResuesta['s'] = false;
                $arrayResuesta['msj'] = "Error de sincronización";
            }
        }else{
            $arrayResuesta['s'] = false;
            $arrayResuesta['msj'] = "No tiene sintomas de desincronización"; 
        }
        echo json_encode($arrayResuesta);
        break;
    case "procesarPeriodo":
        $datosSintomasDesincronizacion = localFachada::getListaRegistrosSintomas($variables->periodo);
        
        foreach($datosSintomasDesincronizacion as $d){
            $localFachada = new localFachada();
            
            $constructor = $localFachada->construir($d['idinscripcion'], $d['codigoestudiante']);
            $rs = $localFachada->sincronizar($constructor->getInscripcion()->getCodigoperiodo(), $constructor->getInscripcion()->getCodigosituacioncarreraestudiante(), $constructor->getEstudiante()->getCodigoestudiante(),  $constructor->getInscripcion()->getIdinscripcion());
            unset($constructor);
            unset($localFachada);
            
            if($rs){
                echo "</br> sincronizados ".$d['idinscripcion']." - ".$d['codigoestudiante'];
            }
        }
        break;
}
