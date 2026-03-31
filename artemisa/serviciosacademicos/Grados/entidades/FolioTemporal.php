<?php
  /**
   * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Dirección de Tecnología - Universidad el Bosque
   * @package entidades
   */
  
  class FolioTemporal{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $idFolioTemporal;
	
	/**
	 * @type RegistroGrado
	 * @access private
	 */
	private $registroGrado;
	
	/**
	 * @type int
	 * @access private
	 */
	private $numeroFolio;
	
	/**
	 * @type int
	 * @access provate
	 */
	private $estadoFolioTemporal;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function FolioTemporal( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el id del folio temporal
	 * @param int $idFolioTemporal
	 * @access public
	 * @return void
	 */
	public function setIdFolioTemporal( $idFolioTemporal ){
		$this->idFolioTemporal = $idFolioTemporal;
	}
	
	/**
	 * Retorna el id del folio temporal
	 * @access public
	 * @return int
	 */
	public function getIdFolioTemporal( ){
		return $this->idFolioTemporal;
	}
	
	/**
	 * Modifica el registro de grado del folio temporal
	 * @param $registroGrado RegistroGrado
	 * @access public
	 * @return void
	 */
	public function setRegistroGrado( $registroGrado ){
		$this->registroGrado = $registroGrado;
	}
	
	/**
	 * Retorna el registro de grado del folio temporal
	 * @access public
	 * @return RegistroGrado
	 */
	public function getRegistroGrado( ){
		return $this->registroGrado;
	}
	
	/**
	 * Modifica el número de folio del folio temporal
	 * @param $folio Folio
	 * @access public
	 * @return void  
	 */
	public function setNumeroFolio( $numeroFolio ){
		$this->numeroFolio = $numeroFolio;
	}
	
	/**
	 * Retorna el número de folio del folio temporal
	 * @access public
	 * @return Folio
	 */
	public function getNumeroFolio( ){
		return $this->numeroFolio;
	}
	
	/**
	 * Modifica el estado del folio temporal
	 * @param int $estadoFolioTemporal
	 * @access public
	 * @return void
	 */
	public function setEstadoFolioTemporal( $estadoFolioTemporal ){
		$this->estadoFolioTemporal = $estadoFolioTemporal;
	}
	
	/**
	 * Retorna el estado del folio temporal
	 * @access public
	 * @return int
	 */
	public function getEstadoFolioTemporal( ){
		return $this->estadoFolioTemporal;
	}
	
	/**
	 * Insertar Folio Temporal
	 * @access public
	 * @return boolean 
	 */
	public function crearFolioTemporal( $txtIdRegistroGrado, $txtNumeroFolio ){
		$sql = "INSERT INTO foliotemporal (
					idfoliotemporal,
					idregistrograduado,
					folio,
					codigoestado
				)
				VALUES
					(0,?, ?, '100');
				";
		
		$this->persistencia->crearSentenciaSQL( $sql );


		$this->persistencia->setParametro( 0 , $txtIdRegistroGrado , false );
		$this->persistencia->setParametro( 1 , $txtNumeroFolio , false );
		
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
	 * Buscar Folio Temporal
	 * @param int $txtCodigoIncentivo
	 * @access public
	 * @return String
	 */
	public function buscarFolioTemporal( $txtIdRegistroGrado ){
		$sql = "SELECT idfoliotemporal , folio 
				FROM foliotemporal 
				WHERE idregistrograduado = ?
				AND codigoestado like '1%'";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtIdRegistroGrado , false );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setIdFolioTemporal( $this->persistencia->getParametro( "idfoliotemporal" ) );
			$this->setNumeroFolio( $this->persistencia->getParametro( "folio" ) );
		}
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->freeResult( );
	}
	
	/**
	 * Actualizar FolioTemporal
	 * @param int txtNumeroFolio, $txtIdRegistroGrado
	 * @access public
	 * @return void
	 */
	public function actualizarFolioTemporal( $txtNumeroFolio, $txtIdRegistroGrado ){
		
		$sql = "UPDATE foliotemporal 
				SET folio = ?
				WHERE idregistrograduado = ? 
				AND codigoestado LIKE '1%'";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtNumeroFolio , false );
		$this->persistencia->setParametro( 1 , $txtIdRegistroGrado , false );
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