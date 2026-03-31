<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaces
 */
defined('_EXEC') or die;
interface Entidad {
    /**
     * Instancia el objeto db para la conexion a bases de datos
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     * @since mayo 3, 2018
    */
    public function setDb();
    
    /**
     * Hace una consulta con el primary key de la tabla a bases de datos y rellena todos los atriburos con el resultado devuelto
     * @access public
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     * @since mayo 3, 2018
    */
    public function getById();
    
    /**
     * Hace una consulta a la tabla en bases de datos con las condiciones de la variable where 
     * y retorna un array de Entidad con los resultados de la consulta
     * @access public
     * @param String $where
     * @return array of Entidad
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     * @since mayo 3, 2018
    */
    public static function getList($where);
}
