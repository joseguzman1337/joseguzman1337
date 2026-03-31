<?php
/**
 * @author Diego Fernando Rivera Castro <rivedadiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 * @since enero  23, 2017
 */ 
 class Documento{
 	
	/**
	 * @type int
	 * @access private
	 */
	private $tipoDocumento;
	
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
	public function Documento( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el tipo de documento del estudiante
	 * @param int $tipoDocumento
	 * @access public
	 * @return void
	 */
	public function setTipoDocumento( $tipoDocumento ){
		$this->tipoDocumento=$tipoDocumento;
	}
	
	/**
	 * Retorna el tipo de Documento del Estudiante
	 * @access public
	 * @return int
	 */
	public function getTipoDocumento( ){
		return $this->tipoDocumento;
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
	 * @return array
	 */
	public function consultar( ){
		$tipoDocumentos = array( );
		$sql = "SELECT tipodocumento, nombredocumento 
				FROM documento
				WHERE codigoestado = 100
				";
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$tipoDocumento = new Documento( null );
			$tipoDocumento->setTipoDocumento( $this->persistencia->getParametro( "tipodocumento" ) );
			$tipoDocumento->setDescripcion( $this->persistencia->getParametro( "nombredocumento" ) );
			$tipoDocumentos[] = $tipoDocumento;
		}
		
		$this->persistencia->freeResult( );
		return $tipoDocumentos;
	}
	
	
 }
 
?>