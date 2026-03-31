<?php
 /**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */ 
 
 class TipoDocumento{
 	
	/**
	 * @type int
	 * @access private
	 */
	private $iniciales;
	
	/**
	 * @type String
	 * @access private
	 */
	private $descripcion;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreDocumento;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoDocumento;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function TipoDocumento( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el tipo de documento del estudiante
	 * @param int $tipoDocumento
	 * @access public
	 * @return void
	 */
	public function setIniciales( $iniciales ){
		$this->iniciales = $iniciales;
	}
	
	/**
	 * Retorna el tipo de Documento del Estudiante
	 * @access public
	 * @return int
	 */
	public function getIniciales( ){
		return $this->iniciales;
	}
	
	/**
	 * Modifica la descripcion del documento del estudiante
	 * @param int $nombreDocumento
	 * @access public
	 * @return void
	 */
	public function setDescripcion( $descripcion ){
		$this->descripcion = $descripcion;
	}
	
	/**
	 * Retorna la descripcion del Documento del Estudiante
	 * @access public
	 * @return int
	 */
	public function getDescripcion( ){
		return $this->descripcion;
	}
	
	/**
	 * Modifica el nombre del documento del estudiante
	 * @param int $nombreDocumento
	 * @access public
	 * @return void
	 */
	public function setNombreDocumento( $nombreDocumento ){
		$this->nombreDocumento = $nombreDocumento;
	}
	
	/**
	 * Retorna el nombre del Documento del Estudiante
	 * @access public
	 * @return int
	 */
	public function getNombreDocumento( ){
		return $this->nombreDocumento;
	}
	
	/**
	 * Modifica el estado del Documento del estudiante
	 * @param int $estadoDocumento
	 * @access public
	 * @return void
	 */
	public function setEstadoDocumento( $estadoDocumento ){
		$this->estadoDocumento = $estadoDocumento;
	}
	
	/**
	 * Retorna el estado del Documento del estudiante
	 * @access public
	 * @return int
	 */
	public function getEstadoDocumento( ){
		return $this->estadoDocumento;
	}
	
	
	/**
	 * Consultar Tipo de Documento
	 * @access public
	 */
	public function consultar( ){
		$tipoDocumentos = array( );
		$sql = "SELECT tipodocumento, nombredocumento 
				FROM documento
				WHERE codigoestado = 100
				AND tipodocumento != 0";
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$tipoDocumento = new TipoDocumento( null );
			$tipoDocumento->setIniciales( $this->persistencia->getParametro( "tipodocumento" ) );
			$tipoDocumento->setDescripcion( $this->persistencia->getParametro( "nombredocumento" ) );
			
			$tipoDocumentos[ count( $tipoDocumentos ) ] = $tipoDocumento;
		}
		return $tipoDocumentos;
	}
	
	
 }
 
?>