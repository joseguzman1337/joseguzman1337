<?php
namespace Sala\interfaces;
defined('_EXEC') or die;
//use Entidad;


/**
 * Interface EntidadDAO para la persistencia de datos en base de datos de las
 * tablas que se utilicen en el aplicativo
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaces
 */
interface EntidadDAO {

    /**
     * Hace una consulta DML de tipo insert o update para las persistencias de 
     * datos en las tablas que utilicen el aplicativo
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since noviembre 15, 2018
    */
    public function save();
    
    /**
     * Instancia el objeto db para la conexion a bases de datos
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     * @since febrero 5, 2019
    */
    public function setDb();
    
    /**
     * Guarda en la tabla logAuditoria las modificaciones hechas durante el save
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     * @since febrero 11, 2019
    */
    public function logAuditoria($e, $query);
}
