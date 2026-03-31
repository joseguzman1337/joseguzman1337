<?php
namespace Sala\lib\AdministracionPeriodos\api\clases\condicionesPeriodoAcademico;
defined('_EXEC') or die;

/**
 * Clase CambioEstadoPresencial encargado de las validaciones de cambios de 
 * estado en periodos academicos de modalidad Presencial
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\interfaces
 */
class CambioEstadoPresencial implements \Sala\lib\AdministracionPeriodos\api\interfaces\ICambioEstadoPeriodoAcademico{
    
    /**
     * $variables es una variable privada, contenedora de un objeto estandar en 
     * el cual se setean todas las variables recibidas por el sistema a nivel 
     * POST, GET y REQUEST
     * 
     * @var \stdClass
     * @access private
     */
    private $variables;

    /**
     * Constructor de la clase CambioEstadoPresencial
     * @param \stdClass $variables
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */ 
    public function __construct($variables) {
        $this->variables = $variables;
    }
    
    /**
     * El metodo validarEstado se encarga de la validacion de cambio de estado 
     * en periodos academicos de modalidad presencial, esta validacion garantiza
     * que la secuencia que se debe respetar es la siguiente
     * 2 > 4 > 1 > 3 > 2
     * Inactivo > Inscripciones > Vigente > Precierre > Inactivo
     * @param array $return Array con la estructura de respuesta json s => estado y msj => mensaje
     * @param \PeriodoAcademico $ePeriodoAcademico instancia de la entidad Periodo academico que se esta editando
     * @access public
     * @return array Se retorna un array con la estructura de respuesta json s => estado y msj => mensaje
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function validarEstado($return, \PeriodoAcademico $ePeriodoAcademico) {
        $idEstadoPeriodoAntiguo = $ePeriodoAcademico->getIdEstadoPeriodo();
        $idEstadoPeriodoNuevo = $this->variables->idEstadoPeriodo;
        $msj = "El nuevo estado debe cumplir la secuencia de modificación \"Inactivo > Inscripciones > Vigente > Precierre > Inactivo\"";
        
        switch ($idEstadoPeriodoNuevo){
            case "1"://Vigente
                if($idEstadoPeriodoAntiguo != 4 && $idEstadoPeriodoAntiguo != 1){
                    $return["s"] = false;
                    $return["msj"] = $msj;
                }else{
                    $activos = $this->validaEstadosIguales($idEstadoPeriodoNuevo);
                    
                    if(!empty($activos)){
                        $return["s"] = false;
                        $return["msj"] = "No puede haber 2 periodos academicos Vigentes simultaneamente para la misma modalidad y programa académico";
                    }
                }
                break;
            case "2"://Inactivo
                if($idEstadoPeriodoAntiguo != 3 && $idEstadoPeriodoAntiguo != 2){
                    $return["s"] = false;
                    $return["msj"] = $msj;
                }
                break;
            case "3"://Precierre
                if($idEstadoPeriodoAntiguo != 1 && $idEstadoPeriodoAntiguo != 3){
                    $return["s"] = false;
                    $return["msj"] = $msj;
                }else{
                    $precierre = $this->validaEstadosIguales($idEstadoPeriodoNuevo);
                    
                    if(!empty($precierre)){
                        $return["s"] = false;
                        $return["msj"] = "No puede haber 2 periodos academicos en Precierre simultaneamente para la misma modalidad y programa académico";
                    }
                }
                break;
            case "4"://Inscripciones
                if($idEstadoPeriodoAntiguo != 2 && $idEstadoPeriodoAntiguo != 4){
                    $return["s"] = false;
                    $return["msj"] = $msj;
                }else{
                    $inscripciones = $this->validaEstadosIguales($idEstadoPeriodoNuevo);
                    
                    if(!empty($inscripciones)){
                        $return["s"] = false;
                        $return["msj"] = "No puede haber 2 periodos academicos en Inscripciones simultaneamente para la misma modalidad y programa académico";
                    }
                }
                break;
        }

        return $return;
    }
    
    /**
     * El metodo validaEstadosIguales se encarga de la validar si un estado seleccionado
     * se encuentra en uso por otro para el mismo codigo de carrera y modalidad academica
     * @param int $idEstadoPeriodoNuevo Id del nuevo estado de periodo seleccionado
     * @access private
     * @return array Retorna array de Entidades PeriodoAcademico
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Marzo 04, 2019
    */
    private function validaEstadosIguales($idEstadoPeriodoNuevo){
        $db = \Factory::createDbo();
        
        $where  = " codigoModalidadAcademica = ".$db->qstr($this->variables->codigoModalidadAcademica)
        . " AND codigoCarrera = ".$db->qstr($this->variables->codigoCarrera)
        . " AND idEstadoPeriodo = ".$db->qstr($idEstadoPeriodoNuevo)
        . " AND id <> ".$db->qstr($this->variables->id);
        $iguales = \PeriodoAcademico::getList($where);
        
        return $iguales;
    }

}
