<?php
/** 
 * @package    Sala
 * @subpackage Modules menu
 * @license    GNU/GPL, see LICENSE.php 
 */
 
// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
 
$menu = modMainMenuHelper::getMenu();
//ddd($menu);
$uriBase=JURI::base();

require JModuleHelper::getLayoutPath('mod_mainmenu');