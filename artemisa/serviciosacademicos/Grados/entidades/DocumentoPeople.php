<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Dirección de Tecnología - Universidad el Bosque
    * @package entidades
    */
   
   
   class DocumentoPeople{
   	
	/**
	 * @type int
	 * @access private
	 */
	private $idDocumentoPeople;
	
	/**
	 * @type TipoDocumento
	 * @access private
	 */
	private $tipoDocumento;
	
	/**
	 * @type string
	 * @access private
	 */
	private $codigoDocumentoPeople;
	
	/**
	 * @type string
	 * @access private
	 */
	private $descripcionDocumentoPeople;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoDocumentoPeople;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function DocumentoPeople( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el id Documento de People
	 * @param int $idDocumentoPeople
	 * @access public
	 * @return void
	 */
	public function setIdDocumentoPeople( $idDocumentoPeople ){
		$this->idDocumentoPeople = $idDocumentoPeople;
	}
	
	/**
	 * Retorna el id Documento de People
	 * @access public
	 * @return int
	 */
	public function getIdDocumentoPeople( ){
		return $this->idDocumentoPeople;
	}
	
	/**
	 * Modifica el tipo de documento de sala en people
	 * @param $tipoDocumento TipoDocumento
	 * @access public
	 * @return void
	 */
	public function setTipoDocumentoPeople( $tipoDocumento ){
		$this->tipoDocumento = $tipoDocumento;
	}
	
	/**
	 * Retorna el tipo de documento de sala en people
	 * @access public
	 * @return TipoDocumento
	 */
	public function getTipoDocumentoPeople( ){
		return $this->tipoDocumento;
	}
	
	/**
	 * Modifica el codigo de documento de people
	 * @param $codigoDocumentoPeople string
	 * @access public
	 * @return void
	 */
	public function setCodigoDocumentoPeople( $codigoDocumentoPeople ){
		$this->codigoDocumentoPeople = $codigoDocumentoPeople;
	}
	
	/**
	 * Retorna el codigo de documento de people
	 * @access public
	 * @return string
	 */
	public function getCodigoDocumentoPeople( ){
		return $this->codigoDocumentoPeople;
	}
	
	/**
	 * Modifica la descripcion de documento de people
	 * @param $descripcionDocumentoPeople string
	 * @access public
	 * @return void
	 */
	public function setDescripcionDocumentoPeople( $descripcionDocumentoPeople ){
		$this->descripcionDocumentoPeople = $descripcionDocumentoPeople;
	}
	
	/**
	 * Retorna la descripcion de documento de people
	 * @access public
	 * @return string
	 */
	public function getDescripcionDocumentoPeople( ){
		return $this->descripcionDocumentoPeople;
	}
	
	/**
	 * Modifica el estado de documento de people
	 * @param $estadoDocumentoPeople int
	 * @access public
	 * @return void
	 */
	public function setEstadoDocumentoPeople( $estadoDocumentoPeople ){
		$this->estadoDocumentoPeople = $estadoDocumentoPeople;
	}
	
	/**
	 * Retorna el estado de documento de people
	 * @access public
	 * @return int
	 */
	public function getEstadoDocumentoPeople( ){
		return $this->estadoDocumentoPeople;
	}
	
	/**
	 * Buscar Tipo Documento People
	 * @param $txtTipoDocumento
	 * @access public
	 */
	public function buscarTipoDocumentoPeople( $txtTipoDocumento ){
		
		$sql = "SELECT codigodocumentopeople
				FROM documentopeople
				WHERE tipodocumentosala = ?
				";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtTipoDocumento , false );
		
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setCodigoDocumentoPeople( $this->persistencia->getParametro( "codigodocumentopeople" ) );
		}
		
		$this->persistencia->freeResult( );
		
	}
	
	
	
	
	
   }
?>