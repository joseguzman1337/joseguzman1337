<?php

/**
 * Interface ICambioEstadoPeriodoAcademico para la implementacion de la familia 
 * de objetos encargados de las validaciones de cambios de estado en periodos 
 * academicos
 */

namespace Sala\lib\AdministracionPeriodos\api\interfaces;
defined('_EXEC') or die;

/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\interfaces
 * @since febrero 19, 2019
 */
interface ICambioEstadoPeriodoAcademico {
    
    /**
     * La implementacion del constructor del objeto concreto
     * @access public
     * @param \stdClass $variables
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function __construct($variables);
    /**
     * La implementacion de esta funcion debe encargarse de hacer la validacion
     * de los cambios de estado según corresponda a la familia seleccionada
     * @param array $return Array con la estructura de respuesta json s => estado y msj => mensaje
     * @param \PeriodoAcademico $ePeriodoAcademico instancia de la entidad Periodo academico que se esta editando
     * @access public
     * @return array Se retorna un array con la estructura de respuesta json s => estado y msj => mensaje
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function validarEstado($return, \PeriodoAcademico $ePeriodoAcademico);
}
