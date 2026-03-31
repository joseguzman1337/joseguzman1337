<?php
/**
 * @package    Sala
 * @subpackage Modules Login
 * @license        GNU/GPL, see LICENSE.php 
 */
class ModLoginSalaHelper
{
    /**
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getLogin($parent_id=0) {
    	$db = JFactory::getDBO();
		$session = JFactory::getSession();
		$test = $session->get('test',0);
		
		$session->set( 'test', ($test+1) );
		echo $session->get('test', 'null no existe? ');
		//ddd($session);
		
		$salaSessionVar = $session->get( 'salaSessionVar', null );
		if(!empty($salaSessionVar)){
			foreach ($salaSessionVar as $k=>$v){
				$_SESSION[$k] = $v;
			}
		}
		if(  !empty($salaSessionVar['MM_Username'])){ 
			return true;
		}else{
			//return false;
			return true;
		}
    } 
    /**
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getUserData($parent_id=0) {
    	$db = JFactory::getDBO();
		$session = JFactory::getSession();
		$sessionSave = $session->get( 'sessionSave', null ); 
		if(!empty($sessionSave)){
			foreach ($sessionSave as $k=>$v){
				$_SESSION[$k] = $v;
			}
		}
		if( !empty($_SESSION['MM_Username']) || !empty($sessionSave['MM_Username'])){ 
			return true;
		}else{
			return false;
		}
    } 
}