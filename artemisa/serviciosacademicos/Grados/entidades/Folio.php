<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Dirección de Tecnología - Universidad el Bosque
   * @package entidades
   */
  
  class Folio{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $idFolio;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaRegistroFolio;
	
	/**
	 * @type Usuario
	 * @access private 
	 */
	private $usuario;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoFolio;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia; 
	
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function Folio( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el id del folio
	 * @param int $idFolio
	 * @access public 
	 * @return void
	 */
	public function setIdFolio( $idFolio ){
		$this->idFolio = $idFolio;
	}
	
	/**
	 * Retorna el id del Folio
	 * @access public
	 * @return int
	 */
	public function getIdFolio( ){
		return $this->idFolio;
	}
	
	/**
	 * Modifica la fecha de registro del folio
	 * @param int $fechaRegistroFolio
	 * @access public
	 * @return void
	 */
	public function setFechaRegistroFolio( $fechaRegistroFolio ){
		$this->fechaRegistroFolio = $fechaRegistroFolio;
	}
	
	/**
	 * Retorna le fecha del registro del folio
	 * @access public
	 * @return date
	 */
	public function getFechaRegistroFolio( ){
		return $this->fechaRegistroFolio;
	}
	
	/**
	 * Modifica el usuario del folio
	 * @param $usuario Usuario
	 * @access public
	 * @return void
	 */
	public function setUsuario( $usuario ){
		$this->usuario = $usuario;
	}
	
	/**
	 * Retorna el usuario del folio
	 * @access public
	 * @return Usuario
	 */
	public function getUsuario( ){
		return $this->usuario;
	}
	
	/**
	 * Modifica el estado del folio 
	 * @param int $estadoFolio
	 * @access public
	 * @return void
	 */
	public function setEstadoFolio( $estadoFolio ){
		$this->estadoFolio = $estadoFolio;
	}
	
	/**
	 * Retorna el estado del folio
	 * @access public
	 * @return int
	 */
	public function getEstadoFolio( ){
		return $this->estadoFolio;
	}
	
	/**
	 * Buscar Maximo IdFolio + 1
	 * @access public
	 * @return Directivo
	 */
	public function buscarMaximoFolio( ){
		
		$sql = "SELECT MAX(RGF.idregistrograduadofolio) + 1 AS maximoFolio
				FROM registrograduadofolio RGF";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		$cantidad = 0;
		
		if( $this->persistencia->getNext( ) )
			$cantidad = $this->persistencia->getParametro( "maximoFolio" );
		
		$this->persistencia->freeResult( );
		
		return $cantidad;
		
	}	
	
	/**
	 * Insertar Folio 
	 * @access public
	 * @return boolean
	 * @author Andres Ariza <arizaandres@unbosque.edu.co> 
	 */
	public function insertarFolio($txtNumeroFolio, $idPersona){
		$sql = "INSERT INTO registrograduadofolio (
					idregistrograduadofolio,
					fecharegistrograduadofolio,
					idusuario,
					codigoestado
				)
				VALUES
					(?,NOW(), ?, '100');
				";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtNumeroFolio , false );
		$this->persistencia->setParametro( 1 , $idPersona , false );
		//echo $this->persistencia->getSQLListo( ).'<br><br>';
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