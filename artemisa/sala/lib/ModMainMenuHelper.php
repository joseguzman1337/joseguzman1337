<?php
/**
 * @package    Sala
 * @subpackage Modules menu
 * @license        GNU/GPL, see LICENSE.php 
 */
defined('_EXEC') or die;
require_once (PATH_SITE.'/control/ControlMenu.php'); 
class ModMainMenuHelper{
    /**
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getMenu($db, $parent_id=0) {
        
        $usuario=@$_SESSION['MM_Username'];
        $ControlMenu = new ControlMenu($usuario,$db);

        $menu = $ControlMenu->getMenu($parent_id);

        if( empty($menu) ){
            return array();
        }else{
            return ($menu);
        } 
    }
    
    public static function printMenuItem($db, $menu, $child=false ){
        //d($db);
        $usuario= Factory::getSessionVar('MM_Username');
        //d($usuario);
        $ControlMenu = new ControlMenu($usuario,$db);

        $li = $ControlMenu->printMenuItem($menu, $child );
        //ddd($li);

        return $li;
    }
}