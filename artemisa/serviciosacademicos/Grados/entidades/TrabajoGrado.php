<?php
  /**
   * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class TrabajoGrado{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $idTrabajoGrado;
	
	/**
	 * @type Estudiante
	 * @access private
	 */
	private $estudiante;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombre;
	
	/**
	 * @type String
	 * @access private
	 */
	private $descripcion;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaAprobacion;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function TrabajoGrado( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador del Trabajo de Grado
	 * @param int $idTrabajoGrado
	 * @access public
	 * @return void
	 */
	public function setIdTrabajoGrado( $idTrabajoGrado ){
		$this->idTrabajoGrado = $idTrabajoGrado;
	}
	
	/**
	 * Retorna el identificador del Trabajo de Grado
	 * @access public
	 * @return int
	 */
	public function getIdTrabajoGrado( ){
		return $this->idTrabajoGrado;
	}
	
	/**
	 * Modifica el estudiante del Trabajo de Grado
	 * @param Estudiante $estudiante
	 * @access public
	 * @return void
	 */
	public function setEstudiante( $estudiante ){
		$this->estudiante = $estudiante;
	}
	
	/**
	 * Retorna el estudiante del Trabajo de Grado
	 * @access public
	 * @return Estudiante
	 */
	public function getEstudiante( ){
		return $this->estudiante;
	}
	
	/**
	 * Modifica el nombre del Trabajo de Grado
	 * @param String $nombre
	 * @access public
	 * @return void
	 */
	public function setNombreTrabajoGrado( $nombre ){
		$this->nombre = $nombre;
	}
	
	/**
	 * Retorna el nombre del Trabajo de Grado
	 * @access public
	 * @return string
	 */
	public function getNombreTrabajoGrado( ){
		return $this->nombre;
	}
	
	/**
	 * Modifica las características del Trabajo de Grado
	 * @param string $descripcion
	 * @access public
	 * @return void
	 */
	public function setDescripcion( $descripcion ){
		$this->descripcion = $descripcion;
	}
	
	/**
	 * Retorna las características del Trabajo de Grado
	 * @access pubic
	 * @return string 
	 */
	public function getDescripcion( ){
		return $this->descripcion;
	}
	
	/**
	 * Modifica la fecha de aprobación del Trabajo de Grado
	 * @param date $fechaAprobacion
	 * @access public
	 * @return void
	 */
	public function setFechaAprobacion( $fechaAprobacion ){
		$this->fechaAprobacion = $fechaAprobacion;
	}
	
	/**
	 * Retorna la fecha de aprobación del Trabajo de Grado
	 * @access public
	 * @return date
	 */
	public function getFechaAprobacion( ){
		return $this->fechaAprobacion;
	}
	
	/**
	 * Busca si existe Trabajo de Grado por Estudiante
	 * @access public
	 * @return void
	 */
	public function buscar( ) {
		$sql = "SELECT
					COUNT( idtrabajodegrado ) as existe
				FROM
					trabajodegrado
				WHERE
					codigoestudiante = ?
				AND codigoestado LIKE '1%'";
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getEstudiante( )->getCodigoEstudiante( ) , false );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			return $this->persistencia->getParametro( "existe" );
		}
		return 0;
	}
	
	/**
	 * Busca Trabajo de Grado por Estudiante
	 * @access public
	 * @return void
	 */
	public function buscarTGradoEstudiante( ) {
		$sql = "SELECT
					idtrabajodegrado, nombretrabajodegrado
				FROM
					trabajodegrado
				WHERE
					codigoestudiante = ?
				AND codigoestado LIKE '1%'";
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getEstudiante( )->getCodigoEstudiante( ) , false );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setIdTrabajoGrado( $this->persistencia->getParametro( "idtrabajodegrado" ) );
			$this->setNombreTrabajoGrado( $this->persistencia->getParametro( "nombretrabajodegrado" ) );
		}
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->freeResult( );
		
	}
	
  }
?>