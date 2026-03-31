<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Universidad el Bosque
   * @package entidades
   */
  
  class DeudaPeople{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $idDeudaPeople;
	
	/**
	 * @type Estudiante
	 * @access private
	 */
	private $estudiante;
	
	/**
	 * @type string
	 * @access private
	 */
	private $datosPeople;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoImagen;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoDeuda;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia Singleton
	 */
	public function DeudaPeople( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el id de la deuda de people
	 * @param int $idDeudaPeople
	 * @access public
	 * @return void 
	 */
	public function setIdDeudaPeople( $idDeudaPeople ){
		$this->idDeudaPeople = $idDeudaPeople;
	}
	
	/**
	 * Retorna el id de la deuda de people
	 * @access public
	 * @return int
	 */
	public function getIdDeudaPeople( ){
		return $this->idDeudaPeople;
	}
	
	/**
	 * Modifica el estudiante de la deuda de people
	 * @param $estudiante Estudiante
	 * @access public
	 * @return void 
	 */
	public function setEstudiante( $estudiante ){
		$this->estudiante = $estudiante;
	}
	
	/**
	 * Retorna el estudiante de la deuda de people
	 * @access public
	 * @return Estudiante
	 */
	public function getEstudiante( ){
		return $this->estudiante;
	}
	
	/**
	 * Modifica los datos de la deuda de people
	 * @param string $datosPeople
	 * @access public
	 * @return void
	 */
	public function setDatosPeople( $datosPeople ){
		$this->datosPeople = $datosPeople;
	}
	
	/**
	 * Retorna los datos de la deuda de people
	 * @access public
	 * @return string
	 */
	public function getDatosPeople( ){
		return $this->datosPeople;
	}
	
	/**
	 * Modifica el estado de la imagen de la deuda de people
	 * @param int $estadoImagen
	 * @access public
	 * @return void
	 */
	public function setEstadoImagen( $estadoImagen ){
		$this->estadoImagen = $estadoImagen;
	}
	
	/**
	 * Retorna el estado de la imagen de la deuda de people
	 * @access public
	 * @return int
	 */
	public function getEstadoImagen( ){
		return $this->estadoImagen;
	}
	
	/**
	 * Modifica el estado de la deuda de people
	 * @param int $estadoDeuda
	 * @access public
	 * @return int
	 */
	public function setEstadoDeuda( $estadoDeuda ){
		$this->estadoDeuda = $estadoDeuda;
	}
	
	/**
	 * Retorna el estado de la deuda de people
	 * @access public
	 * @return int
	 */
	public function getEstadoDeuda( ){
		return $this->estadoDeuda;
	}

	
	/**
	 * Inserta la fecha de grado de la carrera
	 * @access public
	 * @return Boolean 
	 */
	public function crearDeudaPeople( $txtCodigoEstudiante ){
		$sql = "INSERT INTO DeudaPeopleGrado (
					DeudaPeopleGradoId,
					EstudianteId,
					CodigoEstado
				)
				VALUES
					(( SELECT IFNULL( MAX( DP.DeudaPeopleGradoId ) +1, 1 ) 
							FROM DeudaPeopleGrado DP
							 ), ?, 100 )";
						
		$this->persistencia->crearSentenciaSQL( $sql );


		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
				
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
	 * Consulta si existe deuda Estudiante
	 * @access public
	 * @return int
	 */
	 public function existeDeudaPeople ( $txtCodigoEstudiante ) {
	 	
		$sql = "SELECT COUNT(DeudaPeopleGradoId) cantidad_deuda
				FROM DeudaPeopleGrado
				WHERE EstudianteId = ?
				AND CodigoEstado = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		$cantidad = 0;
		
		if( $this->persistencia->getNext( ) )
			$cantidad = $this->persistencia->getParametro( "cantidad_deuda" );
		
		$this->persistencia->freeResult( );
		
		return $cantidad;
				
	}
	 
	 
	 /**
	 * Actualizar Deuda People
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function actualizarDeudaPeople( $txtCodigoEstudiante ){
		
		$sql = "UPDATE DeudaPeopleGrado
				SET CodigoEstado = 200
				WHERE EstudianteId = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
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
	 * Consulta si existe deuda Estudiante
	 * @access public
	 * @return int
	 */
	 public function contarDeudaPeople( ) {
	 	
		$sql = "SELECT COUNT(DeudaPeopleGradoId) cantidad_deudaPeople
				FROM DeudaPeopleGrado
				";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		$cantidad = 0;
		
		if( $this->persistencia->getNext( ) )
			$cantidad = $this->persistencia->getParametro( "cantidad_deudaPeople" );
		
		$this->persistencia->freeResult( );
		
		return $cantidad;
				
	}
	
	/**
	 * Eliminar Deuda People
	 * @access public
	 * @return void
	 */
	public function eliminarDeudaPeople( ){
		
		$sql = "DELETE 
				FROM DeudaPeopleGrado
				";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
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