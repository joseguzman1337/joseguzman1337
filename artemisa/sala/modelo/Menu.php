<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die;
class Menu implements Model{
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
        //require_once (PATH_ROOT.'/vacoef/entidad/Banco.php');
        
        //$Banco = new Banco($this->db);
        //$array['listaBancos'] = $Banco->getListaBancos(100);
        
        return $array;
    }
}
