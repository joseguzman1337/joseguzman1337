<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class OrdenPago{
  	
	
	/**
	 * @type int
	 * @access private
	 */
	private $numeroOrden;
	
	/**
	 * @type @date
	 * @access private
	 */
	private $fechaOrden;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoOrden;
	
	/**
	 * @type DetalleOrden
	 * @access private
	 */
	private $detalleOrdenPago;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function OrdenPago( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el numero de orden de pago
	 * @param int $numeroOrden
	 * @access public
	 * @return void
	 */
	public function setNumeroOrden( $numeroOrden ){
		$this->numeroOrden = $numeroOrden;
	}
	
	/**
	 * Retorna el numero de orden de pago
	 * @access public
	 * @return int
	 */
	public function getNumeroOrden( ){
		return $this->numeroOrden;
	}
	
	/**
	 * Modifica la fecha de la orden
	 * @param date $fechaOrden
	 * @access public 
	 * @return void
	 */
	public function setFechaOrden( $fechaOrden ){
		$this->fechaOrden = $fechaOrden;
	}
	
	/**
	 * Retorna la fecha de la orden
	 * @access public
	 * @return date
	 */
	public function getFechaOrden( ){
		return $this->fechaOrden;
	}
	
	/**
	 * Modifica el estado de la orden
	 * @param int $estadoOrden
	 * @access public
	 * @return void
	 */
	public function setEstadoOrden( $estadoOrden ){
		$this->estadoOrden = $estadoOrden;
	}
	
	/**
	 * Retorna el estado de la orden
	 * @access public
	 * @return int
	 */
	public function getEstadoOrden( ){
		return $this->estadoOrden;
	}
	
	/**
	 * Modifica el Detalle de la orden
	 * @param DetalleOrdenPago $detalleOrden
	 * @access public
	 * @return void
	 */
	public function setDetalleOrdenPago( $detalleOrdenPago ){
		$this->detalleOrdenPago = $detalleOrdenPago;
	}
	
	/**
	 * Retorna el Detalle de la orden
	 * @access public
	 * @return DetalleOrdenPago
	 */
	public function getDetalleOrdenPago( ){
		return $this->detalleOrdenPago;
	}
	
  }
?>