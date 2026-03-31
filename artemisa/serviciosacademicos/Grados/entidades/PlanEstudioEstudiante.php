<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class PlanEstudioEstudiante{
  	
	/**
	 * @type int
	 * @access private 
	 */
	private $id;
	
	/**
	 * @type Estudiante
	 * @access private
	 */
	private $estudiante;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaAsignacion;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaInicioEstudiante;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaVencimientoEstudiante;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estado;
	
	/**
	 * @type PlanEstudio
	 * @access private
	 */
	private $planEstudio;
	
	/**
	 * @type string
	 * @access private
	 */
	private $nombreLineaEnfasis;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function PlanEstudioEstudiante( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador del plan de estudio del estudiante
	 * @param int $id
	 * @access public
	 * @return void
	 */
	public function setIdPlanEstudioEstudiante( $id ){
		$this->id = $id;
	}
	
	/**
	 * Retorna el identificador del plan de estudio del estudiante
	 * @access public
	 * @return int
	 */
	public function getIdPlanEstudioEstudiante( ){
		return $this->id;
	}
	
	/**
	 * Modifica el estudiante del Plan de Estudio
	 * @param Estudiante $estudiante
	 * @access public
	 * @return void
	 */
	public function setEstudiante( $estudiante ){
		$this->estudiante = $estudiante;
	}
	
	/**
	 * Retorna el estudiante del PLan de Estudio
	 * @access public
	 * @return Estudiante
	 */
	public function getEstudiante( ){
		return $this->estudiante;
	}
	
	/**
	 * Modifica la fecha de asignacion del plan de estudio
	 * @param date $fechaAsignacion
	 * @access public
	 * @return void
	 */
	public function setFechaAsignacion( $fechaAsignacion ){
		$this->fechaAsignacion = $fechaAsignacion;
	}
	
	/**
	 * Retorna la fecha de asignacion del plan de estudio
	 * @access public
	 * @return date
	 */
	public function getFechaAsignacion( ){
		return $this->fechaAsignacion;
	}
	
	/**
	 * Modifica la fecha de inicio del plan de estudio del estudiante
	 * @param date $fechaInicioEstudiante
	 * @access public
	 * @return void
	 */
	public function setFechaInicioEstudiante( $fechaInicioEstudiante ){
		$this->fechaInicioEstudiante = $fechaInicioEstudiante;
	}
	
	/**
	 * Retorna la fecha de inicio del plan de estudio del estudiante
	 * @access public
	 * @return date
	 */
	public function getFechaInicioEstudiante( ){
		return $this->fechaInicioEstudiante;
	}
	
	/**
	 * Modifica la fecha de vencimiento del plan de estudio del estudiante
	 * @param int $fechaVencimientoEstudiante
	 * @access public
	 * @return void
	 */
	public function setFechaVencimientoEstudiante( $fechaVencimientoEstudiante ){
		$this->fechaVencimientoEstudiante = $fechaVencimientoEstudiante;
	}
	
	/**
	 * Retorna la fecha de vencimiento del plan de estudio del estudiante
	 * @access public
	 * @return date 
	 */
	public function getFechaVencimientoEstudiante( ){
		return $this->fechaVencimientoEstudiante;
	}
	
	/**
	 * Modifica el Estado del Plan de Estudio del Estudiante
	 * @param int $estado
	 * @access public
	 * @return void
	 */
	public function setEstado( $estado ){
		$this->estado = $estado;
	}
	
	/**
	 * Retorna el Estado del Plan de Estudio del Estudiante
	 * @access public
	 * @return int
	 */
	public function getEstado( ){
		return $this->estado;
	}
	
	/**
	 * Modifica el plan de estudio del estudiante
	 * @param PlanEstudio $planEstudio
	 * @access public
	 * @return void
	 */
	public function setPlanEstudio( $planEstudio ){
		$this->planEstudio = $planEstudio;
	}
	
	/**
	 * Retorna el plan de estudio del estudiante
	 * @access public
	 * @return PlanEstudio
	 */
	public function getPlanEstudio( ){
		return $this->planEstudio;
	}
	
	/**
	 * Modifica el nombre de la linea de enfasis del estudiante
	 * @param string $nombreLineaEnfasis
	 * @access public
	 * @return void
	 */
	public function setNombreLineaEnfasis( $nombreLineaEnfasis ){
		$this->nombreLineaEnfasis = $nombreLineaEnfasis;
	}
	
	/**
	 * Retorna el nombre de la linea de enfasis del estudiante
	 * @access public
	 * @return string
	 */
	public function getNombreLineaEnfasis( ){
		return $this->nombreLineaEnfasis;
	}
	
	/**
	 * Consultar Carga Estudiante
	 * @param $txtCodigoEstudiante
	 * @return Array
	 */
	public function buscarPlanEstudioEstudiante( $txtCodigoEstudiante ){
		
		$sql = "SELECT
					PE.idplanestudio, LE.nombrelineaenfasisplanestudio
				FROM
					planestudioestudiante PE
				INNER JOIN lineaenfasisestudiante LEE ON ( LEE.codigoestudiante = PE.codigoestudiante )
				INNER JOIN lineaenfasisplanestudio LE ON (LE.idlineaenfasisplanestudio = LEE.idlineaenfasisplanestudio )
				WHERE
					PE.codigoestudiante = ?
				AND PE.codigoestadoplanestudioestudiante LIKE '1%'
				AND LEE.fechavencimientolineaenfasisestudiante >= CURDATE()
				AND PE.codigoestadoplanestudioestudiante LIKE '1%'";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setIdPlanEstudioEstudiante( $this->persistencia->getParametro( "idplanestudio" ) );	
			$this->setNombreLineaEnfasis( $this->persistencia->getParametro( "nombrelineaenfasisplanestudio" ) );
		}
			
		$this->persistencia->freeResult( );
		
		
	}
	
	
	
  }
?>