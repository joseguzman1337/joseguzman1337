<?php
   /**
    * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package entidades
    */
   
   class SituacionCarreraEstudiante{
   	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoSituacion; 
	
	/**
	 * @type string
	 * @access private
	 */
	private $nombreSituacion;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function SituacionCarreraEstudiante( $persistencia){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo de la situacion de la carrera del estudiante
	 * @param int $codigoSituacion
	 * @access public
	 * @return void
	 */
	public function setCodigoSituacion( $codigoSituacion ){
		$this->codigoSituacion = $codigoSituacion;
	}
	
	/**
	 * Retorna el codigo de la situacion de la carrera del estudiante
	 * @access public
	 * @return int
	 */
	public function getCodigoSituacion( ){
		return $this->codigoSituacion;
	}
	
	/**
	 * Modifica el nombre de la Situacion de la carrera del estudiante
	 * @param string $nombreSituacion
	 * @access public
	 * @return void
	 */
	public function setNombreSituacion( $nombreSituacion ){
		$this->nombreSituacion = $nombreSituacion;
	}
	
	/**
	 * Retorna el nombre de la Situacion de la carrera del estudiante
	 * @access public
	 * @return string
	 */
	public function getNombreSituacion( ){
		return $this->nombreSituacion;
	}
	
	
   }
?>