<?php
namespace Sala\utiles\SincronizarInscripcionEstudiante;
//home/arizaandres/Documentos/proyectoSala/sala/utiles/SincronizarInscripcionEstudiante/Fachada.php
require_once(realpath(dirname(__FILE__)."/../../includes/adaptador.php"));
require_once(PATH_SITE."/includes/salaAutoloader.php");

defined('_EXEC') or die;

spl_autoload_register('salaAutoloader');

use Sala\utiles\SincronizarInscripcionEstudiante\interfaces\IFacade;


use Sala\utiles\SincronizarInscripcionEstudiante\constructor\ConstructorInscripcionEstudiante;
use Sala\utiles\SincronizarInscripcionEstudiante\sintomasError\InspectorSintomasDesincronizacion;
use Sala\utiles\SincronizarInscripcionEstudiante\sincronizador\SincronizadorEstudianteInscripcion;
use Sala\utiles\SincronizarInscripcionEstudiante\entidadDTO\EstudianteDTO;
use Sala\utiles\SincronizarInscripcionEstudiante\entidadDTO\InscripcionDTO;

/**
 * @author arizaandres
 * @version 1.0
 * @created 13-Nov-2018 11:16:45 a.m.
 */
abstract class Fachada implements IFacade {
    function __construct() { }
    
    /**
     * 
     * @param idInscripcion
     * @param codigoEstudiante
     */
    public function construir($idInscripcion, $codigoEstudiante) {
        $ConstructorInscripcionEstudiante = new ConstructorInscripcionEstudiante($idInscripcion, $codigoEstudiante);
        $ConstructorInscripcionEstudiante->build();
        return $ConstructorInscripcionEstudiante;
    }
    
    public function sincronizar($codigoPeriodo, $codigoSituacionCarreraEstudiante, $codigoestudiante, $idinscripcion) {
        $SincronizadorEstudianteInscripcion = new SincronizadorEstudianteInscripcion($codigoPeriodo, $codigoSituacionCarreraEstudiante, $codigoestudiante, $idinscripcion);
        return $SincronizadorEstudianteInscripcion->sincronizar();
    }
    
    /**
     * 
     * @param codigoestudiante
     * @param idinscripcion
     */
    public function validarSintomas(EstudianteDTO $estudianteDTO, InscripcionDTO $inscripcionDTO){
        $InspectorSintomasDesincronizacion = new InspectorSintomasDesincronizacion($estudianteDTO, $inscripcionDTO);
        return $InspectorSintomasDesincronizacion->validarSintomas();
    } 
    
    public static function validarSintomasByDocumento($documento, $codigoPeriodo){
        return InspectorSintomasDesincronizacion::validarSintomasByDocumento($documento,$codigoPeriodo);
    }
    
    public static function getListaRegistrosSintomas($periodo){
        return InspectorSintomasDesincronizacion::getListaRegistrosSintomas($periodo);
    }

}
