<?php
    /**
	 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Dirección de Tecnología - Universidad el Bosque
	 * @package entidades
	 */
	
	class EstudianteDocumento{
		
		/**
		 * @type int
		 * @access private
		 */
		private $idEstudianteDocumento;
		
		/**
		 * @type int
		 * @access private
		 */
		private $estudiante;
		
		/**
		 * @type date
		 * @access private
		 */
		private $fechaVencimientoEstudianteDocumento;
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param $persistencia Singleton
		 */
		public function EstudianteDocumento( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Modifica el idEstudianteDocumento
		 * @param int $idEstudianteDocumento
		 * @access public
		 * @return void
		 */
		public function setIdEstudianteDocumento( $idEstudianteDocumento ){
			$this->idEstudianteDocumento = $idEstudianteDocumento;
		}
		
		/**
		 * Retorna el idEstudianteDocumento
		 * @access public
		 * @return int
		 */
		public function getIdEstudianteDocumento( ){
			return $this->idEstudianteDocumento;
		}
		
		/**
		 * Modifica el Estudiante de EstudianteDocumento
		 * @param int $idEstudianteDocumento
		 * @access public
		 * @return void
		 */
		public function setEstudiante( $estudiante ){
			$this->estudiante = $estudiante;
		}
		
		/**
		 * Retorna el idEstudianteDocumento
		 * @access public
		 * @return int
		 */
		public function getEstudiante( ){
			return $this->estudiante;
		}
		
		/**
		 * Modifica la fecha de vencimiento del Estudiante de EstudianteDocumento
		 * @param int $idEstudianteDocumento
		 * @access public
		 * @return void
		 */
		public function setFechaVencimientoEstudianteDocumento( $fechaVencimientoEstudianteDocumento ){
			$this->fechaVencimientoEstudianteDocumento = $fechaVencimientoEstudianteDocumento;
		}
		
		/**
		 * Retorna la fecha de vencimiento del Estudiante de EstudianteDocumento
		 * @access public
		 * @return date
		 */
		public function getFechaVencimientoEstudianteDocumento( ){
			return $this->fechaVencimientoEstudianteDocumento;
		}
		
	/**
	 * Actualiza Datos Estudiante
	 * @access public
	 * @return Booelan
	 */
	public function actualizarEstudianteDocumento( $txtIdEstudiante, $txtIdEstudianteDocumento ){
		
		$sql = "UPDATE estudiantedocumento 
				SET fechavencimientoestudiantedocumento = CURDATE()
				WHERE idestudiantegeneral = ?
				AND idestudiantedocumento = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtIdEstudiante , false );
		$this->persistencia->setParametro( 1 , $txtIdEstudianteDocumento , false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$estado = $this->persistencia->ejecutarUpdate( );
		
		if( $estado )
			$this->persistencia->confirmarTransaccion( );
		else	
			$this->persistencia->cancelarTransaccion( );
					
		//$this->persistencia->freeResult( );
		return $estado;
	}
	
	/**
	 * Actualiza Datos Estudiante
	 * @access public
	 * @return Booelan
	 */
	public function crearEstudianteDocumento( $txtIdEstudiante, $txtTipoDocumento, $txtNumeroDocumento, $txtExpedidoDocumento ){
		
		$sql = "INSERT INTO estudiantedocumento(
				idestudiantegeneral, 
				tipodocumento, 
				numerodocumento, 
				expedidodocumento, 
				fechainicioestudiantedocumento, 
				fechavencimientoestudiantedocumento )
				VALUES(?,?,?,?,CURDATE(),'2999-12-31')";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtIdEstudiante , false );
		
		$this->persistencia->setParametro( 1 , $txtTipoDocumento , true );
		$this->persistencia->setParametro( 2 , $txtNumeroDocumento , true );
		$this->persistencia->setParametro( 3 , $txtExpedidoDocumento , true );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$estado = $this->persistencia->ejecutarUpdate( );
		
		if( $estado )
			$this->persistencia->confirmarTransaccion( );
		else	
			$this->persistencia->cancelarTransaccion( );
					
		//$this->persistencia->freeResult( );
		return $estado;
	}
	
	/**
	 * Buscar Estudiante por Codigo
	 * @param $txtCodigoEstudiante
	 * @access public
	 */
	public function buscarEstudianteDocumento( $txtIdEstudiante, $txtTipoDocumento, $txtNumeroDocumento ){
		
		$sql = "SELECT idestudiantedocumento, idestudiantegeneral, tipodocumento, numerodocumento, expedidodocumento, fechavencimientoestudiantedocumento
				FROM estudiantedocumento 
				WHERE idestudiantegeneral = ?
				AND tipodocumento = ?
				AND numerodocumento = ?
				";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtIdEstudiante , false );
		$this->persistencia->setParametro( 1 , $txtTipoDocumento , true );
		$this->persistencia->setParametro( 2 , $txtNumeroDocumento , true );
		
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setIdEstudianteDocumento( $this->persistencia->getParametro( "idestudiantedocumento" ) );
			$this->setFechaVencimientoEstudianteDocumento( $this->persistencia->getParametro( "fechavencimientoestudiantedocumento" ) );
			
			$estudiante = new Estudiante( null );
			$estudiante->setIdEstudiante( $this->persistencia->getParametro( "idestudiantegeneral" ) );
			$estudiante->setNumeroDocumento( $this->persistencia->getParametro( "numerodocumento" ) );
			$estudiante->setExpedicion( $this->persistencia->getParametro( "expedidodocumento" ) );
			
			$tipoDocumento = new TipoDocumento( null );
			$tipoDocumento->setIniciales( $this->persistencia->getParametro( "tipodocumento" ) );
			
			$estudiante->setTipoDocumento( $tipoDocumento );
			
			$this->setEstudiante( $estudiante );
		}
		
		$this->persistencia->freeResult( );
		
	}

	/**
	 * Actualiza Datos Estudiante
	 * @access public
	 * @return Booelan
	 */
	public function actualizarFechaVencimientoEstudianteDocumento( $txtIdEstudiante, $txtIdEstudianteDocumento ){
		
		$sql = "UPDATE estudiantedocumento 
				SET fechavencimientoestudiantedocumento = '2999-12-31'
				WHERE idestudiantegeneral = ?
				AND idestudiantedocumento = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtIdEstudiante , false );
		$this->persistencia->setParametro( 1 , $txtIdEstudianteDocumento , false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$estado = $this->persistencia->ejecutarUpdate( );
		
		if( $estado )
			$this->persistencia->confirmarTransaccion( );
		else	
			$this->persistencia->cancelarTransaccion( );
					
		//$this->persistencia->freeResult( );
		return $estado;
	}
		
		
	}
?>