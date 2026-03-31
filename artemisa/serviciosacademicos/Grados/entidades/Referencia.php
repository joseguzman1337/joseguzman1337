<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidades
 */

 class Referencia{
 	
		
	/**
	 * @type String
	 * @access private
	 */
	private $nombreReferencia;
	
	/**
	 * @type String
	 * @access private
	 */
	private $codigoReferencia;
	
	/**
	 * @type String
	 * @access private
	 */
	private $valorReferencia;
	
	/**
	 * @type int
	 * @access private
	 */
	private $descripcionReferencia;
	
	
	/**
	 * @type String
	 * @access private
	 */
	private $estadoReferencia;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function Referencia( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	
	/**
	 * Modifica el nombre de la Referencia
	 * @param String $nombreReferencia
	 * @access public
	 * @return void
	 */
	public function setNombreReferencia( $nombreReferencia ){
		$this->nombreReferencia = $nombreReferencia;
	}
	
	/**
	 * Retorna el nombre de la Referencia
	 * @access public
	 * @return String
	 */
	public function getNombreReferencia( ){
		return $this->nombreReferencia;
	}
	
	/**
	 * Modifica el codigo de la Referencia
	 * @param String $codigoReferencia
	 * @access public
	 * @return void
	 */
	public function setCodigoReferencia( $codigoReferencia ){
		$this->codigoReferencia = $codigoReferencia;
	}
	
	/**
	 * Retorna el codigo de la Referencia
	 * @access public
	 * @return String
	 */
	public function getCodigoReferencia( ){
		return $this->codigoReferencia;
	}
	
	
	/**
	 * Modifica el valor de la Referencia
	 * @param String $valorReferencia
	 * @access public
	 * @return void
	 */
	public function setValorReferencia( $valorReferencia ){
		$this->valorReferencia = $valorReferencia;
	}
	
	/**
	 * Retorna el valor de la Referencia
	 * @access public
	 * @return String
	 */
	public function getValorReferencia( ){
		return $this->valorReferencia;
	}
	
	/**
	 * Modifica la descripcion de la Referencia
	 * @param String $descripcionReferencia
	 * @access public
	 * @return void
	 */
	public function setDescripcionReferencia( $descripcionReferencia ){
		$this->descripcionReferencia = $descripcionReferencia;
	}
	
	/**
	 * Retorna la descripcion de la Referencia
	 * @access public
	 * @return String
	 */
	public function getDescripcionReferencia( ){
		return $this->descripcionReferencia;
	}
	
	
	/**
	 * Modifica el estado de la Referencia
	 * @param String $estadoReferencia
	 * @access public
	 * @return void
	 */
	public function setEstadoReferencia( $estadoReferencia ){
		$this->estadoReferencia = $estadoReferencia;
	}
	
	/**
	 * Retorna el estado de la Referencia
	 * @access public
	 * @return String
	 */
	public function getEstadoReferencia( ){
		return $this->estadoReferencia;
	}
	
	/**
	 * Consultar Tipos de Reportes
	 */
	public function consultar( ){
		$tipoReportes = array( );
		$sql = "SELECT ReferenciaGradoId , NombreReferenciaGrado
				FROM ReferenciaGrado 
				WHERE ValorReferenciaGrado = 'GRADO' 
				AND CodigoEstadoReferenciaGrado = 100
			";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
		$tipoReporte = new Referencia( null );
		$tipoReporte->setCodigoReferencia( $this->persistencia->getParametro( "ReferenciaGradoId" ) );
		$tipoReporte->setNombreReferencia( $this->persistencia->getParametro( "NombreReferenciaGrado" ) );	
		
		$tipoReportes[ count( $tipoReportes ) ] = $tipoReporte;
			
		}
		return $tipoReportes;
	}
	
	/**
	 * Consultar Tipos de Servicios
	 */
	public function consultarDocumentoDuplicado( ){
		$tipoReportes = array( );
		$sql = "SELECT ReferenciaGradoId , NombreReferenciaGrado
				FROM ReferenciaGrado 
				WHERE ValorReferenciaGrado = 'DODUPLICAD' 
				AND CodigoEstadoReferenciaGrado = 100
			";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
		$tipoReporte = new Referencia( null );
		$tipoReporte->setCodigoReferencia( $this->persistencia->getParametro( "ReferenciaGradoId" ) );
		$tipoReporte->setNombreReferencia( $this->persistencia->getParametro( "NombreReferenciaGrado" ) );	
		
		$tipoReportes[ count( $tipoReportes ) ] = $tipoReporte;
			
		}
		return $tipoReportes;
	}
	
	
	
 }
 
?>