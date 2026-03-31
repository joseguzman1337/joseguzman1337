<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package
   */
  
  class TipoEstudiante{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoTipo;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreTipo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoReferenciaTipo;
	
	/**
	 * @type Singleton
	 * @access public
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function TipoEstudiante( $persistencia){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo del Tipo de Estudiante
	 * @param int $codigoTipo
	 * @access public
	 * @return void
	 */
	public function setCodigoTipo( $codigoTipo ){
		$this->codigoTipo = $codigoTipo;
	}
	
	/**
	 * Retorna el codigo del Tipo de Estudiante
	 * @access public
	 * @return int
	 */
	public function getCodigoTipo( ){
		return $this->codigoTipo;
	}
	
	/**
	 * Modifica el nombre del Tipo de Estudiante
	 * @param string $nombreTipo
	 * @access public
	 * @return void
	 */
	public function setNombreTipo( $nombreTipo ){
		$this->nombreTipo = $nombreTipo;
	}
	
	/**
	 * Retorna el nombre del Tipo de Estudiante
	 * @access public
	 * @return string
	 */
	public function getNombreTipo( ){
		return $this->nombreTipo;
	}
	
	/**
	 * Modifica el codigo de referencia del tipo de estudiante
	 * @param int $codigoReferenciaTipo
	 * @access public 
	 * @return void
	 */
	public function setCodigoReferenciaTipo( $codigoReferenciaTipo ){
		$this->codigoReferenciaTipo = $codigoReferenciaTipo;
	}
	
	/**
	 * Retorna el codigo de referencia del tipo de estudiante
	 * @access public
	 * @return int
	 */
	public function getCodigoReferenciaTipo( ){
		return $this->codigoReferenciaTipo;
	}
	
  }
?>