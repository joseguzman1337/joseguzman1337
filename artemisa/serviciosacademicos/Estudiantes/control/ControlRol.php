<?php
/**
 * @author Diego Fernando Rivera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 * @since enero  23, 2017
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