<?php
   /**
    * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package entidades
    */
 
   class IncentivoAcademico{
   	
	/**
	 * @type int
	 * @access private
	 */
	private $idIncentivo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoIncentivo;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreIncentivo;
	
	/**
	 * @type String
	 * @access private
	 */
	private $observacionIncentivo;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaActaIncentivo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $numeroActaIncentivo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $numeroActaAcuerdoIncentivo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $numeroAcuerdoIncentivo;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaAcuerdoIncentivo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $numeroConsecutivoIncentivo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoIncentivo;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor 
	 * @param $persistencia Singleton
	 */
	public function IncentivoAcademico( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador del Incentivo
	 * @param int $idIncentivo
	 * @access public
	 * @return void
	 */
	public function setIdIncentivo( $idIncentivo ){
		$this->idIncentivo = $idIncentivo;
	}
	
	/**
	 * Retorna el identificador del Incentivo
	 * @access public
	 * @return int
	 */
	public function getIdIncentivo( ){
		return $this->idIncentivo;
	}
	
	/**
	 * Modifica el codigo del Incentivo
	 * @param int $codigoIncentivo
	 * @access public
	 * @return void
	 */
	public function setCodigoIncentivo( $codigoIncentivo ){
		$this->codigoIncentivo = $codigoIncentivo;
	}
	
	/**
	 * Retorna el codigo del Incentivo
	 * @access public
	 * @return int
	 */
	public function getCodigoIncentivo( ){
		return $this->codigoIncentivo;
	}
	
	/**
	 * Modifica el nombre del incentivo
	 * @param string $nombreIncentivo
	 * @access public
	 * @return void
	 */
	public function setNombreIncentivo( $nombreIncentivo ){
		$this->nombreIncentivo = $nombreIncentivo;
	}
	
	/**
	 * Retorna el nombre del incentivo
	 * @access public
	 * @return string
	 */
	public function getNombreIncentivo( ){
		return $this->nombreIncentivo;
	}
	
	/**
	 * Modifica el nombre del incentivo
	 * @param string $nombreIncentivo
	 * @access public
	 * @return void
	 */
	public function setObservacionIncentivo( $observacionIncentivo ){
		$this->observacionIncentivo = $observacionIncentivo;
	}
	
	/**
	 * Retorna el nombre del incentivo
	 * @access public
	 * @return string
	 */
	 
	 public function getObservacionIncentivo( ){
	 	return $this->observacionIncentivo;
	 }
	
	/**
	 * Modifica la fecha del acta del incentivo
	 * @param date $fechaActaIncentivo
	 * @access public
	 * @return void
	 */
	public function setFechaActaIncentivo( $fechaActaIncentivo ){
		$this->fechaActaIncentivo = $fechaActaIncentivo;
	}
	
	/**
	 * Retorna la fecha del acta del incentivo
	 * @access public
	 * @return date
	 */
	public function getFechaActaIncentivo( ){
		return $this->fechaActaIncentivo;
	}
	
	/**
	 * Modifica el numero de acta del incentivo
	 * @param int $numeroActaIncentivo
	 * @access public
	 * @return void
	 */
	public function setNumeroActaIncentivo( $numeroActaIncentivo ){
		$this->numeroActaIncentivo = $numeroActaIncentivo;
	}
	
	/**
	 * Retorna el numero de acta del incentivo
	 * @access public
	 * @return int
	 */
	public function getNumeroActaIncentivo( ){
		return $this->numeroActaIncentivo;
	}
	
	/**
	 * Modifica el numero de acta del acuerdo del incentivo
	 * @param int $numeroActaAcuerdoIncentivo
	 * @access public
	 * @return void
	 */
	public function setNumeroActaAcuerdoIncentivo( $numeroActaAcuerdoIncentivo ){
		$this->numeroActaAcuerdoIncentivo = $numeroActaAcuerdoIncentivo;
	}
	
	/**
	 * Retorna el numero de acta del acuerdo incentivo
	 * @access public
	 * @return int
	 */
	public function getNumeroActaAcuerdoIncentivo( ){
		return $this->numeroActaAcuerdoIncentivo;
	}
	
	/**
	 * Modifica el numero de acuerdo del incentivo
	 * @param int $numeroActaAcuerdoIncentivo
	 * @access public
	 * @return void
	 */
	public function setNumeroAcuerdoIncentivo( $numeroAcuerdoIncentivo ){
		$this->numeroAcuerdoIncentivo = $numeroAcuerdoIncentivo;
	}
	
	/**
	 * Retorna el numero de acuerdo del incentivo
	 * @access public
	 * @return int
	 */
	public function getNumeroAcuerdoIncentivo( ){
		return $this->numeroAcuerdoIncentivo;
	}
	
	
	/**
	 * Modifica la fecha de acuerdo del incentivo
	 * @param int $numeroActaAcuerdoIncentivo
	 * @access public
	 * @return void
	 */
	public function setFechaAcuerdoIncentivo( $fechaAcuerdoIncentivo ){
		$this->fechaAcuerdoIncentivo = $fechaAcuerdoIncentivo;
	}
	
	/**
	 * Retorna  la fecha de acuerdo del incentivo
	 * @access public
	 * @return date
	 */
	public function getFechaAcuerdoIncentivo( ){
		return $this->fechaAcuerdoIncentivo;
	}
	
	/**
	 * Modifica el numero consecutivo del incentivo
	 * @param int $numeroConsecutivoIncentivo
	 * @access public
	 * @return void
	 */
	public function setNumeroConsecutivoIncentivo( $numeroConsecutivoIncentivo ){
		$this->numeroConsecutivoIncentivo = $numeroConsecutivoIncentivo;
	}
	
	/**
	 * Retorna el numero consecutivo del incentivo
	 * @access public
	 * @return int
	 */
	public function getNumeroConsecutivoIncentivo( ){
		return $this->numeroConsecutivoIncentivo;
	}
	
	
	/**
	 * Modifica el estado del incentivo
	 * @param int $estadoIncentivo
	 * @access public
	 * @return void
	 */
	public function setEstadoIncentivo( $estadoIncentivo ){
		$this->estadoIncentivo = $estadoIncentivo;
	}
	
	/**
	 * Retorna el estado del incentivo
	 * @access public 
	 * @return int
	 */
	public function getEstadoIncentivo( ){
		return $this->estadoIncentivo;
	}
	
	/**
	 * Consultar Incentivo
	 * @access public
	 * @return Array
	 */
	public function consultarIncentivo( ){
		$incentivos = array( );
		$sql = "SELECT idincentivoacademico, nombreincentivoacademico, codigoestado 
				FROM incentivoacademico
				WHERE idincentivoacademico != 1
				AND codigoestado = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$incentivo = new IncentivoAcademico( null );
			$incentivo->setIdIncentivo( $this->persistencia->getParametro( "idincentivoacademico" ) );
			$incentivo->setNombreIncentivo( $this->persistencia->getParametro( "nombreincentivoacademico" ) );
			$incentivo->setEstadoIncentivo( $this->persistencia->getParametro( "codigoestado" ) );
			
			$incentivos[ count( $incentivos ) ] = $incentivo;
		}
		
		$this->persistencia->freeResult( );
		
		return 	$incentivos;
	}
	
	
	/**
	 * Inserta el incentivo del estudiante
	 * @access public
	 * @return Boolean 
	 */
	public function crearRegistroIncentivo( $txtCodigoEstudiante, $txtCodigoIncentivo, $txtCodigoCarrera, $txtNombreIncentivo, $txtNumeroIncentivo, $txFechaActaIncentivo, $txtObservacionIncentivo, $idPersona ){
		$sql = "INSERT INTO RegistroIncentivo (
					RegistroIncentivoId,
					EstudianteId,
					IncentivoAcademicoId,
					CarreraId,
					FechaIncentivoAcademico,
					NombreIncentivoAcademico,
					NumeroActaIncentivo,
					FechaActaIncentivo,
					ObservacionIncentivo,
					CodigoEstado,
					UsuarioId
				)
				VALUES
					((SELECT IFNULL( MAX( RG.RegistroIncentivoId ) +1, 1 ) 
							FROM RegistroIncentivo RG), ?, ?, ?, NOW(), ?, ?, ?, ?, 100, ?)";
						
		$this->persistencia->crearSentenciaSQL( $sql );


		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
		$this->persistencia->setParametro( 1 , $txtCodigoIncentivo , false );
		$this->persistencia->setParametro( 2 , $txtCodigoCarrera , false );
		$this->persistencia->setParametro( 3 , $txtNombreIncentivo , true );
		$this->persistencia->setParametro( 4 , $txtNumeroIncentivo , false );

		$this->persistencia->setParametro( 5 , $txFechaActaIncentivo, true );
		
		$this->persistencia->setParametro( 6 , $txtObservacionIncentivo , true );
		
		$this->persistencia->setParametro( 7 , $idPersona , false );
		
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
	 * Buscar Incentivo por Id
	 * @param int $txtCodigoIncentivo
	 * @access public
	 * @return String
	 */
	public function buscarIncentivoId( ){
		$sql = "SELECT idincentivoacademico, nombreincentivoacademico 
				FROM incentivoacademico
				WHERE idincentivoacademico = ?";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getIdIncentivo( ) , false );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setIdIncentivo( $this->persistencia->getParametro( "idincentivoacademico" ) );
			$this->setNombreIncentivo( $this->persistencia->getParametro( "nombreincentivoacademico" ) );
		}
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->freeResult( );
	}
	
	/**
	 * Consulta si existe un incentivo
	 * @access public
	 * @return int
	 */
	 public function existeIncentivo( $txtCodigoEstudiante, $txtCodigoIncentivo, $txtCodigoCarrera ) {
		$sql = "SELECT COUNT(RegistroIncentivoId) AS cantidad_incentivo 
				FROM RegistroIncentivo
				WHERE EstudianteId = ?
				AND IncentivoAcademicoId = ?
				AND CarreraId = ?
				AND CodigoEstado = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
		$this->persistencia->setParametro( 1 , $txtCodigoIncentivo , false );
		$this->persistencia->setParametro( 2 , $txtCodigoCarrera , false );
		
		$this->persistencia->ejecutarConsulta(  );
		//echo $this->persistencia->getSQLListo( );
		$cantidad = 0;
		
		if( $this->persistencia->getNext( ) )
			$cantidad = $this->persistencia->getParametro( "cantidad_incentivo" );
		
		$this->persistencia->freeResult( );
		
		return $cantidad;
				
	}
	
	
	/**
	 * Consulta Incentivos Estudiantes
	 * @param int $txtCodigoEstudiante, $txtCodigoCarrera
	 * @access public
	 * @return String
	 */
	public function listarIncentivoEstudiante( $txtCodigoEstudiante, $txtCodigoCarrera ){
		$incentivos = array( );
		$sql = "SELECT RegistroIncentivoId, IncentivoAcademicoId, NombreIncentivoAcademico, FechaActaIncentivo, NumeroActaIncentivo, CodigoEstado, NumeroActaAcuerdoIncentivo,
				NumeroAcuerdoIncentivo, FechaAcuerdoIncentivo, NumeroConsecutivoIncentivo
				FROM RegistroIncentivo
				WHERE EstudianteId = ?
				AND CarreraId = ?
				AND CodigoEstado = 100
				ORDER BY IncentivoAcademicoId";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
		$this->persistencia->setParametro( 1 , $txtCodigoCarrera , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$incentivo = new IncentivoAcademico( null );
			$incentivo->setIdIncentivo( $this->persistencia->getParametro( "RegistroIncentivoId" ) );
			$incentivo->setCodigoIncentivo( $this->persistencia->getParametro( "IncentivoAcademicoId" ) );
			$incentivo->setNombreIncentivo( $this->persistencia->getParametro( "NombreIncentivoAcademico" ) );
			$incentivo->setFechaActaIncentivo( $this->persistencia->getParametro( "FechaActaIncentivo" ) );
			$incentivo->setNumeroActaIncentivo( $this->persistencia->getParametro( "NumeroActaIncentivo" ) );
			$incentivo->setEstadoIncentivo( $this->persistencia->getParametro( "CodigoEstado" ) );
			$incentivo->setNumeroActaAcuerdoIncentivo( $this->persistencia->getParametro( "NumeroActaAcuerdoIncentivo" ) );
			$incentivo->setNumeroAcuerdoIncentivo( $this->persistencia->getParametro( "NumeroAcuerdoIncentivo" ) );
			$incentivo->setFechaAcuerdoIncentivo( $this->persistencia->getParametro( "FechaAcuerdoIncentivo" ) );
			$incentivo->setNumeroConsecutivoIncentivo( $this->persistencia->getParametro( "NumeroConsecutivoIncentivo" ) );
			
			$incentivos[ count( $incentivos ) ] = $incentivo;
		}
		
		$this->persistencia->freeResult( );
		
		return 	$incentivos;
	}
	
	/**
	 * Anular Incentivos
	 * @param int txtIdDetalleActa
	 * @access public
	 * @return void
	 */
          /**
        *@modified Diego Rivera<riveradiego@unbosque.edu.co>
        *Se añade varialbe idpersona a metodo actualizar incentivo con el fin de guardar el usuario que realiza el cambio
        *@Since January 29,2019 
        */
	public function anularIncentivos( $txtIdRegistroIncentivo , $idPersona ){
		
		$sql = "UPDATE RegistroIncentivo
				SET 
				 CodigoEstado = 200 ,
                                 FechaModificacion = now(),
				 UsuarioIdModificacion = ?
				WHERE
					RegistroIncentivoId = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
                $this->persistencia->setParametro( 0 , $idPersona , false );
		$this->persistencia->setParametro( 1 , $txtIdRegistroIncentivo , false );
                //   echo $this->persistencia->getSQLListo( );
		$estado = $this->persistencia->ejecutarUpdate( );
		 $this->persistencia->getSQLListo( );
		
		if( $estado )
			$this->persistencia->confirmarTransaccion( );
		else	
			$this->persistencia->cancelarTransaccion( );
					
		//$this->persistencia->freeResult( );
		return $estado;
	}
	
	/**
	 * Consulta si existe un incentivo por estudiante y Carrera
	 * @access public
	 * @return int
	 */
	 public function existeIncentivoEstudiante( $txtCodigoEstudiante, $txtCodigoCarrera ) {
		$sql = "SELECT COUNT(RegistroIncentivoId) AS cantidadIncentivoEstudiante 
				FROM RegistroIncentivo
				WHERE EstudianteId = ?
				AND CarreraId = ?
				AND CodigoEstado = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
		$this->persistencia->setParametro( 1 , $txtCodigoCarrera , false );
		
		$this->persistencia->ejecutarConsulta(  );
		//echo $this->persistencia->getSQLListo( );
		$cantidad = 0;
		
		if( $this->persistencia->getNext( ) )
			$cantidad = $this->persistencia->getParametro( "cantidadIncentivoEstudiante" );
		
		$this->persistencia->freeResult( );
		
		return $cantidad;
				
	}
	 
	 
	/**
	 * Consulta si existe un incentivo por Fecha Grado
	 * @access public
	 * @return int
	 */
	 public function existeIncentivoFechaGrado( $txtFechaGrado ) {
		$sql = "SELECT COUNT(RI.RegistroIncentivoId) AS cantidad_incentivoFechaGrado 
				FROM RegistroIncentivo RI
				INNER JOIN FechaGrado F ON ( F.CarreraId = RI.CarreraId )
				WHERE F.FechaGradoId = ?
				AND RI.CodigoEstado = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtFechaGrado , false );
		
		$this->persistencia->ejecutarConsulta(  );
		//echo $this->persistencia->getSQLListo( );
		$cantidad = 0;
		
		if( $this->persistencia->getNext( ) )
			$cantidad = $this->persistencia->getParametro( "cantidad_incentivoFechaGrado" );
		
		$this->persistencia->freeResult( );
		
		return $cantidad;
				
	}
	 
	 /**
	 * Buscar Incentivo por Estudiante 
	 * @param int $txtCodigoIncentivo
	 * @access public
	 * @return String
	 */
	public function buscarIncentivo( $txtCodigoEstudiante, $txtCodigoCarrera , $txtIncentivoId ){
		$sql = "SELECT RegistroIncentivoId, IncentivoAcademicoId, NombreIncentivoAcademico, FechaActaIncentivo, NumeroActaIncentivo
				FROM RegistroIncentivo
				WHERE EstudianteId = ?
				AND CarreraId = ?
				AND CodigoEstado = 100";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
		$this->persistencia->setParametro( 1 , $txtCodigoCarrera, false );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setIdIncentivo( $this->persistencia->getParametro( "RegistroIncentivoId" ) );
			$this->setCodigoIncentivo( $this->persistencia->getParametro( "IncentivoAcademicoId" ) );
			$this->setNombreIncentivo( $this->persistencia->getParametro( "NombreIncentivoAcademico" ) );
			$this->setFechaActaIncentivo( $this->persistencia->getParametro( "FechaActaIncentivo" ) );
			$this->setNumeroActaIncentivo( $this->persistencia->getParametro( "NumeroActaIncentivo" ) );
		}
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->freeResult( );
	}
	
	/**
	 * Actualizar Acuerdo Incentivo
	 * @param int txtIdDetalleActa
	 * @access public
	 * @return void
	 */
	public function actualizarAcuerdoIncentivo( $txtNumeroActaIncentivo, $txtNumeroAcuerdoIncentivo, $txtFechaIncentivo, $txtNumeroConsecutivoIncentivo, $txtCodigoEstudiante, $txtIdRegistroIncentivo ){
		
		$sql = "UPDATE RegistroIncentivo
				SET NumeroActaAcuerdoIncentivo = ?,
				 NumeroAcuerdoIncentivo = ?,
				 FechaAcuerdoIncentivo = ?,
				NumeroConsecutivoIncentivo = ?
				WHERE
					EstudianteId = ?
				AND RegistroIncentivoId = ?;";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtNumeroActaIncentivo , false );
		$this->persistencia->setParametro( 1 , $txtNumeroAcuerdoIncentivo , false );
		$this->persistencia->setParametro( 2 , $txtFechaIncentivo , true );
		$this->persistencia->setParametro( 3 , $txtNumeroConsecutivoIncentivo , true );
		$this->persistencia->setParametro( 4 , $txtCodigoEstudiante , false );
		$this->persistencia->setParametro( 5 , $txtIdRegistroIncentivo , false );
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
	 * Actualizar Acuerdo Incentivo
	 * @param int $txtCodigoEstudiante, $txtCodigoCarrera
	 * @access public
	 * @return array incentivo
	 */


		public function VerIncentivoEstudiante( $txtCodigoEstudiante, $txtCodigoCarrera ){
		
			$incentivos = array();
			$sql = "SELECT  nombreincentivoacademico,IncentivoAcademicoId,ObservacionIncentivo
					FROM RegistroIncentivo
					WHERE EstudianteId = ?
					AND CarreraId = ?
					AND CodigoEstado = 100";
			
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
			$this->persistencia->setParametro( 1 , $txtCodigoCarrera, false );
			$this->persistencia->ejecutarConsulta( );
			//echo $this->persistencia->getSQLListo( );
			while( $this->persistencia->getNext( ) ){
				$incentivo = new IncentivoAcademico( null );
				$incentivo->setNombreIncentivo( $this->persistencia->getParametro( "nombreincentivoacademico" ) );
				$incentivo->setCodigoIncentivo( $this->persistencia->getParametro( "IncentivoAcademicoId" ) );
				$incentivo->setObservacionIncentivo( $this->persistencia->getParametro( "ObservacionIncentivo" ) );
				$incentivos[ ] = $incentivo;
			}
			
			return 	$incentivos;

	}
	
	
	public function buscarIncentivoEstudiante ( $estudianteId , $carreraId  ){
	
                /*@Modified Diego Rivera <riveraDiego@unbosque.edu.co>
                *Se añade campo incentivoacademico en consulta sql 
                *Since August 09 ,2018 
                */
		$sql = "SELECT 
					 RegistroIncentivoId,
					 NombreIncentivoAcademico,
					 FechaActaIncentivo,
					 NumeroActaIncentivo,
					 ObservacionIncentivo,
					 NumeroConsecutivoIncentivo,
                                         IncentivoAcademicoId

				FROM RegistroIncentivo
				WHERE
					 EstudianteId = ?
					AND CarreraId = ? AND CodigoEstado = 100";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $estudianteId , false );
		$this->persistencia->setParametro( 1 , $carreraId, false );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setIdIncentivo( $this->persistencia->getParametro( "RegistroIncentivoId" ) );
			$this->setNombreIncentivo( $this->persistencia->getParametro( "NombreIncentivoAcademico" ) );
			$this->setFechaActaIncentivo( $this->persistencia->getParametro( "FechaActaIncentivo" ) );
			$this->setNumeroActaIncentivo( $this->persistencia->getParametro( "NumeroActaIncentivo" ) );
			$this->setObservacionIncentivo( $this->persistencia->getParametro( "ObservacionIncentivo" ) );
                        $this->setCodigoIncentivo($this->persistencia->getParametro( "IncentivoAcademicoId" ) );
			$this->setNumeroConsecutivoIncentivo( $this->persistencia->getParametro( "NumeroConsecutivoIncentivo" ) );
		}
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->freeResult( );
	}
	
	/**
	 * actualizarIncentivoRegistro
	 * @param  int $acta , int $id
	 * @param  string $fecha ,  $observacio
	 * @access public
	 * @return void
	 */

	public function actualizarIncentivoRegistro( $acta , $fecha , $observacion , $id , $idPersona ){
		
		$sql = "UPDATE RegistroIncentivo
				SET
					NumeroActaIncentivo = ?,
				 	FechaActaIncentivo = ?,
				 	ObservacionIncentivo = ?,
				 	FechaModificacion = now(),
				 	UsuarioIdModificacion = ?

				WHERE
				 RegistroIncentivoId = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $acta , true );
		$this->persistencia->setParametro( 1 , $fecha , true );
		$this->persistencia->setParametro( 2 , $observacion , true );
		$this->persistencia->setParametro( 3 , $idPersona , false );
		$this->persistencia->setParametro( 4 , $id , false );

		$estado = $this->persistencia->ejecutarUpdate( );
		return $estado;
	}




	public function buscarIncentivoEstudiantes ( $estudianteId , $carreraId , $incentivoId ){
	

		$sql = "SELECT 
					 RegistroIncentivoId,
					 NombreIncentivoAcademico,
					 FechaActaIncentivo,
					 NumeroActaIncentivo,
					 ObservacionIncentivo,
					 NumeroConsecutivoIncentivo

				FROM RegistroIncentivo
				WHERE
					 EstudianteId = ?
					AND CarreraId = ?
					AND IncentivoAcademicoId = ?
					AND CodigoEstado = 100";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $estudianteId , false );
		$this->persistencia->setParametro( 1 , $carreraId, false );
		$this->persistencia->setParametro( 2 , $incentivoId, false );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setIdIncentivo( $this->persistencia->getParametro( "RegistroIncentivoId" ) );
			$this->setNombreIncentivo( $this->persistencia->getParametro( "NombreIncentivoAcademico" ) );
			$this->setFechaActaIncentivo( $this->persistencia->getParametro( "FechaActaIncentivo" ) );
			$this->setNumeroActaIncentivo( $this->persistencia->getParametro( "NumeroActaIncentivo" ) );
			$this->setObservacionIncentivo( $this->persistencia->getParametro( "ObservacionIncentivo" ) );
			$this->setNumeroConsecutivoIncentivo( $this->persistencia->getParametro( "NumeroConsecutivoIncentivo" ) );
		}
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->freeResult( );
	}
	
	
 }
?>