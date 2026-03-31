<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package entidades
    */
   
   class DetalleActaAcuerdo{
   	
	/**
	 * @type int
	 * @access private
	 */
	private $idDetalleActaAcuerdo;
	
	
	/**
	 * @type Directivo
	 * @access private
	 */
	private $directivo;
	
	/**
	 * @type ActaAcuerdo
	 * @access private
	 */
	private $actaAcuerdo;
	
	/**
	 * @type Estudiante
	 * @access private
	 */
	private $estudiante;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoDetalleActaAcuerdo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoEnvioSecretaria;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoEnvioVicerrectoria;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia
	 */
	public function DetalleActaAcuerdo( $persistencia ){
		$this->persistencia = $persistencia;
	} 
	
	/**
	 * Modifica el identificador del detalle del acta acuerdo
	 * @param int $idDetalleActaAcuerdo
	 * @access public
	 * @return void
	 */
	public function setIdDetalleActaAcuerdo( $idDetalleActaAcuerdo ){
		$this->idDetalleActaAcuerdo = $idDetalleActaAcuerdo;
	}
	
	/**
	 * Retorna el identificador del detalle del acta acuerdo
	 * @access public
	 * @return int
	 */
	public function getIdDetalleActaAcuerdo( ){
		return $this->idDetalleActaAcuerdo;
	}
	
	/**
	 * Modifica el directivo del acta acuerdo
	 * @param Directivo $directivo
	 * @access public
	 * @return void
	 */
	public function setDirectivo( $directivo ){
		$this->directivo = $directivo;
	}
	
	/**
	 * Retorna el directivo del acta acuerdo
	 * @access public
	 * @return Directivo
	 */
	public function getDirectivo( ){
		return $this->directivo;
	}
	
	/**
	 * Modifica el actaAcuerdo del detalle
	 * @param ActaAcuerdo $actaAcuerdo
	 * @access public
	 * @return void
	 */
	public function setActaAcuerdo( $actaAcuerdo ){
		$this->actaAcuerdo = $actaAcuerdo;
	}
	
	/**
	 * Retorna el actaAcuerdo del detalle
	 * @access public
	 * @return ActaAcuerdo
	 */
	public function getActaAcuerdo( ){
		return $this->actaAcuerdo;
	}
	
	/**
	 * Modifica el estudiante del detalle acta acuerdo
	 * @param Estudiante $estudiante
	 * @access public
	 * @return void
	 */
	public function setEstudiante( $estudiante ){
		$this->estudiante = $estudiante;
	}
	
	/**
	 * Retorna el estudiante del detalle acta acuerdo
	 * @access public
	 * @return Estudiante
	 */
	public function getEstudiante( ){
		return $this->estudiante;
	}
	
	/**
	 * Modifica el estado del detalle acta acuerdo
	 * @param int $estadoDetalleActaAcuerdo
	 * @access public
	 * @return void
	 */
	public function setEstadoDetalleActaAcuerdo( $estadoDetalleActaAcuerdo ){
		$this->estadoDetalleActaAcuerdo = $estadoDetalleActaAcuerdo;
	}
	
	/**
	 * Retorna el estado del detalle acta acuerdo
	 * @access public
	 * @return Estudiante
	 */
	public function getEstadoDetalleActaAcuerdo( ){
		return $this->estadoDetalleActaAcuerdo;
	}
	
	/**
	 * Modifica el estado del envio a secretaria
	 * @param int $estadoEnvioVicerrectoria
	 * @access public
	 * @return void
	 */
	public function setEstadoEnvioSecretaria( $estadoEnvioSecretaria ){
		$this->estadoEnvioSecretaria = $estadoEnvioSecretaria;
	}
	
	/**
	 * Retorna el estado del envio a secretaria
	 * @access public
	 * @return Estudiante
	 */
	public function getEstadoEnvioSecretaria( ){
		return $this->estadoEnvioSecretaria;
	}
	
	/**
	 * Modifica el estado del envio a vicerrectoria
	 * @param int $estadoEnvioVicerrectoria
	 * @access public
	 * @return void
	 */
	public function setEstadoEnvioVicerrectoria( $estadoEnvioVicerrectoria ){
		$this->estadoEnvioVicerrectoria = $estadoEnvioVicerrectoria;
	}
	
	/**
	 * Retorna el estado del envio a vicerrectoria
	 * @access public
	 * @return Estudiante
	 */
	public function getEstadoEnvioVicerrectoria( ){
		return $this->estadoEnvioVicerrectoria;
	}
   
	/**
	 * Consulta si existe un detalle de acta acuerdo para un estudiante en particular
	 * @access public
	 * @return int
	 */
	/* public function existeDetalleAC ( ) {
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
				
	}*/
	
	
	
	/**
	 * Inserta la fecha de grado de la carrera
	 * @access public
	 * @return Boolean 
	 */
	public function crearDetalleAC( $idPersona ){
		$sql = "INSERT INTO DetalleAcuerdoActa (
					DetalleAcuerdoActaId,
					DirectivoId,
					AcuerdoActaId,
					EstudianteId,
					CodigoEstado,
					EstadoAcuerdo,
					UsuarioCreacion,
					UsuarioModificacion,
					FechaCreacion,
					FechaUltimaModificacion
				)
				VALUES
					((SELECT IFNULL( MAX( DAC.DetalleAcuerdoActaId ) +1, 1 ) 
							FROM DetalleAcuerdoActa DAC), ?, ?, ?, 100,0,?,NULL,NOW(),NULL)";
						
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $idPersona , true );
		$this->persistencia->setParametro( 1 , $this->getActaAcuerdo( )->getIdActaAcuerdo( ) , true );
		$this->persistencia->setParametro( 2 , $this->getEstudiante( )->getCodigoEstudiante( ) , false );
		$this->persistencia->setParametro( 3 , $idPersona , true );		
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
	 * Buscar Acta por FechaGrado y Carrera
	 * @param int $txtFechaGrado, $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarDetalleActa( $txtIdActa, $txtCodigoEstudiante ){
		$sql = "SELECT COUNT(DetalleAcuerdoActaId) AS cantidad_detalleacta
				FROM DetalleAcuerdoActa
				WHERE AcuerdoActaId = ?
				AND EstudianteId = ?
				AND CodigoEstado = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtIdActa, false );
		$this->persistencia->setParametro( 1 , $txtCodigoEstudiante, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			return $this->persistencia->getParametro( "cantidad_detalleacta" );
		}
		return 0;
	}
	
	
	/**
	 * Buscar Acta por FechaGrado y Carrera
	 * @param int $txtFechaGrado, $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarDetalleActaId( $txtIdActa, $txtCodigoEstudiante ){
		$sql = "SELECT DetalleAcuerdoActaId, CodigoEstado
				FROM DetalleAcuerdoActa
				WHERE AcuerdoActaId = ?
				AND EstudianteId = ?
				";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtIdActa, false );
		$this->persistencia->setParametro( 1 , $txtCodigoEstudiante, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			$this->setIdDetalleActaAcuerdo( $this->persistencia->getParametro( "DetalleAcuerdoActaId" ) );
			$this->setEstadoDetalleActaAcuerdo( $this->persistencia->getParametro( "CodigoEstado" ) );
		}
		
		$this->persistencia->freeResult( );
	}
	
	/**
	 * Consultar estudiantes con acta de consejo de facultad
	 * @access public
	 * @return Array
	 */
	public function consultarEstudianteActa( $txtFechaGrado ){
			
		$detalleActaAcuerdos = array( );
		$sql = "SELECT D.DetalleAcuerdoActaId, D.AcuerdoActaId, D.EstudianteId, CONCAT(EG.nombresestudiantegeneral, ' ', EG.apellidosestudiantegeneral ) AS Nombre
				FROM estudiantegeneral EG
				INNER JOIN estudiante E ON ( E.idestudiantegeneral = EG.idestudiantegeneral )
				INNER JOIN carrera C ON ( C.codigocarrera = E.codigocarrera )
				INNER JOIN FechaGrado F ON ( F.CarreraId = C.codigocarrera )
				INNER JOIN AcuerdoActa A ON ( A.FechaGradoId = F.FechaGradoId )
				INNER JOIN DetalleAcuerdoActa D ON ( D.AcuerdoActaId = A.AcuerdoActaId AND D.EstudianteId = E.codigoestudiante )
				WHERE D.CodigoEstado = 100
				AND F.FechaGradoId = ?
				AND D.EstadoAcuerdo != 100
				AND E.codigoestudiante NOT IN (
					SELECT
						R.codigoestudiante
					FROM
						registrograduado R
					WHERE
						R.codigoestudiante = E.codigoestudiante
					AND R.codigoestado = 100
					UNION
						SELECT
							RG.EstudianteId
						FROM
							RegistroGrado RG
						WHERE
							RG.EstudianteId = E.codigoestudiante
						AND RG.CodigoEstado = 100 )
				";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado, false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
			$detalleActaAcuerdo->setIdDetalleActaAcuerdo( $this->persistencia->getParametro( "DetalleAcuerdoActaId" ) );
			
			$actaAcuerdo = new ActaAcuerdo( null );
			$actaAcuerdo->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
			
			$estudiante = new Estudiante( null );
			$estudiante->setCodigoEstudiante( $this->persistencia->getParametro( "EstudianteId" ) );
			$estudiante->setNombreEstudiante( $this->persistencia->getParametro( "Nombre" ) );
			
			$detalleActaAcuerdo->setActaAcuerdo( $actaAcuerdo );
			$detalleActaAcuerdo->setEstudiante( $estudiante );
			
			$detalleActaAcuerdos[ count( $detalleActaAcuerdos ) ] = $detalleActaAcuerdo;
		}
		$this->persistencia->freeResult( );
		
		return 	$detalleActaAcuerdos;
		
		
	}

	/**
	 * Consultar estudiantes con acuerdo de consejo directivo
	 * @access public
	 * @return Array
	 */
	public function consultarEstudianteAcuerdo( $txtFechaGrado ){
			
		$detalleActaAcuerdos = array( );
		$sql = "SELECT DetalleAcuerdoActaId,
				AcuerdoActaId,
				EstudianteId,
				Nombre, NumeroAcuerdo 
				FROM ( SELECT D.DetalleAcuerdoActaId, D.AcuerdoActaId, D.EstudianteId, CONCAT(EG.apellidosestudiantegeneral, ' ', EG.nombresestudiantegeneral ) AS Nombre, A.NumeroAcuerdo 
				FROM estudiantegeneral EG
				INNER JOIN estudiante E ON ( E.idestudiantegeneral = EG.idestudiantegeneral )
				INNER JOIN carrera C ON ( C.codigocarrera = E.codigocarrera )
				INNER JOIN FechaGrado F ON ( F.CarreraId = C.codigocarrera )
				INNER JOIN AcuerdoActa A ON ( A.FechaGradoId = F.FechaGradoId )
				INNER JOIN DetalleAcuerdoActa D ON ( D.AcuerdoActaId = A.AcuerdoActaId AND D.EstudianteId = E.codigoestudiante )
				WHERE D.CodigoEstado = 100
				AND F.FechaGradoId = ?
				AND D.EstadoAcuerdo = 100
				AND A.NumeroAcuerdo != 0
				AND E.codigoestudiante NOT IN (
					SELECT
						R.EstudianteId
					FROM
						RegistroGrado R
					WHERE
						R.EstudianteId = E.codigoestudiante
					AND R.CodigoEstado = 100
				)
				ORDER BY EG.apellidosestudiantegeneral ASC ) b
				ORDER BY NumeroAcuerdo, Nombre";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado, false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
			$detalleActaAcuerdo->setIdDetalleActaAcuerdo( $this->persistencia->getParametro( "DetalleAcuerdoActaId" ) );
			
			$actaAcuerdo = new ActaAcuerdo( null );
			$actaAcuerdo->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
			
			$estudiante = new Estudiante( null );
			$estudiante->setCodigoEstudiante( $this->persistencia->getParametro( "EstudianteId" ) );
			$estudiante->setNombreEstudiante( $this->persistencia->getParametro( "Nombre" ) );
			
			$detalleActaAcuerdo->setActaAcuerdo( $actaAcuerdo );
			$detalleActaAcuerdo->setEstudiante( $estudiante );
			
			$detalleActaAcuerdos[ count( $detalleActaAcuerdos ) ] = $detalleActaAcuerdo;
		}
		$this->persistencia->freeResult( );
		
		return 	$detalleActaAcuerdos;
		
		
	}	

	/**
	 * Anular Actas
	 * @param int txtIdDetalleActa
	 * @access public
	 * @return void
	 */
	public function anularActa( ){
		
		$sql = "UPDATE DetalleAcuerdoActa
				SET CodigoEstado = 200,
				EnviarCorreoSecretaria = 200,
				EnviarCorreoVicerrectoria = 200
				WHERE
					DetalleAcuerdoActaId = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $this->getIdDetalleActaAcuerdo( ) , false );
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
	 * Actualizar Acta
	 * @param int txtIdDetalleActa
	 * @access public
	 * @return void
	 */
	public function actualizarDetalleAcuerdo( $txtIdActa, $txtCodigoEstudiante ){
		
		$sql = "UPDATE DetalleAcuerdoActa
				SET 
				 EstadoAcuerdo = 100
				WHERE
					AcuerdoActaId = ?
					AND EstudianteId = ?
					AND CodigoEstado = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtIdActa , false );
		$this->persistencia->setParametro( 1 , $txtCodigoEstudiante , false );
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
	 * Buscar Estudiante por DetalleAcuerdoActaId
	 * @access public
	 * @return void
	 */
	public function buscarEstudianteDetalleActaId( $txtIdDetalleActa ){
		$sql = "SELECT EstudianteId
				FROM DetalleAcuerdoActa
				WHERE DetalleAcuerdoActaId = ?
				";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtIdDetalleActa , false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			$estudiante = new Estudiante( null );
			$estudiante->setCodigoEstudiante( $this->persistencia->getParametro( "EstudianteId" ) );
			
			$this->setEstudiante( $estudiante );
		}
		
		$this->persistencia->freeResult( );
	}
	
	
	/**
	 * Consultar estudiantes con acta de consejo de facultad para usuario consejo directivo
	 * @access public
	 * @return Array
	 */
	public function consultarEActas( $filtroActa, $txtIdRol ){
			
		$detalleActaAcuerdos = array( );
		$sql = "SELECT idestudiantegeneral,
				codigoestudiante,
				Nombre,
				nombrecarrera,
				codigocarrera,
				FechaMaximaCumplimiento,
				FechaGradoId,
				AcuerdoActaId,
				DetalleAcuerdoActaId,
				EnviarCorreoVicerrectoria,
				codigosituacioncarreraestudiante,
				codigomodalidadacademica,
				TipoGradoId, NumeroActa 
				FROM ( SELECT DISTINCT
					EG.idestudiantegeneral, E.codigoestudiante, CONCAT( EG.apellidosestudiantegeneral,' ', EG.nombresestudiantegeneral ) AS Nombre,
					C.nombrecarrera, C.codigocarrera, FG.FechaMaximaCumplimiento, FG.FechaGradoId, AC.AcuerdoActaId, DAC.DetalleAcuerdoActaId, DAC.EnviarCorreoVicerrectoria, E.codigosituacioncarreraestudiante,
					C.codigomodalidadacademica, FG.TipoGradoId, AC.NumeroActa
				FROM
					estudiantegeneral EG
				INNER JOIN estudiante E ON ( E.idestudiantegeneral = EG.idestudiantegeneral )
				INNER JOIN carrera C ON ( C.codigocarrera = E.codigocarrera )
				INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
				INNER JOIN FechaGrado FG ON ( FG.CarreraId = C.codigocarrera )
				INNER JOIN AcuerdoActa AC ON ( AC.FechaGradoId = FG.FechaGradoId )
				INNER JOIN DetalleAcuerdoActa DAC ON ( DAC.AcuerdoActaId = AC.AcuerdoActaId AND E.codigoestudiante = DAC.EstudianteId )
				INNER JOIN planestudioestudiante PE ON ( PE.codigoestudiante = E.codigoestudiante )
				WHERE 1= 1 "; 
				$sql .=	$filtroActa;
				$sql .= " AND E.codigoestudiante NOT IN (	SELECT
															R.codigoestudiante
														FROM
															registrograduado R
														WHERE
															R.codigoestudiante = E.codigoestudiante
													)
				AND E.codigoestudiante IN ( SELECT DC.EstudianteId
														FROM DetalleAcuerdoActa DC
														WHERE CodigoEstado = 100	)
				AND DAC.CodigoEstado = 100
				AND PE.codigoestadoplanestudioestudiante LIKE '1%'
				AND DAC.EnviarCorreoSecretaria = 100";
				if( $txtIdRol != 13 && $txtIdRol != 75 ){
					$sql .= " AND DAC.EnviarCorreoVicerrectoria = 100";
				}
		$sql .= " ORDER BY EG.apellidosestudiantegeneral ASC ) b
		ORDER BY NumeroActa, Nombre";	
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
			$detalleActaAcuerdo->setIdDetalleActaAcuerdo( $this->persistencia->getParametro( "DetalleAcuerdoActaId" ) );
			$detalleActaAcuerdo->setEstadoEnvioVicerrectoria( $this->persistencia->getParametro( "EnviarCorreoVicerrectoria" ) );
			
			$actaAcuerdo = new ActaAcuerdo( null );
			$actaAcuerdo->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
			
			$estudiante = new Estudiante( null );
			$estudiante->setIdEstudiante( $this->persistencia->getParametro( "idestudiantegeneral" ) );
			$estudiante->setCodigoEstudiante( $this->persistencia->getParametro( "codigoestudiante" ) );
			$estudiante->setNombreEstudiante( $this->persistencia->getParametro( "Nombre" ) );
			
			$situacionCarreraEstudiante = new SituacionCarreraEstudiante( null );
			$situacionCarreraEstudiante->setCodigoSituacion( $this->persistencia->getParametro( "codigosituacioncarreraestudiante" ) );
			
			
			$fechaGrado = new FechaGrado( null );
			$fechaGrado->setIdFechaGrado( $this->persistencia->getParametro( "FechaGradoId" ) );
			$fechaGrado->setFechaMaxima( $this->persistencia->getParametro( "FechaMaximaCumplimiento" ) );
			
			$carrera = new Carrera( null );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			
			$tipoGrado = new TipoGrado( null );
			$tipoGrado->setIdTipoGrado( $this->persistencia->getParametro( "TipoGradoId" ) );
			
			$modalidadAcademica = new ModalidadAcademica( null );
			$modalidadAcademica->setCodigoModalidadAcademica( $this->persistencia->getParametro( "codigomodalidadacademica" ) );
			
			$carrera->setModalidadAcademica( $modalidadAcademica );
			
			$fechaGrado->setCarrera( $carrera );
			
			$fechaGrado->setTipoGrado( $tipoGrado );
			
			$estudiante->setFechaGrado( $fechaGrado );
			
			$estudiante->setSituacionCarreraEstudiante( $situacionCarreraEstudiante );
			
			
			$detalleActaAcuerdo->setActaAcuerdo( $actaAcuerdo );
			$detalleActaAcuerdo->setEstudiante( $estudiante );
			
			$detalleActaAcuerdos[ count( $detalleActaAcuerdos ) ] = $detalleActaAcuerdo;
		}
		$this->persistencia->freeResult( );
		
		return 	$detalleActaAcuerdos;
		
		
	}

	/**
	 * Consultar estudiantes con acta de consejo de facultad y acuerdo de consejo directivo para usuario secretaria general
	 * @access public
	 * @return Array
	 */
	public function consultarEAcuerdo( $filtroAcuerdo ){
			
		$detalleActaAcuerdos = array( );
		$sql = "SELECT idestudiantegeneral,
				codigoestudiante,
				Nombre,
				nombrecarrera,
				codigocarrera,
				FechaMaximaCumplimiento,
				FechaGradoId,
				AcuerdoActaId,
				DetalleAcuerdoActaId,
				codigomodalidadacademica,
				NumeroActaAcuerdo,
				codigosituacioncarreraestudiante, NumeroAcuerdo
				FROM ( SELECT DISTINCT
					EG.idestudiantegeneral, E.codigoestudiante, CONCAT( EG.apellidosestudiantegeneral,' ', EG.nombresestudiantegeneral ) AS Nombre,
					C.nombrecarrera, C.codigocarrera, FG.FechaMaximaCumplimiento, FG.FechaGradoId, AC.AcuerdoActaId, DAC.DetalleAcuerdoActaId, C.codigomodalidadacademica, AC.NumeroActaAcuerdo, E.codigosituacioncarreraestudiante, AC.NumeroAcuerdo
				FROM
					estudiantegeneral EG
				INNER JOIN estudiante E ON ( E.idestudiantegeneral = EG.idestudiantegeneral )
				INNER JOIN carrera C ON ( C.codigocarrera = E.codigocarrera )
				INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
				INNER JOIN FechaGrado FG ON ( FG.CarreraId = C.codigocarrera )
				INNER JOIN AcuerdoActa AC ON ( AC.FechaGradoId = FG.FechaGradoId )
				INNER JOIN DetalleAcuerdoActa DAC ON ( DAC.AcuerdoActaId = AC.AcuerdoActaId AND E.codigoestudiante = DAC.EstudianteId )
				INNER JOIN planestudioestudiante PE ON ( PE.codigoestudiante = E.codigoestudiante )
				WHERE 1= 1 "; 
				$sql .=	$filtroAcuerdo;
				$sql .= " AND E.codigoestudiante NOT IN (	SELECT
															R.codigoestudiante
														FROM
															registrograduado R
														WHERE
															R.codigoestudiante = E.codigoestudiante
													)
				AND E.codigoestudiante IN ( SELECT DC.EstudianteId
												FROM DetalleAcuerdoActa DC
											)
				AND DAC.CodigoEstado = 100
				AND DAC.EstadoAcuerdo = 100
				AND PE.codigoestadoplanestudioestudiante LIKE '1%'
				AND DAC.EnviarCorreoSecretaria = 100
				AND DAC.EnviarCorreoVicerrectoria = 100";
		
		$sql .= " ORDER BY AC.AcuerdoActaId, EG.apellidosestudiantegeneral ASC) b
				ORDER BY NumeroAcuerdo, Nombre";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
			$detalleActaAcuerdo->setIdDetalleActaAcuerdo( $this->persistencia->getParametro( "DetalleAcuerdoActaId" ) );
			
			$actaAcuerdo = new ActaAcuerdo( null );
			$actaAcuerdo->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
			$actaAcuerdo->setNumeroActaConsejoDirectivo( $this->persistencia->getParametro( "NumeroActaAcuerdo" ) );
			
			$estudiante = new Estudiante( null );
			$estudiante->setIdEstudiante( $this->persistencia->getParametro( "idestudiantegeneral" ) );
			$estudiante->setCodigoEstudiante( $this->persistencia->getParametro( "codigoestudiante" ) );
			$estudiante->setNombreEstudiante( $this->persistencia->getParametro( "Nombre" ) );
			
			$situacionCarreraEstudiante = new SituacionCarreraEstudiante( null );
			$situacionCarreraEstudiante->setCodigoSituacion( $this->persistencia->getParametro( "codigosituacioncarreraestudiante") ); 
			
			
			$fechaGrado = new FechaGrado( null );
			$fechaGrado->setIdFechaGrado( $this->persistencia->getParametro( "FechaGradoId" ) );
			$fechaGrado->setFechaMaxima( $this->persistencia->getParametro( "FechaMaximaCumplimiento" ) );
			
			$carrera = new Carrera( null );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			
			$modalidadAcademica = new ModalidadAcademica( null );
			$modalidadAcademica->setCodigoModalidadAcademica( $this->persistencia->getParametro( "codigomodalidadacademica" ) );
			
			$carrera->setModalidadAcademica( $modalidadAcademica );
			
			$fechaGrado->setCarrera( $carrera );
			
			$estudiante->setFechaGrado( $fechaGrado );
			$estudiante->setSituacionCarreraEstudiante( $situacionCarreraEstudiante );
			
			$detalleActaAcuerdo->setActaAcuerdo( $actaAcuerdo );
			$detalleActaAcuerdo->setEstudiante( $estudiante );
			
			$detalleActaAcuerdos[ count( $detalleActaAcuerdos ) ] = $detalleActaAcuerdo;
		}
		$this->persistencia->freeResult( );
		
		return 	$detalleActaAcuerdos;
		
		
	}


	/**
	 * Buscar Acuerdo por FechaGrado y Carrera
	 * @param int $txtFechaGrado, $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarDetalleAcuerdo( $txtIdActa, $txtCodigoEstudiante ){
		$sql = "SELECT COUNT(DetalleAcuerdoActaId) AS cantidad_detalleacuerdo
				FROM DetalleAcuerdoActa
				WHERE AcuerdoActaId = ?
				AND EstudianteId = ?
				AND CodigoEstado = 100
				AND EstadoAcuerdo = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtIdActa, false );
		$this->persistencia->setParametro( 1 , $txtCodigoEstudiante, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			return $this->persistencia->getParametro( "cantidad_detalleacuerdo" );
		}
		return 0;
	}
	
	
	/**
	 * Anular Acuerdos
	 * @param int txtIdDetalleActa
	 * @access public
	 * @return void
	 */
	public function anularAcuerdo( $txtIdDetalleActa ){
		
		$sql = "UPDATE DetalleAcuerdoActa
				SET EstadoAcuerdo = 200,
				CodigoEstado = 200,
				EnviarCorreoSecretaria = 200,
				EnviarCorreoVicerrectoria = 200
				WHERE
					DetalleAcuerdoActaId = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtIdDetalleActa , false );
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
	 * Consultar estudiantes con acuerdo para generar PDF
	 * @access public
	 * @return Array
	 */
	public function consultarAcuerdoPDF( $txtFechaGrado, $txtIdActaAcuerdo ){
			
		$detalleActaAcuerdos = array( );
		$sql = "SELECT DISTINCT EG.idestudiantegeneral, E.codigoestudiante, EG.numerodocumento , CONCAT( EG.nombresestudiantegeneral, ' ',	EG.apellidosestudiantegeneral ) AS Nombre,
					C.nombrecarrera, C.codigocarrera, FG.FechaMaximaCumplimiento, FG.FechaGradoId, AC.AcuerdoActaId, DAC.DetalleAcuerdoActaId, EG.expedidodocumento
				FROM
					estudiantegeneral EG
				INNER JOIN estudiante E ON ( E.idestudiantegeneral = EG.idestudiantegeneral )
				INNER JOIN carrera C ON ( C.codigocarrera = E.codigocarrera )
				INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
				INNER JOIN FechaGrado FG ON ( FG.CarreraId = C.codigocarrera )
				INNER JOIN AcuerdoActa AC ON ( AC.FechaGradoId = FG.FechaGradoId )
				INNER JOIN DetalleAcuerdoActa DAC ON ( DAC.AcuerdoActaId = AC.AcuerdoActaId AND E.codigoestudiante = DAC.EstudianteId )
				WHERE FG.FechaGradoId = ?
				AND DAC.CodigoEstado = 100
				AND DAC.EstadoAcuerdo = 100
				AND AC.AcuerdoActaId = ?";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado , false );
		$this->persistencia->setParametro( 1 , $txtIdActaAcuerdo , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
			$detalleActaAcuerdo->setIdDetalleActaAcuerdo( $this->persistencia->getParametro( "DetalleAcuerdoActaId" ) );
			
			$actaAcuerdo = new ActaAcuerdo( null );
			$actaAcuerdo->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
			
			$estudiante = new Estudiante( null );
			$estudiante->setIdEstudiante( $this->persistencia->getParametro( "idestudiantegeneral" ) );
			$estudiante->setCodigoEstudiante( $this->persistencia->getParametro( "codigoestudiante" ) );
			$estudiante->setNombreEstudiante( $this->persistencia->getParametro( "Nombre" ) );
			$estudiante->setNumeroDocumento($this->persistencia->getParametro( "numerodocumento" ));
			$estudiante->setExpedicion($this->persistencia->getParametro( "expedidodocumento" ));
			
			$fechaGrado = new FechaGrado( null );
			$fechaGrado->setIdFechaGrado( $this->persistencia->getParametro( "FechaGradoId" ) );
			$fechaGrado->setFechaMaxima( $this->persistencia->getParametro( "FechaMaximaCumplimiento" ) );
			
			$carrera = new Carrera( null );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			
			$fechaGrado->setCarrera( $carrera );
			
			$estudiante->setFechaGrado( $fechaGrado );
			
			
			$detalleActaAcuerdo->setActaAcuerdo( $actaAcuerdo );
			$detalleActaAcuerdo->setEstudiante( $estudiante );
			
			$detalleActaAcuerdos[ count( $detalleActaAcuerdos ) ] = $detalleActaAcuerdo;
		}
		$this->persistencia->freeResult( );
		
		return 	$detalleActaAcuerdos;
		
		
	}

        
        
        public function consultarAcuerdoPDFNumero( $txtFechaGrado, $txtActaAcuerdoNumero ){
			
		$detalleActaAcuerdos = array( );
		$sql = "SELECT DISTINCT EG.idestudiantegeneral, E.codigoestudiante, EG.numerodocumento , CONCAT( EG.nombresestudiantegeneral, ' ',	EG.apellidosestudiantegeneral ) AS Nombre,
					C.nombrecarrera, C.codigocarrera, FG.FechaMaximaCumplimiento, FG.FechaGradoId, AC.AcuerdoActaId, DAC.DetalleAcuerdoActaId, EG.expedidodocumento
				FROM
					estudiantegeneral EG
				INNER JOIN estudiante E ON ( E.idestudiantegeneral = EG.idestudiantegeneral )
				INNER JOIN carrera C ON ( C.codigocarrera = E.codigocarrera )
				INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
				INNER JOIN FechaGrado FG ON ( FG.CarreraId = C.codigocarrera )
				INNER JOIN AcuerdoActa AC ON ( AC.FechaGradoId = FG.FechaGradoId )
				INNER JOIN DetalleAcuerdoActa DAC ON ( DAC.AcuerdoActaId = AC.AcuerdoActaId AND E.codigoestudiante = DAC.EstudianteId )
				WHERE FG.FechaGradoId = ?
				AND DAC.CodigoEstado = 100
				AND DAC.EstadoAcuerdo = 100
				AND AC.NumeroAcuerdo = ?";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado , false );
		$this->persistencia->setParametro( 1 , $txtActaAcuerdoNumero , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
			$detalleActaAcuerdo->setIdDetalleActaAcuerdo( $this->persistencia->getParametro( "DetalleAcuerdoActaId" ) );
			
			$actaAcuerdo = new ActaAcuerdo( null );
			$actaAcuerdo->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
			
			$estudiante = new Estudiante( null );
			$estudiante->setIdEstudiante( $this->persistencia->getParametro( "idestudiantegeneral" ) );
			$estudiante->setCodigoEstudiante( $this->persistencia->getParametro( "codigoestudiante" ) );
			$estudiante->setNombreEstudiante( $this->persistencia->getParametro( "Nombre" ) );
			$estudiante->setNumeroDocumento($this->persistencia->getParametro( "numerodocumento" ));
			$estudiante->setExpedicion($this->persistencia->getParametro( "expedidodocumento" ));
			
			$fechaGrado = new FechaGrado( null );
			$fechaGrado->setIdFechaGrado( $this->persistencia->getParametro( "FechaGradoId" ) );
			$fechaGrado->setFechaMaxima( $this->persistencia->getParametro( "FechaMaximaCumplimiento" ) );
			
			$carrera = new Carrera( null );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			
			$fechaGrado->setCarrera( $carrera );
			
			$estudiante->setFechaGrado( $fechaGrado );
			
			
			$detalleActaAcuerdo->setActaAcuerdo( $actaAcuerdo );
			$detalleActaAcuerdo->setEstudiante( $estudiante );
			
			$detalleActaAcuerdos[ count( $detalleActaAcuerdos ) ] = $detalleActaAcuerdo;
		}
		$this->persistencia->freeResult( );
		
		return 	$detalleActaAcuerdos;
		
		
	}

	/**
	 * Consultar estudiantes con acuerdo para generar PDF
	 * @access public
	 * @return Array
	 */
	public function consultarActaPDF( $txtFechaGrado, $txtIdActaAcuerdo ){
			
		$detalleActaAcuerdos = array( );
		$sql = "SELECT DISTINCT EG.idestudiantegeneral, E.codigoestudiante, EG.numerodocumento , CONCAT( EG.nombresestudiantegeneral, ' ',	EG.apellidosestudiantegeneral ) AS Nombre,
					C.nombrecarrera, C.codigocarrera, FG.FechaMaximaCumplimiento, FG.FechaGradoId, AC.AcuerdoActaId, 
					DAC.DetalleAcuerdoActaId, DAC.EnviarCorreoSecretaria, DAC.EnviarCorreoVicerrectoria, EG.expedidodocumento
				FROM
					estudiantegeneral EG
				INNER JOIN estudiante E ON ( E.idestudiantegeneral = EG.idestudiantegeneral )
				INNER JOIN carrera C ON ( C.codigocarrera = E.codigocarrera )
				INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
				INNER JOIN FechaGrado FG ON ( FG.CarreraId = C.codigocarrera )
				INNER JOIN AcuerdoActa AC ON ( AC.FechaGradoId = FG.FechaGradoId )
				INNER JOIN DetalleAcuerdoActa DAC ON ( DAC.AcuerdoActaId = AC.AcuerdoActaId AND E.codigoestudiante = DAC.EstudianteId )
				WHERE FG.FechaGradoId = ?
				AND DAC.CodigoEstado = 100
				AND DAC.EstadoAcuerdo IN ( 0, 100 )
				AND AC.AcuerdoActaId = ?
				";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado , false );
		$this->persistencia->setParametro( 1 , $txtIdActaAcuerdo , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
			$detalleActaAcuerdo->setIdDetalleActaAcuerdo( $this->persistencia->getParametro( "DetalleAcuerdoActaId" ) );
			$detalleActaAcuerdo->setEstadoEnvioSecretaria( $this->persistencia->getParametro( "EnviarCorreoSecretaria" ) );
			$detalleActaAcuerdo->setEstadoEnvioVicerrectoria( $this->persistencia->getParametro( "EnviarCorreoVicerrectoria" ) );
			
			$actaAcuerdo = new ActaAcuerdo( null );
			$actaAcuerdo->setIdActaAcuerdo( $this->persistencia->getParametro( "AcuerdoActaId" ) );
			
			$estudiante = new Estudiante( null );
			$estudiante->setIdEstudiante( $this->persistencia->getParametro( "idestudiantegeneral" ) );
			$estudiante->setCodigoEstudiante( $this->persistencia->getParametro( "codigoestudiante" ) );
			$estudiante->setNombreEstudiante( $this->persistencia->getParametro( "Nombre" ) );
			$estudiante->setNumeroDocumento($this->persistencia->getParametro( "numerodocumento" ));
			$estudiante->setExpedicion( $this->persistencia->getParametro( "expedidodocumento" ) );
			
			$fechaGrado = new FechaGrado( null );
			$fechaGrado->setIdFechaGrado( $this->persistencia->getParametro( "FechaGradoId" ) );
			$fechaGrado->setFechaMaxima( $this->persistencia->getParametro( "FechaMaximaCumplimiento" ) );
			
			$carrera = new Carrera( null );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			
			$fechaGrado->setCarrera( $carrera );
			
			$estudiante->setFechaGrado( $fechaGrado );
			
			
			$detalleActaAcuerdo->setActaAcuerdo( $actaAcuerdo );
			$detalleActaAcuerdo->setEstudiante( $estudiante );
			
			$detalleActaAcuerdos[ count( $detalleActaAcuerdos ) ] = $detalleActaAcuerdo;
		}
		$this->persistencia->freeResult( );
		
		return 	$detalleActaAcuerdos;
		
		
	}
	
	/**
	 * Actualizar Envio a Secretaria
	 * @param $txtIdActaAcuerdo, $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function actualizarEnvioSecretaria( $txtIdActaAcuerdo, $txtCodigoEstudiante ){
		
		$sql = "UPDATE DetalleAcuerdoActa
				SET EnviarCorreoSecretaria = 100
				WHERE
					AcuerdoActaId = ?
				AND EstudianteId = ?
				AND CodigoEstado = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtIdActaAcuerdo , false );
		$this->persistencia->setParametro( 1 , $txtCodigoEstudiante , false );
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
	 * Actualizar Envio a Vicerrectoria
	 * @param $txtIdActaAcuerdo, $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function actualizarEnvioVicerrectoria( $txtIdActaAcuerdo, $txtCodigoEstudiante ){
		
		$sql = "UPDATE DetalleAcuerdoActa
				SET EnviarCorreoVicerrectoria = 100
				WHERE
					AcuerdoActaId = ?
				AND EstudianteId = ?
				AND CodigoEstado = 100
				AND EnviarCorreoSecretaria = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtIdActaAcuerdo , false );
		$this->persistencia->setParametro( 1 , $txtCodigoEstudiante , false );
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
	 * registro detalle acta acuerdo opciona adicionar grado
	 * @param $idPersona
	 * @access public
	 * @return void
	 */
        public function crearDetalleACAdiconal( $idPersona ){
		$sql = "INSERT INTO DetalleAcuerdoActa (
                            DetalleAcuerdoActaId,
                            DirectivoId,
                            AcuerdoActaId,
                            EstudianteId,
                            CodigoEstado,
                            EstadoAcuerdo,
                            EnviarCorreoSecretaria,
                            EnviarCorreoVicerrectoria,
                            UsuarioCreacion,
                            FechaCreacion
                            )
				VALUES
					((SELECT IFNULL( MAX( DAC.DetalleAcuerdoActaId ) +1, 1 ) 
							FROM DetalleAcuerdoActa DAC),?,?,?,100,100,100,100,?,now())";
						
		$this->persistencia->crearSentenciaSQL( $sql );
                $this->persistencia->setParametro( 0 , $this->getDirectivo( ), false );
		$this->persistencia->setParametro( 1 , $this->getActaAcuerdo( )->getIdActaAcuerdo( ) , false );
		$this->persistencia->setParametro( 2 , $this->getEstudiante( )->getCodigoEstudiante( ) , false );
		$this->persistencia->setParametro( 3 , $idPersona , false );		
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