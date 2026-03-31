<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */

 include '../entidades/Facultad.php';
 
 class ControlFacultad{
 	
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
	public function ControlFacultad( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Consulta los periodos
	 * @access public
	 * @return Array<Periodo>
	 */
	public function consultar( $idPersona ){
		$facultad = new Facultad( $this->persistencia );
		return $facultad->consultarFacultades( $idPersona );
	}
	
	/**
	 * Consulta los periodos
	 * @access public
	 * @return Array<Periodo>
	 */
	public function consultarFacultad( ){
		$facultad = new Facultad( $this->persistencia );
		return $facultad->consultar( );
	}
	
	/**
	 * Busca una Facultad por CódigoCarrera
	 * @param int $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarFacultad( $txtCodigoCarrera ) {
		$facultad = new Facultad( $this->persistencia );
		$facultad->buscarFacultad( $txtCodigoCarrera );
		return $facultad;
	}
 }
?>