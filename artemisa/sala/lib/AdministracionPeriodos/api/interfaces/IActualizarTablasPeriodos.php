<?php

/**
 * Interface IActualizarTablasPeriodos para la implementacion de la familia 
 * de objetos encargados de la actualizacion de las tablas de periodo sobre 
 * las cuales el sala legado se ejecuta y alimenta
 */

namespace Sala\lib\AdministracionPeriodos\api\interfaces;
defined('_EXEC') or die;

/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\interfaces
 * @since marzo 12, 2019
 */
interface IActualizarTablasPeriodos {
    
    /**
     * La implementacion del constructor del objeto concreto
     * @access public
     * @param \Entidad $entidad
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public function __construct($entidad);
    
    /**
     * La implementacion de esta funcion debe encargarse de hacer la validacion
     * y actualizacion de los registros de la tabla periodo con base en la información 
     * ingresada
     * @access public
     * @return boolena Retorna true o false del exito de la actualización
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public function actualizarTablaPeriodo( );
    
    /**
     * La implementacion de esta funcion debe encargarse de hacer la validacion
     * y actualizacion de los registros de la tabla subperiodo con base en la información 
     * ingresada
     * @access public
     * @return boolena Retorna true o false del exito de la actualización
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public function actualizarTablaSubperiodo( );
    
    /**
     * La implementacion de esta funcion debe encargarse de hacer la validacion
     * y actualizacion de los registros de la tabla carreraperiodo con base en la información 
     * ingresada
     * @access public
     * @return boolena Retorna true o false del exito de la actualización
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public function actualizarTablaCarreraPeriodo( );
}
