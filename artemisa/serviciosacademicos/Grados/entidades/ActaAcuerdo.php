<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección General
    * @package entidades
    */
   
   class ActaAcuerdo{
   	
	/**
	 * @type int
	 * @access private
	 */
	private $idActaAcuerdo;
	
	/**
	 * @type String
	 * @access private
	 */
	private $numeroAcuerdo;
	
	/**
	 * @type String
	 * @access private
	 */
	private $numeroActa;
	
	/**
	 * @type String
	 * @access private
	 */
	private $numeroActaConsejoDirectivo;
	
	/**
	 * @type String
	 * @access private
	 */
	private $descripcionActaAcuerdo;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaActa;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaAcuerdo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoActaAcuerdo;
	
	/**
	 * @type FechaGrado
	 * @access private
	 */
	private $fechaGrado;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton
	 */
	public function ActaAcuerdo( $persistencia ){
		$this->persistencia = $persistencia;
	} 
	
	/**
	 * Modifica el identificador del acta y acuerdo
	 * @param int $idActaAcuerdo
	 * @access public
	 * @return void
	 */
	public function setIdActaAcuerdo( $idActaAcuerdo ){
		$this->idActaAcuerdo = $idActaAcuerdo;
	}
	
	/**
	 * Retorna el identificador del acta y acuerdo
	 * @access public
	 * @return int
	 */
	public function getIdActaAcuerdo( ){
		return $this->idActaAcuerdo;
	}
	
	/**
	 * Modifica el numero del acuerdo del consejo directivo
	 * @param string $numeroAcuerdo
	 * @access public
	 * @return void
	 */
	public function setNumeroAcuerdo( $numeroAcuerdo ){
		$this->numeroAcuerdo = $numeroAcuerdo;
	}
	
	/**
	 * Retorna el numero del acuerdo del consejo directivo
	 * @access public
	 * @return string
	 */
	public function getNumeroAcuerdo( ){
		return $this->numeroAcuerdo;
	}
	
	/**
	 * Modifica el numero del acta del consejo de facultad
	 * @param string $numeroAcuerdo
	 * @access public
	 * @return void
	 */
	public function setNumeroActa( $numeroActa ){
		$this->numeroActa = $numeroActa;
	}
	
	/**
	 * Retorna el numero del acta del consejo de facultad
	 * @access public
	 * @return string
	 */
	public function getNumeroActa( ){
		return $this->numeroActa;
	}
	
	/**
	 * Modifica el numero del acta del consejo Directivo
	 * @param string $numeroActaConsejoDirectivo
	 * @access public
	 * @return void
	 */
	public function setNumeroActaConsejoDirectivo( $numeroActaConsejoDirectivo ){
		$this->numeroActaConsejoDirectivo = $numeroActaConsejoDirectivo;
	}
	
	/**
	 * Retorna el numero del acta del consejo de facultad
	 * @access public
	 * @return string
	 */
	public function getNumeroActaConsejoDirectivo( ){
		return $this->numeroActaConsejoDirectivo;
	}
	
	/**
	 * Modifica la descripcion del acta y acuerdo
	 * @param string $descripcionActaAcuerdo
	 * @access public
	 * @return void
	 */
	public function setDescripcionActaAcuerdo( $descripcionActaAcuerdo ){
		$this->descripcionActaAcuerdo = $descripcionActaAcuerdo;
	}
	
	/**
	 * Retorna la descripcion del acta y acuerdo
	 * @access public
	 * @return string
	 */
	public function getDescripcionActaAcuerdo( ){
		return $this->descripcionActaAcuerdo;
	}
	
	/**
	 * Modifica la fecha del acta
	 * @param date $fechaActa
	 * @access public
	 * @return void
	 */
	public function setFechaActa( $fechaActa ){
		$this->fechaActa = $fechaActa;
	}
	
	/**
	 * Retorna la fecha del acta
	 * @access public
	 * @return date
	 */
	public function getFechaActa( ){
		return $this->fechaActa;
	}
	
	/**
	 * Modifica la fecha del acuerdo
	 * @param date $fechaAcuerdo
	 * @access public
	 * @return void
	 */
	public function setFechaAcuerdo( $fechaAcuerdo ){
		$this->fechaAcuerdo = $fechaAcuerdo;
	}
	
	/**
	 * Retorna la fecha del acuerdo
	 * @access public
	 * @return date
	 */
	public function getFechaAcuerdo( ){
		return $this->fechaAcuerdo;
	}
	
	/**
	 * Modifica el estado del acuerdo y acta
	 * @param int $estadoActaAcuerdo
	 * @access public
	 * @return void
	 */
	public function setEstadoActaAcuerdo( $estadoActaAcuerdo ){
		$this->estadoActaAcuerdo = $estadoActaAcuerdo;
	}
	
	/**
	 * Retorna el estado del acuerdo y acta
	 * @access public
	 * @return int
	 */
	public function getEstadoActaAcuerdo( ){
		return $this->estadoActaAcuerdo;
	}
	
	/**
	 * Modifica la fecha de grado del acta y acuerdo
	 * @param FechaGrado $fechaGrado
	 * @access public
	 * @return void
	 */
	public function setFechaGrado( $fechaGrado ){
		$this->fechaGrado = $fechaGrado;
	}
	
	/**
	 * Retorna el estado del acuerdo y acta
	 * @access public
	 * @return int
	 */
	public function getFechaGrado( ){
		return $this->fechaGrado;
	}
	
	/**
	 * Consulta si existe un acta asociada a una fecha de grado
	 * @access public
	 * @return int
	 */
	 public function existeActaAcuerdo( $txtFechaGrado ) {
		$sql = "SELECT COUNT(AC.AcuerdoActaId) AS cantidad_actaAcuerdo
				FROM AcuerdoActa AC 
				INNER JOIN DetalleAcuerdoActa DAC ON ( DAC.AcuerdoActaId = AC.AcuerdoActaId )
				WHERE AC.FechaGradoId = ?
				AND AC.CodigoEstado = 100
				AND DAC.EnviarCorreoSecretaria = 100
				AND DAC.EnviarCorreoVicerrectoria IS NULL";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado , false );
		
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		$cantidad = 0;
		
		if( $this->persistencia->getNext( ) )
			$cantidad = $this->persistencia->getParametro( "cantidad_actaAcuerdo" );
		
		$this->persistencia->freeResult( );
		
		return $cantidad;
				
	}
	
	/**
	 * Inserta el acta del consejo de facultad
	 * @access public
	 * @return Boolean 
	 */
	public function crearActaAcuerdo( $idPersona ){
		$sql = "INSERT INTO AcuerdoActa (
					AcuerdoActaId,
					NumeroAcuerdo,
					NumeroActa,
					DescripcionAcuerdoActa,
					FechaActa,
					FechaAcuerdo,
					CodigoEstado,
					UsuarioCreacion,
					UsuarioModificacion,
					FechaCreacion,
					FechaUltimaModificacion,
					FechaGradoId
				)
				VALUES
					((SELECT IFNULL( MAX( AC.AcuerdoActaId ) +1, 1 ) 
							FROM AcuerdoActa AC
							 ), 0, ?, NULL, ?, NULL, 100, ?, NULL, NOW(), NULL, ?)";				
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $this->getNumeroActa( ) , true );
		$this->persistencia->setParametro( 1 , $this->getFechaActa( ) , true );
		$this->persistencia->setParametro( 2 , $idPersona , false );
		$this->persistencia->setParametro( 3 , $this->getFechaGrado( )->getIdFechaGrado( ) , false );
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
	 * Existe Acta
	 * @param int $txtFechaGrado, $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarActaAcuerdo( $txtFechaGrado, $txtCodigoCarrera ){
		$sql = "SELECT COUNT(A.AcuerdoActaId) AS cantidad_acta 
				FROM AcuerdoActa A
				INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
				INNER JOIN carrera C ON ( F.CarreraId = C.codigocarrera )
				WHERE A.FechaGradoId = ?
				AND F.CarreraId = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado, false );
		$this->persistencia->setParametro( 1 , $txtCodigoCarrera, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			return $this->persistencia->getParametro( "cantidad_acta" );
		}
		return 0;
	}
	
	/**
	 * Existe Acuerdo
	 * @param int $txtFechaGrado, $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function existeAcuerdo( $txtFechaGrado, $txtCodigoCarrera ){
		$sql = "SELECT COUNT(A.AcuerdoActaId) AS cantidad_acuerdo
				FROM AcuerdoActa A
				INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
				INNER JOIN carrera C ON ( F.CarreraId = C.codigocarrera )
				WHERE A.FechaGradoId = ?
				AND F.CarreraId = ?
				AND A.NumeroAcuerdo != 0";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado, false );
		$this->persistencia->setParametro( 1 , $txtCodigoCarrera, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			return $this->persistencia->getParametro( "cantidad_acuerdo" );
		}
		return 0;
	}
	
	/**
	 * Buscar Acuerdo
	 * @param int $txtFechaGrado, $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarAcuerdo( $txtFechaGrado, $txtCodigoCarrera, $txtIdActa, $txtCodigoEstudiante ){
		$sql = "SELECT A.AcuerdoActaId, A.NumeroAcuerdo, A.FechaAcuerdo
				FROM AcuerdoActa A
				INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
				INNER JOIN carrera C ON ( F.CarreraId = C.codigocarrera )
				INNER JOIN DetalleAcuerdoActa D ON ( D.AcuerdoActaId = A.AcuerdoActaId  )
				WHERE A.FechaGradoId = ?
				AND F.CarreraId = ?
				AND A.AcuerdoActaId = ?
				AND D.EstudianteId = ?
				AND D.EstadoAcuerdo = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado, false );
		$this->persistencia->setParametro( 1 , $txtCodigoCarrera, false );
		$this->persistencia->setParametro( 2 , $txtIdActa, false );
		$this->persistencia->setParametro( 3 , $txtCodigoEstudiante, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			$this->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
			$this->setNumeroAcuerdo( $this->persistencia->getParametro( "NumeroAcuerdo" ) );
			$this->setFechaAcuerdo( $this->persistencia->getParametro( "FechaAcuerdo" ) );
		}
		$this->persistencia->freeResult( );
	}
	
	/**
	 * Buscar Acta por FechaGrado y Carrera
	 * @param int $txtFechaGrado, $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarActa( $txtFechaGrado, $txtCodigoCarrera, $txtCodigoEstudiante ){
		$sql = "SELECT A.AcuerdoActaId 
				FROM AcuerdoActa A
				INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
				INNER JOIN carrera C ON ( F.CarreraId = C.codigocarrera )
				INNER JOIN DetalleAcuerdoActa D ON ( D.AcuerdoActaId = A.AcuerdoActaId )
				WHERE A.FechaGradoId = ?
				AND F.CarreraId = ?
				AND D.EstudianteId = ?
				AND D.CodigoEstado = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado, false );
		$this->persistencia->setParametro( 1 , $txtCodigoCarrera, false );
		$this->persistencia->setParametro( 2 , $txtCodigoEstudiante, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			$this->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
		}
		
		$this->persistencia->freeResult( );
	}
	
	/**
	 * Buscar Acta por FechaGrado y Carrera
	 * @param int $txtFechaGrado, $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarActaId( $txtFechaGrado, $txtIdActa, $txtCodigoCarrera ){
		$sql = "SELECT A.AcuerdoActaId, A.NumeroActa, A.FechaActa, A.NumeroAcuerdo, A.FechaAcuerdo
				FROM AcuerdoActa A
				INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
				INNER JOIN carrera C ON ( F.CarreraId = C.codigocarrera )
				WHERE A.FechaGradoId = ?
				AND A.AcuerdoActaId = ?
				AND F.CarreraId = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado, false );
		$this->persistencia->setParametro( 1 , $txtIdActa, false );
		$this->persistencia->setParametro( 2 , $txtCodigoCarrera, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			$this->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
			$this->setNumeroActa( $this->persistencia->getParametro( "NumeroActa" ) );
			$this->setFechaActa( $this->persistencia->getParametro( "FechaActa" ) );
			$this->setNumeroAcuerdo( $this->persistencia->getParametro( "NumeroAcuerdo" ) );
			$this->setFechaAcuerdo( $this->persistencia->getParametro( "FechaAcuerdo" ) );
		}
		
		$this->persistencia->freeResult( );
	}
	
	
	/**
	 * Buscar id actaAcuerdo por secretaria
	 * @param int $txtCodigoEstudiante, $txtFechaGrado, $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarDetalleActaAcuerdoId( $txtCodigoEstudiante, $txtFechaGrado, $txtCodigoCarrera ){
		$sql = "SELECT A.AcuerdoActaId 
				FROM DetalleAcuerdoActa D
				INNER JOIN AcuerdoActa A ON ( A.AcuerdoActaId = D.AcuerdoActaId )
				INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
				INNER JOIN carrera C ON ( C.codigocarrera = F.CarreraId )
				WHERE D.EstudianteId = ?
				AND F.FechaGradoId = ?
				AND C.codigocarrera = ?
				AND D.CodigoEstado = 100
				AND D.EstadoAcuerdo = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante, false );
		$this->persistencia->setParametro( 1 , $txtFechaGrado, false );
		$this->persistencia->setParametro( 2 , $txtCodigoCarrera, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			$this->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
		}
		
		$this->persistencia->freeResult( );
	}
	
	/**
	 * Inserta el acuerdo del consejo directivo
	 * @access public
	 * @return Boolean 
	 */
	public function crearAcuerdo( $txtNumeroAcuerdo, $txtFechaAcuerdo, $txtNumeroActaAcuerdo, $idPersona, $txtIdActa ){
		$sql = "UPDATE AcuerdoActa
				SET 
				 NumeroAcuerdo = ?,
				 FechaAcuerdo = ?,
				 NumeroActaAcuerdo= ?,
				 UsuarioModificacion = ?,
				 FechaUltimaModificacion = NOW()
				WHERE
					AcuerdoActaId = ?";				
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtNumeroAcuerdo , false );
		$this->persistencia->setParametro( 1 , $txtFechaAcuerdo , true );
		$this->persistencia->setParametro( 2 , $txtNumeroActaAcuerdo , false );
		$this->persistencia->setParametro( 3 , $idPersona , false );
		$this->persistencia->setParametro( 4 , $txtIdActa , false );
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
	 * Consultar Actas y Acuerdo por FechaGrado y Carrera
	 * @param int $txtFechaGrado
	 * @access public
	 * @return void
	 */
	public function consultarActaAcuerdos( $txtFechaGrado ){
		$actaAcuerdos = array( );
		$sql = "SELECT A.AcuerdoActaId, A.NumeroActa, A.FechaActa, A.NumeroAcuerdo, A.FechaAcuerdo, C.nombrecarrera, C.codigocarrera, C.nombrecortocarrera, F.FechaGrado, A.NumeroActaAcuerdo
				FROM AcuerdoActa A
				INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
				INNER JOIN carrera C ON ( F.CarreraId = C.codigocarrera )
				WHERE A.FechaGradoId = ?
				AND A.CodigoEstado = 100
				AND A.AcuerdoActaId IN (SELECT DAC.AcuerdoActaId
												FROM DetalleAcuerdoActa DAC
												WHERE DAC.AcuerdoActaId = A.AcuerdoActaId
												AND DAC.CodigoEstado = 100 )";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$actaAcuerdo = new ActaAcuerdo( $this->persistencia  );
			$actaAcuerdo->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
			$actaAcuerdo->setNumeroActa( $this->persistencia->getParametro( "NumeroActa" ) );
			$actaAcuerdo->setFechaActa( $this->persistencia->getParametro( "FechaActa" ) );
			$actaAcuerdo->setNumeroAcuerdo( $this->persistencia->getParametro( "NumeroAcuerdo" ) );
			$actaAcuerdo->setFechaAcuerdo( $this->persistencia->getParametro( "FechaAcuerdo" ) );
			$actaAcuerdo->setNumeroActaConsejoDirectivo( $this->persistencia->getParametro( "NumeroActaAcuerdo" ) );
			
			$fechaGrado = new FechaGrado( null );
			$fechaGrado->setFechaGraduacion( $this->persistencia->getParametro( "FechaGrado" ) );
			
			$carrera = new Carrera( null );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setNombreCortoCarrera( $this->persistencia->getParametro( "nombrecortocarrera" ) );
			
			$fechaGrado->setCarrera( $carrera );
			
			$actaAcuerdo->setFechaGrado( $fechaGrado );
			
			$actaAcuerdos[ count( $actaAcuerdos ) ] = $actaAcuerdo;
		}
		$this->persistencia->freeResult( );
		
		return 	$actaAcuerdos;
	}
        
        
        	
	/**
	 * Consultar Actas y Acuerdo por FechaGrado y Carrera
	 * @param int $txtFechaGrado
	 * @access public
	 * @return void
	 */
	public function consultarActaAcuerdosAgrupados( $txtFechaGrado ){
		$actaAcuerdos = array( );
		$sql = "SELECT A.AcuerdoActaId, A.NumeroActa, A.FechaActa, A.NumeroAcuerdo, A.FechaAcuerdo, C.nombrecarrera, C.codigocarrera, C.nombrecortocarrera, F.FechaGrado, A.NumeroActaAcuerdo
				FROM AcuerdoActa A
				INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
				INNER JOIN carrera C ON ( F.CarreraId = C.codigocarrera )
				WHERE A.FechaGradoId = ?
				AND A.CodigoEstado = 100
				AND A.AcuerdoActaId IN (SELECT DAC.AcuerdoActaId
												FROM DetalleAcuerdoActa DAC
												WHERE DAC.AcuerdoActaId = A.AcuerdoActaId
												AND DAC.CodigoEstado = 100 )GROUP BY A.NumeroAcuerdo";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$actaAcuerdo = new ActaAcuerdo( $this->persistencia  );
			$actaAcuerdo->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
			$actaAcuerdo->setNumeroActa( $this->persistencia->getParametro( "NumeroActa" ) );
			$actaAcuerdo->setFechaActa( $this->persistencia->getParametro( "FechaActa" ) );
			$actaAcuerdo->setNumeroAcuerdo( $this->persistencia->getParametro( "NumeroAcuerdo" ) );
			$actaAcuerdo->setFechaAcuerdo( $this->persistencia->getParametro( "FechaAcuerdo" ) );
			$actaAcuerdo->setNumeroActaConsejoDirectivo( $this->persistencia->getParametro( "NumeroActaAcuerdo" ) );
			
			$fechaGrado = new FechaGrado( null );
			$fechaGrado->setFechaGraduacion( $this->persistencia->getParametro( "FechaGrado" ) );
			
			$carrera = new Carrera( null );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setNombreCortoCarrera( $this->persistencia->getParametro( "nombrecortocarrera" ) );
			
			$fechaGrado->setCarrera( $carrera );
			
			$actaAcuerdo->setFechaGrado( $fechaGrado );
			
			$actaAcuerdos[ count( $actaAcuerdos ) ] = $actaAcuerdo;
		}
		$this->persistencia->freeResult( );
		
		return 	$actaAcuerdos;
	}


	/**
	 * Consultar Actas y Acuerdo por FechaGrado y Periodo
	 * @param int $txtFechaGrado, $txtCodigoPeriodo
	 * @access public
	 * @return void
	 */
	public function consultarActaAcuerdosPeriodo( $txtFechaGrado, $txtCodigoPeriodo ){
		$actaAcuerdos = array( );
		$sql = "SELECT A.NumeroAcuerdo, A.FechaAcuerdo, C.nombrecarrera, C.codigocarrera, C.nombrecortocarrera, F.FechaGrado, A.NumeroActaAcuerdo
				FROM AcuerdoActa A
				INNER JOIN FechaGrado F ON ( F.FechaGradoId = A.FechaGradoId )
				INNER JOIN carrera C ON ( F.CarreraId = C.codigocarrera )
				WHERE A.FechaGradoId = ?
				AND A.CodigoEstado = 100
				AND A.AcuerdoActaId IN (SELECT DAC.AcuerdoActaId
												FROM DetalleAcuerdoActa DAC
												WHERE DAC.AcuerdoActaId = A.AcuerdoActaId
												AND DAC.CodigoEstado = 100 )
				AND F.CodigoPeriodo = ?
				GROUP BY NumeroAcuerdo, NumeroActaAcuerdo";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado, false );
		$this->persistencia->setParametro( 1 , $txtCodigoPeriodo, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$actaAcuerdo = new ActaAcuerdo( $this->persistencia  );
			$actaAcuerdo->setNumeroAcuerdo( $this->persistencia->getParametro( "NumeroAcuerdo" ) );
			$actaAcuerdo->setFechaAcuerdo( $this->persistencia->getParametro( "FechaAcuerdo" ) );
			$actaAcuerdo->setNumeroActaConsejoDirectivo( $this->persistencia->getParametro( "NumeroActaAcuerdo" ) );
			
			$fechaGrado = new FechaGrado( null );
			$fechaGrado->setFechaGraduacion( $this->persistencia->getParametro( "FechaGrado" ) );
			
			$carrera = new Carrera( null );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setNombreCortoCarrera( $this->persistencia->getParametro( "nombrecortocarrera" ) );
			
			$fechaGrado->setCarrera( $carrera );
			
			$actaAcuerdo->setFechaGrado( $fechaGrado );
			
			$actaAcuerdos[ count( $actaAcuerdos ) ] = $actaAcuerdo;
		}
		$this->persistencia->freeResult( );
		
		return 	$actaAcuerdos;
	}
        	
	/**
	 * Inserta el acta del consejo de facultad
	 * @access public
	 * @return Boolean 
	 */
	public function crearActaAcuerdoDistancia( $idPersona ){
		$sql = "INSERT INTO AcuerdoActa (
					NumeroAcuerdo,
					NumeroActa,
					NumeroActaAcuerdo,
                                        FechaActa,
					FechaAcuerdo,
					CodigoEstado,
					UsuarioCreacion,
					FechaCreacion,
					FechaGradoId
				)
				VALUES
					(?,?,?,?,?,100,?,now(),?)";				
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $this->getNumeroAcuerdo( )  , false );
		$this->persistencia->setParametro( 1 , $this->getNumeroActaConsejoDirectivo( ), false);
		$this->persistencia->setParametro( 2 , $this->getNumeroActa( ), false );
		$this->persistencia->setParametro( 3 , $this->getFechaActa(), true );
		$this->persistencia->setParametro( 4 , $this->getFechaAcuerdo(), true );
		$this->persistencia->setParametro( 5 , $idPersona , false );
		$this->persistencia->setParametro( 6 , $this->getFechaGrado( )->getIdFechaGrado( ) , false );
                
		//echo $this->persistencia->getSQLListo( );
		$estado = $this->persistencia->ejecutarUpdate( );
		if( $estado )
			$this->persistencia->confirmarTransaccion( );
		else	
			$this->persistencia->cancelarTransaccion( );
		
		return $estado;
	}
	
	
	
   }
?>