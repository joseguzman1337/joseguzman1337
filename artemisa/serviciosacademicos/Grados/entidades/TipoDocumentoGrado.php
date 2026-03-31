<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Dirección de Tecnología - Universidad el Bosque
   * @package entidades
   */
  
  class TipoDocumentoGrado{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoTipoDocumentoGrado;
	
	/**
	 * @type string
	 * @access private
	 */
	private $nombreTipoDocumentoGrado;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoTipoDocumentoGrado;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia Singleton
	 */
	public function TipoDocumentoGrado( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo tipo documento grado
	 * @param int $codigoTipoDocumentoGrado
	 * @access public
	 * @return void
	 */
	public function setCodigoTipoDocumentoGrado( $codigoTipoDocumentoGrado ){
		$this->codigoTipoDocumentoGrado = $codigoTipoDocumentoGrado;
	}
	
	/**
	 * Retorna el codigo tipo documento grado
	 * @access public
	 * @return int
	 */
	public function getCodigoTipoDocumentoGrado( ){
		return $this->codigoTipoDocumentoGrado;
	}
	
	/**
	 * Modifica el nombre del tipodocumento Grado
	 * @param string $nombreTipoDocumentoGrado
	 * @access public
	 * @return void
	 */
	public function setNombreTipoDocumentoGrado( $nombreTipoDocumentoGrado ){
		$this->nombreTipoDocumentoGrado = $nombreTipoDocumentoGrado;
	}
	
	/**
	 * Retorna el nombre del tipodocumento Grado
	 * @access public
	 * @return string
	 */
	public function getNombreTipoDocumentoGrado( ){
		return $this->nombreTipoDocumentoGrado;
	}
	
	/**
	 * Modifica el estado del tipodocumento Grado
	 * @param int $estadoTipoDocumentoGrado
	 * @access public
	 * @return void
	 */
	public function setEstadoTipoDocumentoGrado( $estadoTipoDocumentoGrado ){
		$this->estadoTipoDocumentoGrado = $estadoTipoDocumentoGrado;
	}
	
	/**
	 * Retorna el estado del tipodocumento Grado
	 * @access public
	 * @return int
	 */
	public function getEstadoTipoDocumentoGrado( ){
		return $this->estadoTipoDocumentoGrado;
	}
	
	/**
	 * Consultar Tipo Documento Grado
	 * @access public
	 * @return Array<TipoDocumentoGrado>
	 */
	public function consultarTipoDocumentoGrado( ){
		$tipoDocumentoGrados = array( );
		$sql = "SELECT
					codigotipodocumentograduado,
					nombretipodocumentograduado,
					codigoestado
				FROM
					tipodocumentograduado
				WHERE
					codigoestado = 100";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$tipoDocumentoGrado = new TipoDocumentoGrado( null );
			$tipoDocumentoGrado->setCodigoTipoDocumentoGrado( $this->persistencia->getParametro( "codigotipodocumentograduado" ) );
			$tipoDocumentoGrado->setNombreTipoDocumentoGrado( $this->persistencia->getParametro( "nombretipodocumentograduado" ) );
			$tipoDocumentoGrado->setEstadoTipoDocumentoGrado( $this->persistencia->getParametro( "codigoestado" ) );				
			
			$tipoDocumentoGrados[ count( $tipoDocumentoGrados ) ] = $tipoDocumentoGrado;
		}
		return $tipoDocumentoGrados;		
		
		
	}
	
	
  }
?>