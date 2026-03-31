<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */

 require_once '../entidades/Facultad.php';
 require_once '../entidades/ReporteFacultades.php';
 
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
	public function consultarFacultad($idperseona= null ){
		$facultad = new Facultad( $this->persistencia );
		return $facultad->consultar( $idperseona);
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
	
	/**
	 * Busca una Facultad por CodigoFacultad
	 * @param int $txtCodigoFacultad
	 * @access public
	 * @return void
	 */
	public function buscarFacultadId( $txtCodigoFacultad ) {
		$facultad = new Facultad( $this->persistencia );
		$facultad->buscarFacultadId( $txtCodigoFacultad );
		return $facultad;
	}
	 
	/*
	*Consulta la informacion de las faculatdes que tienen datos del plan desarrollo
	*Ivan Quintero Febrero 22, 2017
	*/
	public function consultaReporteFacultades($Codigofacultad= null, $codigoperiodo= null)
	{
		$facultad = new ReporteFacultades($this->persistencia);
		return $facultad->consulta($Codigofacultad, $codigoperiodo);
	}
	 
 }
?>
