<?php

/**
 * Interface ICambioEstadoPeriodoAcademico para la implementacion de la familia 
 * de objetos encargados de la carga de los combos de actualizacion dinamica en
 * los formularios de edicion de los periodos
 */

namespace Sala\lib\AdministracionPeriodos\api\interfaces;
defined('_EXEC') or die;

/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\interfaces
 * @since febrero 19, 2019
 */
interface ICombosPeriodo {
    
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
     * La implementacion de este metodo inicializa el atributo variables con 
     * el objeto variables recibido mediante el REQUEST
     * @access public
     * @param \stdClass $variables Variables recibidas del REQUEST
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function setVariables($variables);
    
    /**
     * La implementacion de este metodo retorna el combo de opciones deacuerdo
     * a las variables seleccionadadas
     * @access public
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje  y options => combo resultado
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function getCombo();
}
