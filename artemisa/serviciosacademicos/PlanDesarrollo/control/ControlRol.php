<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */


include '../entidades/Rol.php';


class ControlRol {
	
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		

	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlRol( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
}
?>