<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die;
class moduloCalendarioInstitucional implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        require_once (PATH_SITE."/entidad/CalendarioInstitucional.php");
        $array = array();
        
        $eventos = CalendarioInstitucional::getByCodigoCarrera();
        $array["eventos"] = $eventos;
        
        //d($array);
        return $array;
    }
}
