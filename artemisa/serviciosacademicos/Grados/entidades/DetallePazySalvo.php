<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package entidades
    */
   
   class DetallePazySalvo{
   	
	/**
	 * @type int
	 * @access private
	 */
	private $idDetallePazySalvo;
	
	/**
	 * @type PazySalvo
	 * @access private
	 */
	private $pazySalvo;
	
	/**
	 * @type String
	 * @access private
	 */
	private $descripcionPazySalvo;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaPazySalvo;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaVencimientoPazySalvo;
	
	/**
	 * @type TipoPazySalvo
	 * @access private
	 */
	private $tipoPazySalvo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoPazySalvo;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function DetallePazySalvo( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador del detalle del paz y salvo
	 * @param int $idDetallePazySalvo
	 * @access public
	 * @return void
	 */
	public function setIdDetallePazySalvo( $idDetallePazySalvo ){
		$this->idDetallePazySalvo = $idDetallePazySalvo;
	}
	
	/**
	 * Retorna el identificador del detalle del paz y salvo
	 * @access public
	 * @return int
	 */
	public function getIdDetallePazySalvo( ){
		return $this->idDetallePazySalvo;
	}
	
	/**
	 * Modifica el Paz y Salvo del detalle
	 * @param int $pazySalvo
	 * @access public
	 * @return void
	 */
	public function setPazySalvo( $pazySalvo ){
		$this->pazySalvo = $pazySalvo;
	}
	
	/**
	 * Retorna el Paz Y Salvo del detalle
	 * @access public
	 * @return PazySalvo
	 */
	public function getPazySalvo( ){
		return $this->pazySalvo;
	}
	
	/**
	 * Modifica la descripcion del detalle del paz y salvo
	 * @param int $descripcionPazySalvo
	 * @access public
	 * @return void
	 */
	public function setDescripcionPazySalvo( $descripcionPazySalvo ){
		$this->descripcionPazySalvo = $descripcionPazySalvo;
	}
	
	/**
	 * Retorna la descripcion del detalle del paz y salvo
	 * @access public
	 * @return String
	 */
	public function getDescripcionPazySalvo( ){
		return $this->descripcionPazySalvo;
	}
	
	/**
	 * Modifica la fecha del Paz y Salvo
	 * @param date $fechaPazySalvo
	 * @access public
	 * @return void 
	 */
	public function setFechaPazySalvo( $fechaPazySalvo ){
		$this->fechaPazySalvo = $fechaPazySalvo;
	}
	
	/**
	 * Retorna la fecha del Paz y Salvo
	 * @access public
	 * @return date
	 */
	public function getFechaPazySalvo( ){
		return $this->fechaPazySalvo;
	}
	
	/**
	 * Modifica la fecha de vencimiento del Paz y Salvo
	 * @param date $fechaVencimientoPazySalvo
	 * @access public
	 * @return void
	 */
	public function setFechaVencimientoPazySalvo( $fechaVencimientoPazySalvo ){
		$this->fechaVencimientoPazySalvo = $fechaVencimientoPazySalvo;
	}
	
	/**
	 * Retorna la fecha de vencimiento del Paz y Salvo
	 * @access public
	 * @return date
	 */
	public function getFechaVencimientoPazySalvo( ){
		return $this->fechaVencimientoPazySalvo;
	}
	
	/**
	 * Modifica el tipo de paz y salvo del detalle
	 * @param TipoPazySalvo $tipoPazySalvo
	 * @access public
	 * @return void
	 */
	public function setTipoPazySalvo( $tipoPazySalvo ){
		$this->tipoPazySalvo = $tipoPazySalvo;
	}
	
	/**
	 * Retorna el tipo de paz y salvo del detalle
	 * @access public
	 * @return TipoPazySalvo
	 */
	public function getTipoPazySalvo( ){
		return $this->tipoPazySalvo;
	}
	
	/**
	 * Modifica el estado del detalle del paz y salvo
	 * @param int $estadoPazySalvo
	 * @access public
	 * @return void
	 */
	public function setEstadoPazySalvo( $estadoPazySalvo ){
		$this->estadoPazySalvo = $estadoPazySalvo;
	}
	
	/**
	 * Retorna el estado del detalle del paz y salvo
	 * @access public
	 * @return int
	 */
	public function getEstadoPazySalvo( ){
		return $this->estadoPazySalvo;
	}
	
	
	/**
	 * Existe Paz y Salvo
	 * @param int $txtCodigoEstudiante, $txtCodigoPeriodo
	 * @access public
	 * @return void
	 */
	public function buscarPazySalvo( $txtCodigoEstudiante, $txtCodigoPeriodo ){
		$sql = "SELECT COUNT(P.idpazysalvoestudiante) AS cantidad_pazysalvo
					FROM pazysalvoestudiante P
					INNER JOIN detallepazysalvoestudiante D ON ( P.idpazysalvoestudiante = D.idpazysalvoestudiante )
					INNER JOIN tipopazysalvoestudiante T ON ( T.codigotipopazysalvoestudiante = D.codigotipopazysalvoestudiante )
					INNER JOIN carrera C ON ( C.codigocarrera = P.codigocarrera )
					INNER JOIN estadopazysalvoestudiante E ON ( E.codigoestadopazysalvoestudiante = D.codigoestadopazysalvoestudiante )
					INNER JOIN estudiante ET ON ( ET.idestudiantegeneral = P.idestudiantegeneral )
					WHERE ET.codigoestudiante = ?
					AND P.codigoperiodo = ?
					AND D.codigoestadopazysalvoestudiante = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante, false );
		$this->persistencia->setParametro( 1 , $txtCodigoPeriodo, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			return $this->persistencia->getParametro( "cantidad_pazysalvo" );
		}
		return 0;
	}
	
	/**
	 * Consultar Paz y Salvo
	 * @param int $txtCodigoEstudiante, $txtCodigoPeriodo
	 */
	public function consultarPazySalvo( $txtCodigoEstudiante, $txtCodigoPeriodo ){
		$detallePazySalvos = array( );
		$sql = "SELECT P.idpazysalvoestudiante, D.descripciondetallepazysalvoestudiante, D.fechainiciodetallepazysalvoestudiante, D.fechavencimientodetallepazysalvoestudiante,
				T.nombretipopazysalvoestudiante, C.nombrecarrera
				FROM pazysalvoestudiante P
				INNER JOIN detallepazysalvoestudiante D ON ( P.idpazysalvoestudiante = D.idpazysalvoestudiante )
				INNER JOIN tipopazysalvoestudiante T ON ( T.codigotipopazysalvoestudiante = D.codigotipopazysalvoestudiante )
				INNER JOIN carrera C ON ( C.codigocarrera = P.codigocarrera )
				INNER JOIN estadopazysalvoestudiante E ON ( E.codigoestadopazysalvoestudiante = D.codigoestadopazysalvoestudiante )
				INNER JOIN estudiante ET ON ( ET.idestudiantegeneral = P.idestudiantegeneral )
				WHERE ET.codigoestudiante = ?
				AND P.codigoperiodo = ?
				AND D.codigoestadopazysalvoestudiante = 100";
				
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
		$this->persistencia->setParametro( 1 , $txtCodigoPeriodo , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$detallePazySalvo = new DetallePazySalvo( $this->persistencia );
			$detallePazySalvo->setDescripcionPazySalvo( $this->persistencia->getParametro( "descripciondetallepazysalvoestudiante" ) );
			$detallePazySalvo->setFechaPazySalvo( $this->persistencia->getParametro( "fechainiciodetallepazysalvoestudiante" ) );
			$detallePazySalvo->setFechaVencimientoPazySalvo( $this->persistencia->getParametro( "fechavencimientodetallepazysalvoestudiante" ) );
			
			$pazySalvo = new PazySalvo( null );
			$pazySalvo->setIdPazySalvo( $this->persistencia->getParametro( "idpazysalvoestudiante" ) );
			
			$carrera = new Carrera( null );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			
			$pazySalvo->setCarrera( $carrera );
			
			$detallePazySalvo->setPazySalvo( $pazySalvo );
			
			$tipoPazySalvo = new TipoPazySalvo( null );
			$tipoPazySalvo->setNombreTipoPazySalvo( $this->persistencia->getParametro( "nombretipopazysalvoestudiante" ) );
			
			$detallePazySalvo->setTipoPazySalvo( $tipoPazySalvo );
			
			
			
			
			$detallePazySalvos[ count( $detallePazySalvos ) ] = $detallePazySalvo;
		}
		$this->persistencia->freeResult( );
		
		return 	$detallePazySalvos;
	}
	
   }
?>