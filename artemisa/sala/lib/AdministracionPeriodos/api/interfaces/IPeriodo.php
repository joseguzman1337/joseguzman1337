<?php

/**
 * Interface IPeriodo para la implementacion de la familia de objetos encargados 
 * de la orquestacion de las funcionalidades que controlan al tipo de periodo
 */

namespace Sala\lib\AdministracionPeriodos\api\interfaces;
defined('_EXEC') or die;

/*
 * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\interfaces
 * @since febrero 19, 2019
 */
interface IPeriodo {
    
    /**
     * La implementacion del constructor del objeto concreto
     * @access public
     * @return void
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function __construct();
    
    /**
     * La implementacion de este metodo inicializa el atributo variables con 
     * el objeto variables recibido mediante el REQUEST
     * @access public
     * @param \stdClass $variables Variables recibidas del REQUEST
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function setVariables($variables);

    /**
     * La implementacion de este metodo retornará las variables requeridas en 
     * la vista listar de cada tipo de periodo
     * @access public
     * @return array Variables necesarias para la vista listar de cada tipo de periodo
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function listarPeriodo();

    /**
     * La implementacion de este metodo retornará las variables requeridas en 
     * la vista para crear/editar de cada tipo de periodo
     * @access public
     * @return array Variables necesarias para la vista listar de cada tipo de periodo
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function nuevoPeriodo();

    /**
     * La implementacion de este metodo retornará un array de DTOs de las entidades
     * del tipo de periodo seleccionado
     * @access public
     * @param string $where Si es necesaria, una condicion para filtrar la lista de entidades
     * @return array Array de DTOs de las entidades del tipo de periodo seleccionado
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function getList($where);

    /**
     * La implementacion de este metodo guardará en base de datos el objeto creado/editado
     * desde la vista de creacion/edicion
     * @access public
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function guardarPeriodo();

    /**
     * La implementacion de este metodo se encargará de la validacion de los datos del periodo
     * @access public
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function validarPeriodo();
}
