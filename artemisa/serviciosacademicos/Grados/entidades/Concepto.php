<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class Concepto{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoConcepto;
	
	/**
	 * @type string
	 * @access private
	 */
	private $nombreConcepto;
	
	/**
	 * @type int
	 * @access private
	 */
	private $cuentaPrincipal;
	
	/**
	 * @type OrdenPago
	 * @access private
	 */
	private $ordenPago;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function Concepto( $persistencia){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo del Concepto
	 * @param int $codigoConcepto
	 * @access public
	 * @return void
	 */
	public function setCodigoConcepto( $codigoConcepto ){
		$this->codigoConcepto = $codigoConcepto;
	}
	
	/**
	 * Retorna el codigo del Concepto
	 * @access public
	 * @return int
	 */
	public function getCodigoConcepto( ){
		return $this->codigoConcepto;
	}
	
	/**
	 * Modifica el nombre del Concepto
	 * @param string $nombreConcepto
	 * @access public
	 * @return void
	 */
	public function setNombreConcepto( $nombreConcepto ){
		$this->nombreConcepto = $nombreConcepto;
	}
	
	/**
	 * Retorna el nombre del Concepto
	 * @access public
	 * @return string
	 */
	public function getNombreConcepto( ){
		return $this->nombreConcepto;
	}
	
	/**
	 * Modifica la cuenta principal del Concepto
	 * @param int $cuentaPrincipal
	 * @access public
	 * @return void
	 */
	public function setCuentaPrincipal( $cuentaPrincipal ){
		$this->cuentaPrincipal = $cuentaPrincipal;
	}
	
	/**
	 * Retorna la cuenta principal del Concepto
	 * @access public
	 * @return int
	 */
	public function getCuentaPrincipal( ){
		return $this->cuentaPrincipal;
	}
	
	/**
	 * Modifica la orden de pago del concepto
	 * @param OrdenPago $ordenPago
	 * @access public
	 * @return void
	 */
	public function setOrdenPago( $ordenPago ){
		$this->ordenPago = $ordenPago;
	}
	
	/**
	 * Retorna la orden de pago del concepto
	 * @access public
	 * @return OrdenPago
	 */
	public function getOrdenPago( ){
		return $this->ordenPago;
	}
	
	/**
	 * Buscar Si existe Pago Derechos de Grado Estudiante
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return int
	 */
	public function buscar( $txtCodigoEstudiante ){
		$sql = "SELECT count(c.codigoconcepto) as cantidad
				FROM
				concepto c, ordenpago op, detalleordenpago dop
				WHERE
				op.numeroordenpago=dop.numeroordenpago
				AND	op.codigoestudiante = ?
				AND c.codigoconcepto=dop.codigoconcepto
				AND c.cuentaoperacionprincipal='108'
				AND op.codigoestadoordenpago like '4%'";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante, false );
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			return $this->persistencia->getParametro( "cantidad" );
		}
		return 0;
		
	}
	
	
	/**
	 * Buscar Pago Derechos de Grado Estudiante
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return int
	 */
	public function buscarEstudianteDG( $txtCodigoEstudiante ){
		$sql = "SELECT c.codigoconcepto, c.nombreconcepto
				FROM
				concepto c, ordenpago op, detalleordenpago dop
				WHERE
				op.numeroordenpago=dop.numeroordenpago
				AND	op.codigoestudiante = ?
				AND c.codigoconcepto=dop.codigoconcepto
				AND c.cuentaoperacionprincipal='108'
				AND op.codigoestadoordenpago like '4%'";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			$this->setCodigoConcepto( $this->persistencia->getParametro( "codigoconcepto" ) );
			$this->setNombreConcepto( $this->persistencia->getParametro( "nombreconcepto" ) );
		}
		$this->persistencia->freeResult( );
	}
	
	
	/**
	 * Existe Otros
	 * @param int $txtCodigoEstudiante, $txtCodigoPeriodo
	 * @access public
	 * @return void
	 */
	public function buscarExisteOtros( $txtCodigoEstudiante, $txtCodigoPeriodo ){
		$sql = "SELECT COUNT(numeroordenpago) AS cantidad_otros FROM ( SELECT OP.numeroordenpago
				FROM concepto C
					INNER JOIN detalleordenpago DOP ON ( DOP.codigoconcepto = C.codigoconcepto )
					INNER JOIN ordenpago OP ON ( OP.numeroordenpago = DOP.numeroordenpago )
					INNER JOIN estadoordenpago EO ON ( EO.codigoestadoordenpago = OP.codigoestadoordenpago)
					WHERE OP.codigoestudiante = ?
					AND (OP.codigoestadoordenpago LIKE '1%' OR OP.codigoestadoordenpago LIKE '6%')
					AND OP.codigoperiodo = ?
					AND C.cuentaoperacionprincipal != 108
					GROUP BY OP.numeroordenpago ) B";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante, false );
		$this->persistencia->setParametro( 1 , $txtCodigoPeriodo, false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		if( $this->persistencia->getNext( ) ){
			return $this->persistencia->getParametro( "cantidad_otros" );
		}
		return 0;
	}
	
	/**
	 * Consultar Otros
	 * @param int $txtCodigoEstudiante, $txtCodigoPeriodo
	 * @access public
	 * @return Array
	 */
	public function consultarOtros( $txtCodigoEstudiante, $txtCodigoPeriodo ){
		$conceptos = array( );
		$sql = "SELECT C.codigoconcepto,
				C.nombreconcepto,
				SUM(DOP.valorconcepto) AS valorconcepto,
				OP.fechaordenpago,
				EO.nombreestadoordenpago, OP.numeroordenpago 
				FROM concepto C
				INNER JOIN detalleordenpago DOP ON ( DOP.codigoconcepto = C.codigoconcepto )
				INNER JOIN ordenpago OP ON ( OP.numeroordenpago = DOP.numeroordenpago )
				INNER JOIN estadoordenpago EO ON ( EO.codigoestadoordenpago = OP.codigoestadoordenpago)
				WHERE OP.codigoestudiante = ?
				AND (OP.codigoestadoordenpago LIKE '1%' OR OP.codigoestadoordenpago LIKE '6%')
				AND OP.codigoperiodo = ?
				AND C.cuentaoperacionprincipal != 108
				GROUP BY OP.numeroordenpago";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtCodigoEstudiante , false );
		$this->persistencia->setParametro( 1 , $txtCodigoPeriodo , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$concepto = new Concepto( $this->persistencia );
			$concepto->setCodigoConcepto( $this->persistencia->getParametro( "codigoconcepto" ) );
			$concepto->setNombreConcepto( $this->persistencia->getParametro( "nombreconcepto" ) );
			
			$ordenPago = new OrdenPago( null );
			$ordenPago->setFechaOrden( $this->persistencia->getParametro( "fechaordenpago" ) );
			$ordenPago->setEstadoOrden( $this->persistencia->getParametro( "nombreestadoordenpago" ) );
			$ordenPago->setNumeroOrden( $this->persistencia->getParametro( "numeroordenpago" ) );
			
			$detalleOrdenPago = new DetalleOrdenPago( null );
			$detalleOrdenPago->setValorConcepto( $this->persistencia->getParametro( "valorconcepto" ) );
			
			$ordenPago->setDetalleOrdenPago( $detalleOrdenPago );
			
			$concepto->setOrdenPago( $ordenPago );
			
			
			$conceptos[ count( $conceptos ) ] = $concepto;
		}
		$this->persistencia->freeResult( );
		
		return $conceptos;
	}

	/**
	 * Consultar Pagos Pendientes por Orden de Pago
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return Array
	 */
	public function consultarConceptoOrdenPago( $txtNumeroOrdenPago ){
		$conceptos = array( );
		$sql = "SELECT C.nombreconcepto , DOP.valorconcepto
				FROM concepto C
				INNER JOIN detalleordenpago DOP ON ( DOP.codigoconcepto = C.codigoconcepto )
				INNER JOIN ordenpago OP ON ( OP.numeroordenpago = DOP.numeroordenpago )
				WHERE OP.numeroordenpago = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtNumeroOrdenPago , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		while( $this->persistencia->getNext( ) ){
			$concepto = new Concepto( $this->persistencia );
			$concepto->setNombreConcepto( $this->persistencia->getParametro( "nombreconcepto" ) );
			
			$ordenPago = new OrdenPago( null );
			
			$detalleOrdenPago = new DetalleOrdenPago( null );
			$detalleOrdenPago->setValorConcepto( $this->persistencia->getParametro( "valorconcepto" ) );
			
			$ordenPago->setDetalleOrdenPago( $detalleOrdenPago );
			
			$concepto->setOrdenPago( $ordenPago );
			
			$conceptos[ count( $conceptos ) ] = $concepto;
		}
		$this->persistencia->freeResult( );
		
		return $conceptos;
		
	}
	
	
	
	
  }
?>