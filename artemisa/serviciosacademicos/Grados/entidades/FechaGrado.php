<?php
  /**
   * @author Carlos Laberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class FechaGrado{
  	
	/**
	 * @type Int
	 * @access private
	 */
	private $idFechaGrado;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaGraduacion;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaMaxima;
	
	/**
	 * @type Periodo
	 * @access private
	 */
	private $periodo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoFechaGrado;
	
	/**
	 * @type TipoGrado
	 * @access private
	 */
	private $tipoGrado;
	
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
	 * @param Singleton $persistencia
	 */	 
	public function FechaGrado( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador de la fecha de grado
	 * @param int $idFechaGrado
	 * @access public
	 * @return void
	 */
	public function setIdFechaGrado( $idFechaGrado ){
		$this->idFechaGrado = $idFechaGrado;
	}
	
	/**
	 * Retorna el identificador de la fecha de grado de la carrera
	 * @access public
	 * @return int
	 */
	public function getIdFechaGrado( ){
		return $this->idFechaGrado;
	}
	
	/**
	 * Modifica la fecha del grado de la carrera
	 * @param date $fechaGraduacion
	 * @access public
	 * @return void
	 */
	public function setFechaGraduacion( $fechaGraduacion ){
		$this->fechaGraduacion = $fechaGraduacion;
	}
	
	/**
	 * Retorna la fecha del grado de la carrera
	 * @access public
	 * @return date
	 */
	public function getFechaGraduacion( ){
		return $this->fechaGraduacion;
	}
	
	/**
	 * Modifica la fecha maxima de cumplimiento de requisitos para grado
	 * @param date $fechaMaxima
	 * @access public
	 * @return void
	 */
	public function setFechaMaxima( $fechaMaxima ){
		$this->fechaMaxima = $fechaMaxima;
	}
	
	/**
	 * Retorna la fecha maxima de cumplimiento de requisitos para grado
	 * @access public
	 * @return date
	 */
	public function getFechaMaxima( ){
		return $this->fechaMaxima;
	}
	
	/**
	 * Modifica el periodo de la fecha de grado de la carrera
	 * @param Periodo $periodo
	 * @access public 
	 * @return void
	 */
	public function setPeriodo( $periodo ){
		$this->periodo = $periodo;
	}
	
	/**
	 * Retorna el periodo de la fecha de grado de la carrera
	 * @access public
	 * @return Periodo
	 */
	public function getPeriodo( ){
		return $this->periodo;
	}
	
	/**
	 * Modifica el estado de la fecha de grado de la carrera
	 * @param int $estadoFechaGrado
	 * @access public
	 * @return void
	 */
	public function setEstadoFechaGrado( $estadoFechaGrado ){
		$this->estadoFechaGrado = $estadoFechaGrado;
	}
	
	/**
	 * Retorna el estado de la fecha de grado de la carrera
	 * @access public
	 * @return date
	 */
	public function getEstadoFechaGrado( ){
		return $this->estadoFechaGrado;
	}
	
	/**
	 * Modifica el tipo de grado de la fecha de grado
	 * @param TipoGrado $tipoGrado
	 * @access public
	 * @return void
	 */
	public function setTipoGrado( $tipoGrado ){
		$this->tipoGrado = $tipoGrado;
	}
	
	/**
	 * Retorna el tipo de grado de la fecha de grado
	 * @access public
	 * @return TipoGrado
	 */
	public function getTipoGrado( ){
		return $this->tipoGrado;
	}
	
	/**
	 * Modifica la carrera de la fecha de grado
	 * @param Carrera $carrera
	 * @access public
	 * @return void
	 */
	public function setCarrera( $carrera ){
		$this->carrera = $carrera;
	}
	
	/**
	 * Retorna la carrera de la fecha de grado
	 * @access public
	 * @return Carrera
	 */
	public function getCarrera( ){
		return $this->carrera;
	}
	
	/**
	 * Consulta si existe una fecha de Grado
	 * @access public
	 * @return int
	 */
	 public function existeFechaGrado ( ) {
		$sql = "SELECT COUNT( FechaGradoId ) AS cantidad_fechaGrado
				FROM FechaGrado   
				WHERE CarreraId = ?
				AND CodigoPeriodo = ?
				AND TipoGradoId = ?
				AND CodigoEstado = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getCarrera( )->getCodigoCarrera( ) , true );
		$this->persistencia->setParametro( 1 , $this->getPeriodo( )->getCodigo( ) , true );
		$this->persistencia->setParametro( 2 , $this->getTipoGrado( )->getIdTipoGrado( ) , true );

		$this->persistencia->ejecutarConsulta(  );
		$cantidad = 0;
		
		if( $this->persistencia->getNext( ) )
			$cantidad = $this->persistencia->getParametro( "cantidad_fechaGrado" );
		
		$this->persistencia->freeResult( );
		
		return $cantidad;
				
	}
	
	/**
	 * Consulta si existe una fecha de Grado dependeiendo de los 5 parametros
	 * @access public
	 * @return int
	 */

	 public function existeFechaGradoActualizar( ) {
		$sql = "SELECT COUNT( FechaGradoId ) AS cantidad_fechaGrado
				FROM FechaGrado   
				WHERE CarreraId = ?
				AND CodigoPeriodo = ?
				AND TipoGradoId = ?
				AND CodigoEstado = 100 
				AND FechaGrado = ?
				AND FechaMaximaCumplimiento = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getCarrera( )->getCodigoCarrera( ) , true );
		$this->persistencia->setParametro( 1 , $this->getPeriodo( )->getCodigo( ) , true );
		$this->persistencia->setParametro( 2 , $this->getTipoGrado( )->getIdTipoGrado( ) , true );
		$this->persistencia->setParametro( 3 , $this->getFechaGraduacion( ) , true );
		$this->persistencia->setParametro( 4 , $this->getFechaMaxima( ) , true );

		$this->persistencia->ejecutarConsulta(  );
		$cantidad = 0;
		
		if( $this->persistencia->getNext( ) )
			$cantidad = $this->persistencia->getParametro( "cantidad_fechaGrado" );
		
		$this->persistencia->freeResult( );
		
		return $cantidad;
				
	}

	
	
	/**
	 * Inserta la fecha de grado de la carrera
	 * @access public
	 * @return Boolean 
	 */
	public function crearFechaGrado( $idPersona ){
		$sql = "INSERT INTO FechaGrado (
					FechaGradoId,
					FechaGrado,
					FechaMaximaCumplimiento,
					CarreraId,
					CodigoPeriodo,
					CodigoEstado,
					TipoGradoId,
					UsuarioCreacion,
					UsuarioModificacion,
					FechaCreacion,
					FechaUltimaModificacion
				)
				VALUES
					((SELECT IFNULL( MAX( FG.FechaGradoId ) +1, 1 ) 
							FROM FechaGrado FG
							 ), ?, ?, ?, ?, 100, ?, ?, NULL, NOW(), NULL)";
						
		$this->persistencia->crearSentenciaSQL( $sql );


		$this->persistencia->setParametro( 0 , $this->getFechaGraduacion( ) , true );
		$this->persistencia->setParametro( 1 , $this->getFechaMaxima( ) , true );
		$this->persistencia->setParametro( 2 , $this->getCarrera( )->getCodigoCarrera( ) , false );

		$this->persistencia->setParametro( 3 , $this->getPeriodo( )->getCodigo( ), false );
		
		$this->persistencia->setParametro( 4 , $this->getTipoGrado( )->getIdTipoGrado( ) , false );
		
		$this->persistencia->setParametro( 5 , $idPersona , false );
		
		//echo $this->persistencia->getSQLListo( );
		$estado = $this->persistencia->ejecutarUpdate( );
		if( $estado )
			$this->persistencia->confirmarTransaccion( );
		else	
			$this->persistencia->cancelarTransaccion( );
			
		//$this->persistencia->freeResult( );
		
		return $estado;
	}
	
	/**
	 * actualiza la fecha de grado de la carrera
	 * @access public
	 * @return Boolean 
	 */

	public function actulizarFechaGrado ( $idPersona , $fechaGradoActual , $fechaMaximaGradoActual,$idFechaGrado ) {

		$sql = "
				UPDATE FechaGrado
				SET 
					 FechaGrado = ?,
					 FechaMaximaCumplimiento = ?,
					 UsuarioModificacion = ?,
					 FechaUltimaModificacion = NOW()
				WHERE
					FechaGradoId = ?
			";

		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $fechaGradoActual , true );
		$this->persistencia->setParametro( 1 , $fechaMaximaGradoActual , true );
		$this->persistencia->setParametro( 2 , $idPersona , false );
		$this->persistencia->setParametro( 3 , $idFechaGrado , true );
		//echo $this->persistencia->getSQLListo( );
		$estado = $this->persistencia->ejecutarUpdate( );
		if( $estado )
			$this->persistencia->confirmarTransaccion( );
		else	
			$this->persistencia->cancelarTransaccion( );
			
		//$this->persistencia->freeResult( );
		return $estado;	

	}
	/**
	 * Consultar fecha de grado de una carrera
	 * @access public
	 * @return Boolean 
	 */
	public function consultar( $filtroFecha ){
		
		$fechaGrados = array( );
		$sql = "SELECT 
                            F.FechaGradoId,
                            F.FechaGrado, 
                            F.FechaMaximaCumplimiento, 
                            T.nombretipogrado, 
                            C.nombrecarrera, 
                            F.CodigoPeriodo,
                            C.codigofacultad,
                            C.codigocarrera,
                            F.codigoperiodo,
                            F.TipoGradoId 
                        FROM FechaGrado F
                        INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
                        INNER JOIN facultad FC ON ( FC.codigofacultad = C.codigofacultad )
                        INNER JOIN tipogrado T ON ( T.idtipogrado = F.TipoGradoId )
                        WHERE 
                            F.CodigoEstado = 100";
		
		$sql .=	$filtroFecha;
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			
                    $fechaGrado = new FechaGrado( $this->persistencia );
		     
                    $carrera = new Carrera( null );
                    $periodo = new Periodo( null );
                    $tipoGrado = new TipoGrado( null );

                    $carrera->setFacultad($this->persistencia->getParametro( "codigofacultad" ));
                    $carrera->setCodigoCarrera($this->persistencia->getParametro( "codigocarrera" ) );
                    $carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );

                    $periodo->setCodigo( $this->persistencia->getParametro( "CodigoPeriodo" ) );

                    $tipoGrado->setIdTipoGrado($this->persistencia->getParametro( "TipoGradoId" ));
                    $tipoGrado->setNombreTipoGrado($this->persistencia->getParametro( "nombretipogrado" ));

                    $fechaGrado->setIdFechaGrado( $this->persistencia->getParametro( "FechaGradoId" ) );
                    $fechaGrado->setFechaGraduacion( $this->persistencia->getParametro( "FechaGrado" ) );
                    $fechaGrado->setFechaMaxima( $this->persistencia->getParametro( "FechaMaximaCumplimiento" ) );
                    $fechaGrado->setCarrera($carrera);
                    $fechaGrado->setPeriodo( $periodo );
                    $fechaGrado->setTipoGrado( $tipoGrado );

                    $fechaGrados[ count( $fechaGrados ) ] = $fechaGrado;
		}
		
		$this->persistencia->freeResult( );
		
		return $fechaGrados;
	}

	/**
	 * Buscar Fecha Grado
	 * @access public
	 * @return int
	 */
	 public function buscarFechaGrado ( ) {
		$sql = "SELECT FechaGradoId, CarreraId 
				FROM FechaGrado   
				WHERE FechaGradoId = ?
				AND CodigoEstado = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getIdFechaGrado( ), false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			$this->setIdFechaGrado( $this->persistencia->getParametro( "FechaGradoId" ) );
			
			$carrera = new Carrera( null );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "CarreraId" ) );
			$this->setCarrera( $carrera );
		}
		
		$this->persistencia->freeResult( );
				
	}
	 
	/**
	 * Buscar Fecha Grado
	 * @access public
	 * @return int
	 */
	 public function buscarFechaGradoCarrera ( $txtCodigoCarrera ) {
		$sql = "SELECT FechaGradoId 
				FROM FechaGrado   
				WHERE CarreraId = ?
				AND CodigoEstado = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoCarrera, false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			$this->setIdFechaGrado( $this->persistencia->getParametro( "FechaGradoId" ) );
		}
		
		$this->persistencia->freeResult( );
				
	}


  }
?>