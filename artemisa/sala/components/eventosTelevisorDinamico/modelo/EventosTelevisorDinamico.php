<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die;
class EventosTelevisorDinamico implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function EventosTelevisorDinamico($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        $array = array(); 
        
        /// equipomgi
        /*$controlRender = new ControlRender();
        $menu = $controlRender->render("menu",$array, true);
        $array["menu"] = $menu;/**/
        
        //d($array);
        return $array;
    }
}
