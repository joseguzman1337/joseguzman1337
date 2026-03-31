<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class PazySalvo{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $idPazySalvo;
	
	/**
	 * @type Carrera
	 * @access private
	 */
	private $carrera;
	
	/**
	 * @type Periodo
	 * @access private
	 */
	private $periodo;
	
	/**
	 * @type Estudiante
	 * @access private
	 */
	private $estudiante;
	
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function PazySalvo( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador del Paz y Salvo
	 * @param int $idPazySalvo
	 * @access public
	 * @return void
	 */
	public function setIdPazySalvo( $idPazySalvo ){
		$this->idPazySalvo = $idPazySalvo;
	}
	
	/**
	 * Retorna el identificador del Paz y Salvo
	 * @access public
	 * @return int
	 */
	public function getIdPazySalvo( ){
		return $this->idPazySalvo;
	}
	
	/**
	 * Modifica la carrera del paz y salvo
	 * @param Carrera $carrera
	 * @access public
	 * @return void
	 */
	public function setCarrera( $carrera ){
		$this->carrera = $carrera;
	}
	
	/**
	 * Retorna la carrera del paz y salvo
	 * @access public
	 * @return Carrera
	 */
	public function getCarrera( ){
		return $this->carrera;
	}
	
	/**
	 * Modifica el periodo del paz y salvo 
	 * @param Periodo $periodo
	 * @access public
	 * @return void
	 */
	public function setPeriodo( $periodo ){
		$this->periodo = $periodo;
	}
	
	/**
	 * Retorna el periodo del paz y salvo
	 * @access public
	 * @return Periodo
	 */
	public function getPeriodo( ){
		return $this->periodo;
	}
	
	/**
	 * Modifica el detalle del paz y salvo
	 * @param DetallePazySalvo $detallePazySalvo
	 * @access public
	 * @return void
	 */
	public function setEstudiante( $estudiante ){
		$this->estudiante = $estudiante;
	}
	
	/**
	 * Retorna el detalle del paz y salvo
	 * @access public
	 * @return DetallePazySalvo
	 */
	public function getEstudiante( ){
		return $this->estudiante;
	}
	
  }
?>