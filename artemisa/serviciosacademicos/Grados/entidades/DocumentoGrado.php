<?php
    /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Dirección de Tecnología - Universidad el Bosque
   * @package entidades
   */
  
  class DocumentoGrado{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $idDocumentoGrado;
	
	/**
	 * @type RegistroGrado
	 * @access private
	 */
	private $registroGrado;
	
	/**
	 * @type Directivo
	 * @access private
	 */
	private $directivo;
	
	/**
	 * @type TipoDocumentoGrado
	 * @access private
	 */
	private $tipoDocumentoGrado;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoDocumentoGrado;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia Singleton
	 */
	public function DocumentoGrado( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el id del documento de grado
	 * @param int $idDocumentoGrado
	 * @access public
	 * @return void
	 */
	public function setIdDocumentoGrado( $idDocumentoGrado ){
		$this->idDocumentoGrado = $idDocumentoGrado;
	}
	
	/**
	 * Retorna el id del documento de grado
	 * @access public
	 * @return int
	 */
	public function getIdDocumentoGrado( ){
		return $this->idDocumentoGrado;
	}
	
	/**
	 * Modifica el registrogrado del documento de grado
	 * @param int $registroGrado
	 * @access public
	 * @return void
	 */
	public function setRegistroGrado( $registroGrado ){
		$this->registroGrado = $registroGrado;
	}
	
	/**
	 * Retorna el registrogrado del documento de grado
	 * @access public
	 * @return RegistroGrado
	 */
	public function getRegistroGrado( ){
		return $this->registroGrado;
	}
	
	/**
	 * Modifica el directivo del documento de grado
	 * @param int $directivo
	 * @access public
	 * @return void
	 */
	public function setDirectivo( $directivo ){
		$this->directivo = $directivo;
	}
	
	/**
	 * Retorna el directivo del documento de grado
	 * @access public
	 * @return Directivo
	 */
	public function getDirectivo( ){
		return $this->directivo;
	}
	
	/**
	 * Modifica el tipo documento grado del documento de grado
	 * @param int $tipoDocumentoGrado
	 * @access public
	 * @return void
	 */
	public function setTipoDocumentoGrado( $tipoDocumentoGrado ){
		$this->tipoDocumentoGrado = $tipoDocumentoGrado;
	}
	
	/**
	 * Retorna el tipo documento grado del documento de grado
	 * @access public
	 * @return TipoDocumentoGrado
	 */
	public function getTipoDocumentoGrado( ){
		return $this->tipoDocumentoGrado;
	}
	
	/**
	 * Modifica el estado documento de grado
	 * @param int $tipoDocumentoGrado
	 * @access public
	 * @return void
	 */
	public function setEstadoDocumentoGrado( $estadoDocumentoGrado ){
		$this->estadoDocumentoGrado = $estadoDocumentoGrado;
	}
	
	/**
	 * Retorna el estado del documento de grado
	 * @access public
	 * @return int
	 */
	public function getEstadoDocumentoGrado( ){
		return $this->estadoDocumentoGrado;
	}
	
	/**
	 * Inserta el registro de firmas
	 * @access public
	 * @return Boolean 
	 */
	public function crearFirmaDocumentoGrado( $txtIdRegistroGrado, $txtIdIncentivo, $txtIdDirectivo, $txtCodigoTipoDocumentoGrado, $txtCodigoIncentivo ){
		$sql = "INSERT INTO documentograduado (
					idregistrograduado,
					idregistroincentivoacademico,
					iddirectivo,
					codigoestado,
					codigotipodocumentograduado,
					idincentivoacademico
				)
				VALUES
					(?, ?, ?, '100', ?, ?);";	
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtIdRegistroGrado , false );
		$this->persistencia->setParametro( 1 , $txtIdIncentivo , false );
		$this->persistencia->setParametro( 2 , $txtIdDirectivo , false );
		$this->persistencia->setParametro( 3 , $txtCodigoTipoDocumentoGrado , false );
		$this->persistencia->setParametro( 4 , $txtCodigoIncentivo , false );
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