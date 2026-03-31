<?php
   /**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package control
 */

//include '../entidades/PlanEstudio.php';


	class ControlPlanEstudio {
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlPlanEstudio( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
}
?>