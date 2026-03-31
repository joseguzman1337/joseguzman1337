<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die;
class Login implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        $array = array();
        $array['clavereq2'] = Factory::getSessionVar('2clavereq');
        $array['MM_Username'] = Factory::getSessionVar('MM_Username');
        return $array;
    }
}
