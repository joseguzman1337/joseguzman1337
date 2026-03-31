<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */

 include '../entidades/Periodo.php';
 
 class ControlPeriodo{
 	
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
	public function ControlPeriodo( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Consulta los periodos
	 * @access public
	 * @return Array<Periodo>
	 */
	public function consultar( ){
		$periodo = new Periodo( $this->persistencia );
		return $periodo->consultarPeriodo( );
	}
	
	/**
	 * Busca Periodo Activo
	 * @access public
	 * @return Codigo Periodo
	 */
	public function buscarPeriodo( ){
		$periodo = new Periodo( $this->persistencia );
		$periodo->buscarPeriodoActivo( );
		return $periodo;
	}
 }
 
?>