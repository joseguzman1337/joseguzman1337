<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die;
require_once(PATH_SITE.'/control/ControlMenu.php');
require_once(PATH_SITE."/components/adminMenu/control/ControlAdminMenu.php");
require_once(PATH_SITE."/entidad/MenuOpcion.php");
require_once(PATH_SITE."/entidad/GerarquiaRol.php");
class AdminMenu implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type ControlAdminMenu Object
     * @access private
     */
    private $ControlAdminMenu;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        $array = array();
        //$variables->id = 512;
        //d($variables);
        $array['ControlMenu'] = new ControlMenu(null,$this->db);
        //ddd($array['ControlMenu']);
        $this->ControlAdminMenu = new ControlAdminMenu($variables);
        if(empty($variables->layout)){
            $array['listMenuOpcion'] = MenuOpcion::getListMenuOpcion();
        }elseif($variables->layout=="createEdit"){
            $array['listMenuOpcion'] = MenuOpcion::getListMenuOpcion();
            $array['listGerarquiaRol'] = GerarquiaRol::getListGerarquiaRol();
            //d($array['listGerarquiaRol']);
            $array['MenuOpcion'] = new MenuOpcion();
            if(!empty($variables->id)){ 
                $array['MenuOpcion']->setDb();
                $array['MenuOpcion']->setIdmenuopcion($variables->id);
                $array['MenuOpcion']->getMenuOpcionById();
            }
        }
        //d($array);
         
        return $array;
    }
}
