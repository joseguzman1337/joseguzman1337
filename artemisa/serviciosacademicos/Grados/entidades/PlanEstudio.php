<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class PlanEstudio{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $id;
	
	/**
	 * @type string
	 * @access private
	 */
	private $nombre;
	
	/**
	 * @type Carrea
	 * @access private
	 */
	private $carrera;
	
	/**
	 * @type string
	 * @access private
	 */
	private $responsable;
	
	/**
	 * @type string
	 * @access private
	 */
	private $cargo;
	
	/**
	 * @type string
	 * @access private
	 */
	private $numeroAutoriza;
	
	/**
	 * @type int
	 * @access private
	 */
	private $cantidadSemestre;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaInicio;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaVencimiento;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estado;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function PlanEstudio( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador del Plan de Estudio
	 * @param int $id
	 * @access public
	 * @return void
	 */
	public function setIdPlanEstudio( $id ){
		$this->id = $id;
	}
	
	/**
	 * Retorna el identificador del PLan de Estudio
	 * @access public
	 * @return int
	 */
	public function getIdPlanEstudio( ){
		return $this->id;
	}
	
	/**
	 * Modifica el nombre del Plan de Estudio
	 * @param string $nombre
	 * @access public
	 * @return void
	 */
	public function setNombre( $nombre ){
		$this->nombre = $nombre;
	}
	
	/**
	 * Retorna el nombre del PLan de Estudio
	 * @access public
	 * @return String
	 */
	public function getNombre( ){
		return $this->nombre;
	}
	
	/**
	 * Modifica la carrera del Plan de Estudio
	 * @param Carrera $carrera
	 * @access public
	 * @return void
	 */
	public function setCarrera( $carrera ){
		$this->carrera = $carrera;
	}
	
	/**
	 * Retorna la carrera del PLan de Estudio
	 * @access public
	 * @return Carrera
	 */
	public function getCarrera( ){
		return $this->carrera;
	}
	
	/**
	 * Modifica el responsable del PLan de Estudio
	 * @param string $responsable
	 * @access public
	 * @return void
	 */
	public function setResponsable( $responsable ){
		$this->responsable = $responsable;
	}
	
	/**
	 * Retorna el responsable del PLan de Estudio
	 * @access public
	 * @return String
	 */
	public function getResponsable( ){
		return $this->responsable;
	}
	
	/**
	 * Modifica el cargo del responsable del Plan de Estudio
	 * @param string $cargo
	 * @access public
	 * @return void
	 */
	public function setCargo( $cargo ){
		$this->cargo = $cargo;
	}
	
	/**
	 * Retorna el cargo del responsable del Plan de Estudio
	 * @access public
	 * @return String
	 */
	public function getCargo( ){
		return $this->cargo;
	}
	
	/**
	 * Modifica el numero de autorización del Plan de Estudio
	 * @param String $numeroAutoriza
	 * @access public
	 * @return void
	 */
	public function setNumeroAutoriza( $numeroAutoriza ){
		$this->numeroAutoriza = $numeroAutoriza;
	}
	
	/**
	 * Retorna el numero de autorización del Plan de Estudio
	 * @access public
	 * @return string
	 */
	public function getNumeroAutoriza( ){
		return $this->numeroAutoriza;
	}
	
	/**
	 * Modifica la cantidad de semestres del Plan de Estudio
	 * @param int $cantidadSemestre
	 * @access public 
	 * @return void
	 */
	public function setCantidadSemestre( $cantidadSemestre ){
		$this->cantidadSemestre = $cantidadSemestre;
	}
	
	/**
	 * Retorna la cantidad de semestres del Plan de Estudio
	 * @access public
	 * @return int
	 */
	public function getCantidadSemestre( ){
		return $this->cantidadSemestre;
	}
	
	/**
	 * Modifica la fecha de inicio del plan de estudio
	 * @param date $fechaInicio
	 * @access public
	 * @return void
	 */
	public function setFechaInicio( $fechaInicio ){
		$this->fechaInicio = $fechaInicio;
	}
	
	/**
	 * Retorna la fecha de inicio del plan de estudio
	 * @access public 
	 * @return date
	 */
	public function getFechaInicio( ){
		return $this->fechaInicio;
	}
	
	/**
	 * Modifica la fecha de vencimiento del plan de estudio
	 * @param date $fechaVencimiento
	 * @access public
	 * @return void 
	 */
	public function setFechaVencimiento( $fechaVencimiento ){
		$this->fechaVencimiento = $fechaVencimiento;
	}
	
	/**
	 * Retorna la fecha de vencimiento del plan de estudio
	 * @access public
	 * @return date
	 */
	public function getFechaVencimiento( ){
		return $this->fechaVencimiento;
	}
	
	/**
	 * Modifica el estado del plan de estudio
	 * @param int $estado
	 * @access public
	 * @return void
	 */
	public function setEstado( $estado ){
		$this->estado = $estado;
	}
	
	/**
	 * Retorna el estado del plan de estudio
	 * @access public
	 * @return int
	 */
	public function getEstado( ){
		return $this->estado;
	}
	
	
	/**
	 * Existe linea de Enfasis
	 * @access public
	 * @return int
	 */
	 public function existeLineaEnfasis( $txtCodigoCarrera ) {
		$sql = "SELECT COUNT(p.idplanestudio) as cantidad_lineaenfasis 
				FROM planestudio p
				INNER JOIN lineaenfasisplanestudio lp ON (p.idplanestudio = lp.idplanestudio)
				WHERE p.codigocarrera = ?
				AND lp.codigoestadolineaenfasisplanestudio LIKE '1%'";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoCarrera , false );
		
		$this->persistencia->ejecutarConsulta(  );
		//echo $this->persistencia->getSQLListo( );
		$cantidad = 0;
		
		if( $this->persistencia->getNext( ) )
			$cantidad = $this->persistencia->getParametro( "cantidad_lineaenfasis" );
		
		$this->persistencia->freeResult( );
		
		return $cantidad;
				
	}
	
	
  }
?>