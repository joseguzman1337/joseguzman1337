<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */

 include '../entidades/Item.php';

 class ControlItem{
 	
	/**
	 * @type String
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	public function ControlItem( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Carga el menu principal
	 * @param Usuario $usuario
	 * @access public
	 * @return Array<Item>
	 */
	public function cargarMenu( $userMenu ){
		$item = new Item( $this->persistencia );
		return $item->cargarMenuPrincipal( $userMenu );
	}
	
	/**
	 * Carga el submenu principal
	 * @param Usuario $usuario
	 * @param int $idPadre
	 * @access public
	 * @return Arrray<Item>
	 */
	public function cargarSubMenu( $userMenu , $idPadre ){
		$item = new Item( $this->persistencia );
		return $item->cargarSubMenu( $userMenu , $idPadre );
	}
 }
?>