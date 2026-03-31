<?php
/** 
 * @package    Sala
 * @subpackage Modules Logion
 * @license    GNU/GPL, see LICENSE.php 
 */
 
// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
 
$login = ModLoginSalaHelper::getLogin();
//ddd($menu);
$uriBase=JURI::base();
if($login){
	require JModuleHelper::getLayoutPath('mod_loginsala');
}else{
	$tmpl = JRequest::getVar('tmpl','index');
	if($tmpl!='login'){
		$allDone = JFactory::getApplication();
		//$allDone->redirect($uriBase.'?tmpl=login');
	}
	require JModuleHelper::getLayoutPath('mod_loginsala','needlogin');
}
