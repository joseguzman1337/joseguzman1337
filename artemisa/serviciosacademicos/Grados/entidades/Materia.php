<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class Materia{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoMateria;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreMateria;
	
	/**
	 * @type Periodo
	 * @access private
	 */
	private $periodo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $numeroCreditos;
	
	/**
	 * @type decimal
	 * @access private
	 */
	private $notaMinima;
	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoIndicador;
	
	/**
	 * @type ModalidadMateria
	 * @access private
	 */
	private $modalidadMateria; 
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoMateria;
	
	/**
	 * @type TipoMateria
	 * @access private
	 */
	private $tipoMateria;
	
	/**
	 * @type Carrera
	 * @access private
	 */
	private $carrera;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia
	 */
	public function Materia( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo de la materia
	 * @param int $codigoMateria
	 * @access public
	 * @return void
	 */
	public function setCodigoMateria( $codigoMateria ){
		$this->codigoMateria = $codigoMateria;
	}
	
	/**
	 * Retorna el codigo de la materia
	 * @access public
	 * @return int
	 */
	public function getCodigoMateria( ){
		return $this->codigoMateria;
	}
	
	/**
	 * Modifica el nombre de la materia
	 * @param string $nombreMateria
	 * @access public
	 * @return void
	 */
	public function setNombreMateria( $nombreMateria ){
		$this->nombreMateria = $nombreMateria;
	}
	
	/**
	 * Retorna el nombre de la materia
	 * @access public
	 * @return string
	 */
	public function getNombreMateria( ){
		return $this->nombreMateria;
	}
	
	/**
	 * Modifica el periodo de la materia
	 * @param Periodo $periodo
	 * @access public
	 * @return void
	 */
	public function setPeriodo( $periodo ){
		$this->periodo = $periodo;
	}
	
	/**
	 * Retorna el periodo de la materia
	 * @access public
	 * @return Periodo
	 */
	public function getPeriodo( ){
		return $this->periodo;
	}
	
	/**
	 * Modifica el numero de creditos de la materia
	 * @param int $numeroCreditos
	 * @access public
	 * @return void
	 */
	public function setNumeroCreditos( $numeroCreditos ){
		$this->numeroCreditos = $numeroCreditos;
	}
	
	/**
	 * Retorna el numero de creditos de la materia
	 * @access public
	 * @return int
	 */
	public function getNumeroCreditos( ){
		return $this->numeroCreditos;
	}
	
	/**
	 * Modifica la nota minima de la materia
	 * @param decimal $notaMinima
	 * @access public
	 * @return void
	 */
	public function setNotaMinima( $notaMinima ){
		$this->notaMinima = $notaMinima;
	}
	
	/**
	 * Retorna la nota minima de la materia
	 * @access public
	 * @return decimal
	 */
	public function getNotaMinima( ){
		return $this->notaMinima;
	}
	
	/**
	 * Modifica el codigo indicador del grupo de la materia
	 * @param decimal $notaMinima
	 * @access public
	 * @return void
	 */
	public function setCodigoIndicador( $codigoIndicador ){
		$this->codigoIndicador = $codigoIndicador;
	}
	
	/**
	 * Retorna el codigo indicador del grupo de la materia
	 * @access public
	 * @return int
	 */
	public function getCodigoIndicador( ){
		return $this->codigoIndicador;
	}
	
	/**
	 * Modifica la modalidad academica de la materia
	 * @param ModalidadAcademica $modalidadAcademica
	 * @access public
	 * @return void
	 */
	public function setModalidadAcademica( $modalidadMateria ){
		$this->modalidadMateria = $modalidadMateria;
	}
	
	/**
	 * Retorna la modalidad academica de la materia
	 * @access public
	 * @return ModalidadAcademica
	 */
	public function getModalidadAcademica( ){
		return $this->modalidadMateria;
	}
	
	/**
	 * Modifica el estado de la materia
	 * @param int $estadoMateria
	 * @access public
	 * @return void
	 */
	public function setEstadoMateria( $estadoMateria ){
		$this->estadoMateria = $estadoMateria;
	}
	
	/**
	 * Retorna el estado de la materia
	 * @access public
	 * @return int
	 */
	public function getEstadoMateria( ){
		return $this->estadoMateria;
	}
	
	/**
	 * Modifica el tipo de materia
	 * @param TipoMateria $tipoMateria
	 * @access public
	 * @return void
	 */
	public function setTipoMateria( $tipoMateria ){
		$this->tipoMateria = $tipoMateria;
	}
	
	/**
	 * Retorna el tipo de materia
	 * @access public
	 * @return TipoMateria
	 */
	public function getTipoMateria( ){
		return $this->tipoMateria;
	}
	
	/**
	 * Modifica la carrera de la materia
	 * @param Carrera $carrera
	 * @access public
	 * @return void
	 */
	public function setCarrera( $carrera ){
		$this->carrera = $carrera;
	}
	
	/**
	 * Retorna la carrera de la materia
	 * @access public
	 * @return Carrera
	 */
	public function getCarrera( ){
		return $this->carrera;
	}
	
  }
?>