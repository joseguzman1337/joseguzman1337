<?php
/**
 * @package    Sala
 * @subpackage Modules menu
 * @license        GNU/GPL, see LICENSE.php 
 */
jimport('sala.menu.ControlMenu');
class ModMainMenuHelper
{
    /**
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getMenu($parent_id=0) {
    	/*$db = JFactory::getDBO();
		
		$query = "
			SELECT mu.idmenuopcion AS id, 
				   mu.idpadremenuopcion AS parent_id,
				   mu.nombremenuopcion AS text,
				   mu.linkmenuopcion AS link,
				   mu.framedestinomenuopcion AS linkTarget,
				   mi.fa_icon,
				   mi.image_path
			  FROM usuario u
		INNER JOIN permisousuariomenuopcion pumu ON u.idusuario = pumu.idusuario
		INNER JOIN permisomenuopcion pmu ON pumu.idpermisomenuopcion = pmu.idpermisomenuopcion
		INNER JOIN detallepermisomenuopcion dpmu ON pmu.idpermisomenuopcion = dpmu.idpermisomenuopcion
		INNER JOIN tipousuario tu ON u.codigotipousuario = tu.codigotipousuario
		INNER JOIN menuopcion mu ON dpmu.idmenuopcion = mu.idmenuopcion
		 LEFT JOIN sala_MenuIcon mi ON (mi.idmenuopcion = mu.idmenuopcion)
			 WHERE now() BETWEEN u.fechainiciousuario
			   AND u.fechavencimientousuario
			   AND pmu.codigoestado = 100
			   AND pumu.codigoestado = 100
			   AND dpmu.codigoestado = 100
			   AND mu.codigoestadomenuopcion = '01'
			   AND u.usuario = 'admintecnologia'
			   AND mu.idpadremenuopcion = ".$parent_id."
		  GROUP BY mu.idmenuopcion
		  ORDER BY mu.codigotipomenuopcion, mu.idpadremenuopcion, mu.posicionmenuopcion, mu.nombremenuopcion
		";
		//d($query);
		$db->setQuery($query);
		$menu = $db->loadObjectList();
		//var_dump($menu );
		$temp=array();
		foreach($menu as $m){
			$m->child = modMainMenuHelper::getMenu($m->id);
			$temp[] = $m;
		}
		$menu =  $temp;
		unset( $temp );/**/
		
		$ControlMenu = new ControlMenu('admintecnologia');
		
		$menu = $ControlMenu->getMenu($parent_id);
		
		if( empty($menu) ){
			return null;
		}else{
			return ($menu);
		} 
    }
    
    public static function printMenuItem( $menu, $child=false ){
		$ControlMenu = new ControlMenu('admintecnologia');
		
		$li = $ControlMenu->printMenuItem( $menu, $child );
		//ddd($li);
		
		return $li;
    }
}