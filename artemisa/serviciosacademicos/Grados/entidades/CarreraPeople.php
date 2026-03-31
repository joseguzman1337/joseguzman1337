<?php
  /**
   * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class CarreraPeople{
  	
	
	/**
	 * @type int
	 * @access private
	 */
	private $idCarreraPeople;
	
	/**
	 * @type Carrera
	 * @access private
	 */
	private $carrera;
	
	/**
	 * @type Concepto
	 * @access private
	 */
	private $concepto;
	
	/**
	 * @type String
	 * @access private
	 */
	private $itemPeople;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreCarreraPeople;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaCarreraPeople;
	
	/**
	 * @type string
	 * @access private
	 */
	private $tipoCuenta;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoCarreraPeople;
	
	/**
	 * @type int
	 * @access private
	 */
	private $cargoPago;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia
	 */
	public function CarreraPeople( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador de la carrera de people
	 * @param int $idCarreraPeople
	 * @access public
	 * @return void
	 */
	public function setIdCarreraPeople( $idCarreraPeople ){
		$this->idCarreraPeople = $idCarreraPeople;
	}
	
	/**
	 * Retorna el identificador de la carrera de people
	 * @access public
	 * @return int
	 */
	public function getIdCarreraPeople( ){
		return $this->idCarreraPeople;
	}
	
	/**
	 * Modifica la carrera del people
	 * @param Carrera $carrera
	 * @access public
	 * @return void
	 */
	public function setCarrera( $carrera ){
		$this->carrera = $carrera;
	}
	
	/**
	 * Retorna la carrera del people
	 * @access public
	 * @return Carrera
	 */
	public function getCarrera( ){
		return $this->carrera;
	}
	
	/**
	 * Modifica el concepto de la carrera de people
	 * @param Concepto $concepto
	 * @access public
	 * @return void
	 */
	public function setConcepto( $concepto ){
		$this->concepto = $concepto;
	}
	
	/**
	 * Retorna el concepto de la carrera de people
	 * @access public
	 * @return Concepto
	 */
	public function getConcepto( ){
		return $this->concepto;
	}
	
	/**
	 * Modifica el item de la carrera de people
	 * @param string $itemPeople
	 * @access public
	 * @return void
	 */
	public function setItemPeople( $itemPeople ){
		$this->itemPeople = $itemPeople;
	}
	
	/**
	 * Retorna el item de la carrera de people
	 * @access public
	 * @return string
	 */
	public function getItemPeople( ){
		return $this->itemPeople;
	}
	
	/**
	 * Modifica el nombre de la carrera de peopple
	 * @param string $nombreCarreraPeople
	 * @access public
	 * @return void
	 */
	public function setNombreCarreraPeople( $nombreCarreraPeople ){
		$this->nombreCarreraPeople = $nombreCarreraPeople;
	}
	
	/**
	 * Retorna el nombre de la carrera de peopple
	 * @access public
	 * @return string 
	 */
	public function getNombreCarreraPeople( ){
		return $this->nombreCarreraPeople;
	}
	
	/**
	 * Modifica la fecha de la carrera de people
	 * @param date $fechaCarreraPeople
	 * @access public
	 * @return void
	 */
	public function setFechaCarreraPeople( $fechaCarreraPeople ){
		$this->fechaCarreraPeople = $fechaCarreraPeople;
	}
	
	/**
	 * Retorna la fecha de la carrera de people
	 * @access public
	 * @return date
	 */
	public function getFechaCarreraPeople( ){
		return $this->fechaCarreraPeople;
	}
	
	/**
	 * Modifica el tipo de cuenta de la carrera de people
	 * @param string $tipoCuenta
	 * @access public
	 * @return void
	 */
	public function setTipoCuenta( $tipoCuenta ){
		$this->tipoCuenta = $tipoCuenta;
	}
	
	/**
	 * Retorna el tipo de cuenta de la carrera de people
	 * @access public
	 * @return string
	 */
	public function getTipoCuenta( ){
		return $this->tipoCuenta;
	}
	
	/**
	 * Modifica el estado de la carrera de people
	 * @param int $estadoCarreraPeople
	 * @access public
	 * @return void
	 */
	public function setEstadoCarreraPeople( $estadoCarreraPeople ){
		$this->estadoCarreraPeople = $estadoCarreraPeople;
	}
	
	/**
	 * Retorna el estado de la carrera de people
	 * @access public
	 * @return int
	 */
	public function getEstadoCarreraPeople( ){
		return $this->estadoCarreraPeople;
	}
	
	/**
	 * Modifica el cargo de pago de la carrera de people
	 * @param int $cargoPago
	 * @access public
	 * @return void
	 */
	public function setCargoPago( $cargoPago ){
		$this->cargoPago = $cargoPago;
	}
	
	/**
	 * Retorna el cargo de pago de la carrera de people
	 * @access public
	 * @return int
	 */
	public function getCargoPago( ){
		return $this->cargoPago;
	}
	
	/**
	 * Consultar Pagos Pendientes por Orden de Pago
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return Array
	 */
	public function buscarCarreraPeople( ){
		$sql = "SELECT ccp.idcarreraconceptopeople, c.codigoconcepto, c.nombreconcepto
				FROM carreraconceptopeople ccp, concepto c 
				WHERE c.codigoconcepto = ccp.codigoconcepto AND 
				ccp.itemcarreraconceptopeople = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getItemPeople( ) , false );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			//$carreraPeople = new CarreraPeople( $this->persistencia );
			$this->setIdCarreraPeople( $this->persistencia->getParametro( "idcarreraconceptopeople" ) );
						
			$concepto = new Concepto( null );
			$concepto->setCodigoConcepto( $this->persistencia->getParametro( "codigoconcepto" ) );
			$concepto->setNombreConcepto( $this->persistencia->getParametro( "nombreconcepto" ) );
			
			$this->setConcepto( $concepto );
		}
		$this->persistencia->freeResult( );
	}
	
  }
?>