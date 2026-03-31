<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class Cohorte{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $id;
	
	
	/**
	 * @type int
	 * @access private
	 */
	private $numeroCohorte;
	
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
	 * @type int
	 * @access private
	 */
	private $estado;
	
	/**
	 * @type Jornada
	 * @access private
	 */
	private $jornada;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function Cohorte( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador del cohorte
	 * @param int $id
	 * @access public
	 * @return void
	 */
	public function setIdCohorte( $id ){
		$this->id = $id;
	}
	
	/**
	 * Retorna el identificador del cohorte
	 * @access public
	 * @return int
	 */
	public function getIdCohorte( ){
		return $this->id;
	}
	
	/**
	 * Modifica el numero del cohorte
	 * @param int $numeroCohorte
	 * @access public
	 * @return void
	 */
	public function setNumeroCohorte( $numeroCohorte ){
		$this->numeroCohorte = $numeroCohorte;
	}
	
	/**
	 * Retorna el numero del cohorte
	 * @access public
	 * @return int
	 */
	public function getNumeroCohorte( ){
		return $this->numeroCohorte;
	}
	
	/**
	 * Modifica la carrera del Cohorte
	 * @param Carrera $carrera
	 * @access public 
	 * @return void 
	 */
	public function setCarrera( $carrera ){
		$this->carrera = $carrera;
	}
	
	/**
	 * Retorna la carrera del Cohorte
	 * @access public
	 * @return Carrera
	 */
	public function getCarrera( ){
		return $this->carrera;
	}
	
	/**
	 * Modifica el periodo del Cohorte
	 * @param Periodo $periodo
	 * @access public
	 * @return void
	 */
	public function setPeriodo( $periodo ){
		$this->periodo = $periodo;
	}
	
	/**
	 * Retorna el periodo del Cohorte
	 * @access public
	 * @return Periodo
	 */
	public function getPeriodo( ){
		return $this->periodo;
	}
	
	/**
	 * Modifica el estado del cohorte
	 * @param int $estado
	 * @access public
	 * @return void
	 */
	public function setEstado( $estado ){
		$this->estado = $estado;
	}
	
	/**
	 * Retorna el estado del cohorte
	 * @access public
	 * @return int
	 */
	public function getEstado( ){
		return $this->estado;
	}
	
	/**
	 * Modifica la Jornada del Cohorte
	 * @param Jornada $jornada
	 * @access public
	 * @return void
	 */
	public function setJornada( $jornada ){
		$this->jornada = $jornada;
	}
	
	/**
	 * Retorna la Jornada del Cohorte
	 * @access public
	 * @return Jornada
	 */
	public function getJornada( ){
		return $this->jornada;
	}
	
  }
?>