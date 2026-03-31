<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */

 require_once '../entidades/UnidadAdministrativa.php';
 require_once '../entidades/ReporteFacultades.php';
 
 class ControlUnidadAdministrativa{
	 
	 /**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	 
	 /**
	 * Constructor
	 * @param Singleton $persistencia
	 * @access public
	 */
	public function ControlUnidadAdministrativa( $persistencia ){
		$this->persistencia = $persistencia;
	}
	 
	 /*
	*Consulta la informacion de las unidades administrativas que tienen datos del plan desarrollo
	*Ivan Quintero Febrero 22, 2017
	*/
	 public function ConsultaUnidadAdministrativa()
	 {
	 	$UnidadAdministrativa = new UnidadAdministrativa($this->persistencia);
		return $UnidadAdministrativa->buscarUnidadAdministrativas();
	 }
 	
 }
?>