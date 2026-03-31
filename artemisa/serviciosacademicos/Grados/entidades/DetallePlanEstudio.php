<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class DetallePlanEstudio{
  	
	/**
	 * @type PlanEstudioEstudiante
	 * @access private
	 */
	private $planEstudioEstudiante;
	
	/**
	 * @type Materia
	 * @access private
	 */
	private $materia;
	
	/**
	 * @type int
	 * @access private
	 */
	private $creditosDetalle;
	
	/**
	 * @type int
	 * @access private
	 */
	private $semestreDetalle;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoDetalle;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton
	 */
	public function DetallePlanEstudio( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el Plan de Estudio del Estudiante
	 * @param PlanEstudio $planEstudio
	 * @access public
	 * @return void
	 */
	public function setPlanEstudioEstudiante( $planEstudioEstudiante ){
		$this->planEstudioEstudiante = $planEstudioEstudiante;
	}
	
	/**
	 * Retorna el Plan de Estudio del Estudiante
	 * @access public
	 * @return PlanEstudio
	 */
	public function getPlanEstudioEstudiante( ){
		return $this->planEstudioEstudiante;
	}
	
	/**
	 * Modifica la carrera del Detalle del Plan de Estudio
	 * @param Materia $materia
	 * @access public
	 * @return void
	 */
	public function setMateria( $materia ){
		$this->materia = $materia;
	}
	
	/**
	 * Retorna la carrera del Detalle del Plan de Estudio
	 * @access public
	 * @return Materia
	 */
	public function getMateria( ){
		return $this->materia;
	}
	
	/**
	 * Modifica los creditos del Detalle Plan Estudio
	 * @param int $creditosDetalle
	 * @access public
	 * @return void
	 */
	public function setCreditosDetalle( $creditosDetalle ){
		$this->creditosDetalle = $creditosDetalle;
	}
	
	/**
	 * Retorna los creditos del Detalle Plan Estudio
	 * @access public
	 * @return int
	 */
	public function getCreditosDetalle( ){
		return $this->creditosDetalle;
	}
	
	/**
	 * Modifica el semestre del Detalle Plan Estudio
	 * @param int $creditosDetalle
	 * @access public
	 * @return void
	 */
	public function setSemestreDetalle( $semestreDetalle ){
		$this->semestreDetalle = $semestreDetalle;
	}
	
	/**
	 * Retorna el semestre del Detalle Plan Estudio
	 * @access public
	 * @return int
	 */
	public function getSemestreDetalle( ){
		return $this->semestreDetalle;
	}
	
	/**
	 * Modifica el estado del detalle del plan de estudio
	 * @param int $estadoDetalle
	 * @access public
	 * @return void
	 */
	public function setEstadoDetalle( $estadoDetalle ){
		$this->estadoDetalle = $estadoDetalle;
	}
	
	/**
	 * Retorna el estado del detalle del plan de estudio
	 * @access public
	 * @return int
	 */
	public function getEstadoDetalle( ){
		return $this->estadoDetalle;
	}
	
	/**
	 * Consultar Carga Estudiante
	 * @param $txtCodigoEstudiante
	 * @return Array
	 */
	public function consultarCargaEstudiante( $txtCodigoEstudiante ){
		$detallePlanEstudios = array( );
		$sql = "SELECT D.idplanestudio,
					D.codigomateria,
					M.nombremateria,
					M.codigoindicadorgrupomateria,
					D.semestredetalleplanestudio,
					T.nombretipomateria,
					T.codigotipomateria,
					D.numerocreditosdetalleplanestudio
				FROM planestudioestudiante P
				INNER JOIN detalleplanestudio D ON ( D.idplanestudio = P.idplanestudio )
				INNER JOIN materia M ON ( M.codigomateria = D.codigomateria )
				INNER JOIN tipomateria T ON ( T.codigotipomateria = D.codigotipomateria )
				WHERE P.codigoestudiante = ?
				AND P.codigoestadoplanestudioestudiante LIKE '1%'
				AND D.codigoestadodetalleplanestudio LIKE '1%'
				ORDER BY 4, 3
		";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$detallePlanEstudio = new DetallePlanEstudio( $this->persistencia );
			$detallePlanEstudio->setCreditosDetalle( $this->persistencia->getParametro( "numerocreditosdetalleplanestudio" ) );
			$detallePlanEstudio->setSemestreDetalle( $this->persistencia->getParametro( "semestredetalleplanestudio" ) );
			
			$materia = new Materia( null );
			$materia->setCodigoMateria($this->persistencia->getParametro( "codigomateria" ));
			$materia->setNombreMateria( $this->persistencia->getParametro( "nombremateria" ) );
			$materia->setCodigoIndicador( $this->persistencia->getParametro( "codigoindicadorgrupomateria" ) );
			
			$tipoMateria = new TipoMateria( null );
			$tipoMateria->setCodigoTipoMateria( $this->persistencia->getParametro( "codigotipomateria" ) );
			$tipoMateria->setNombreTipoMateria( $this->persistencia->getParametro( "nombretipomateria" ) );
			
			$materia->setTipoMateria( $tipoMateria );
			
			$detallePlanEstudio->setMateria( $materia );
			
			$planEstudioEstudiante = new PlanEstudioEstudiante( null );
			$planEstudio = new PlanEstudio( null );
			$planEstudio->setIdPlanEstudio( $this->persistencia->getParametro( "idplanestudio" ) );
			
			$planEstudioEstudiante->setPlanEstudio( $planEstudio );
			
			$detallePlanEstudio->setPlanEstudioEstudiante( $planEstudioEstudiante );
			
			$detallePlanEstudios[ count( $detallePlanEstudios ) ] = $detallePlanEstudio;
		}
		return $detallePlanEstudios;
		
		
	}	
	
	
  }
?>